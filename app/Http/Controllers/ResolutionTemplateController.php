<?php

namespace App\Http\Controllers;

use App\Models\ResolutionTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResolutionTemplateController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $items = ResolutionTemplate::with('images')
            ->where(function ($query) {
                $query->where('is_primary', true)->orWhereNull('canonical_group');
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('ai_title', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%")
                        ->orWhere('ai_category', 'like', "%{$q}%")
                        ->orWhere('symptom_keywords', 'like', "%{$q}%")
                        ->orWhere('resolution_steps', 'like', "%{$q}%")
                        ->orWhere('ai_summary', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('learning_score')
            ->orderByDesc('usage_count')
            ->orderBy('title')
            ->get();

        return view('resolution.index', compact('items', 'q'));
    }

    public function show(ResolutionTemplate $resolutionTemplate)
    {
        $resolutionTemplate->load('images', 'alternatives');
        return view('resolution.show', compact('resolutionTemplate'));
    }

    public function edit(ResolutionTemplate $resolutionTemplate)
    {
        abort_unless(in_array(auth()->user()->role ?? '', ['admin']), 403);

        $resolutionTemplate->load('images');
        return view('resolution.edit', compact('resolutionTemplate'));
    }

    public function update(Request $request, ResolutionTemplate $resolutionTemplate)
    {
        abort_unless(in_array(auth()->user()->role ?? '', ['admin']), 403);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'ai_title' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'ai_category' => ['nullable', 'string', 'max:255'],
            'symptom_keywords' => ['nullable', 'string'],
            'resolution_steps' => ['nullable', 'string'],
            'ai_summary' => ['nullable', 'string'],
            'ai_steps' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'kb_images.*' => ['nullable', 'image', 'max:8192'],
            'delete_image_ids' => ['nullable', 'array'],
            'delete_image_ids.*' => ['integer'],
        ]);

        $steps = collect(preg_split('/[\r\n]+/', (string) $request->ai_steps))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();

        $resolutionTemplate->update([
            'title' => $request->title,
            'ai_title' => $request->ai_title,
            'category' => $request->category,
            'ai_category' => $request->ai_category,
            'symptom_keywords' => $request->symptom_keywords,
            'resolution_steps' => $request->resolution_steps,
            'ai_summary' => $request->ai_summary,
            'ai_steps' => $steps,
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($request->filled('delete_image_ids')) {
            $images = $resolutionTemplate->images()->whereIn('id', $request->delete_image_ids)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        if ($request->hasFile('kb_images')) {
            foreach ($request->file('kb_images') as $file) {
                if (!$file) {
                    continue;
                }

                $path = $file->store('kb-images', 'public');

                $resolutionTemplate->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        try {
            app(\App\Services\ResolutionTemplateGroupingService::class)->regroupAll();
        } catch (\Throwable $e) {
            \Log::error('KB regroup failed after update', ['error' => $e->getMessage()]);
        }

        return redirect()->route('resolution-library.edit', $resolutionTemplate)
            ->with('success', 'Knowledge base updated.');
    }

    public function destroy(ResolutionTemplate $resolutionTemplate)
    {
        abort_unless(in_array(auth()->user()->role ?? '', ['admin']), 403);

        $resolutionTemplate->load('images');

        foreach ($resolutionTemplate->images as $image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }

        $resolutionTemplate->delete();

        return redirect()->route('resolution-library.index')
            ->with('success', 'Knowledge base deleted.');
    }

}

