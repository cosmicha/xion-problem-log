<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::withCount(['devices', 'problemLogs', 'issueCategories'])
            ->latest()
            ->get();

        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('vendors.create', [
            'vendor' => new Vendor(),
            'title' => 'Add Vendor',
            'action' => route('vendors.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['code'] = $data['code'] ?: Str::upper(Str::random(6));
        $data['status'] = $data['status'] ?: 'active';

        $vendor = Vendor::create($data);
        $this->syncCategories($vendor, $request->input('categories', []));

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['issueCategories', 'devices', 'problemLogs']);

        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $vendor->load('issueCategories');

        return view('vendors.edit', [
            'vendor' => $vendor,
            'title' => 'Edit Vendor',
            'action' => route('vendors.update', $vendor),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $this->validatedData($request, $vendor->id);
        $data['code'] = $data['code'] ?: $vendor->code;
        $data['status'] = $data['status'] ?: 'active';

        $vendor->update($data);
        $this->syncCategories($vendor, $request->input('categories', []));

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50', 'unique:vendors,code' . ($ignoreId ? ',' . $ignoreId : '')],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'scope_of_work' => ['nullable', 'string', 'max:5000'],
            'sow' => ['nullable', 'string'],
            'coverage_type' => ['nullable', 'string', 'max:5000'],
            'telegram_chat_id' => ['nullable', 'string', 'max:100'],
        ]);
    }

    private function syncCategories(Vendor $vendor, array $categories): void
    {
        $vendor->issueCategories()->delete();

        foreach ($categories as $category) {
            $category = trim((string) $category);

            if ($category !== '') {
                $vendor->issueCategories()->create([
                    'name' => $category,
                ]);
            }
        }
    }
}
