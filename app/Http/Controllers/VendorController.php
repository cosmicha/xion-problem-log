<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('name')->get();
        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        if ((auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        return view('vendors.create');
    }

    public function store(Request $request)
    {
        if ((auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'support_phone' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Vendor::create($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor created.');
    }

    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        if ((auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        if ((auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'support_phone' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vendor->update($data);

        return redirect()->route('vendors.index')->with('success', 'Updated.');
    }

    public function destroy(Vendor $vendor)
    {
        if ((auth()->user()->role ?? null) !== 'admin') {
            abort(403);
        }

        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Deleted.');
    }
}
