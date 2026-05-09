<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    private function modelMap(): array
    {
        return [
            'problem-log' => \App\Models\ProblemLog::class,
            'device' => \App\Models\Device::class,
            'vendor' => \App\Models\Vendor::class,
            'product' => class_exists(\App\Models\Product::class) ? \App\Models\Product::class : null,
        ];
    }

    public function store(Request $request, string $type, int $id)
    {
        $map = $this->modelMap();

        abort_unless(isset($map[$type]) && $map[$type], 404);

        $modelClass = $map[$type];
        $model = $modelClass::findOrFail($id);

        $request->validate([
            'photos' => ['required', 'array'],
            'photos.*' => ['image', 'max:10240'],
            'attachment_group' => ['nullable', 'string', 'max:100'],
        ]);

        foreach ($request->file('photos', []) as $file) {
            $path = $file->store("attachments/{$type}/{$id}", 'public');

            Attachment::create([
                'attachable_type' => $modelClass,
                'attachable_id' => $model->id,
                'attachment_group' => $request->input('attachment_group', 'general'),
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by_user_id' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function destroy(Attachment $attachment)
    {
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return back()->with('success', 'Photo deleted successfully.');
    }
}
