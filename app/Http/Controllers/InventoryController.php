<?php

namespace App\Http\Controllers;

use App\Models\InventoryLocation;
use App\Models\SparePart;
use App\Models\Device;
use App\Models\DeviceMovement;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $locations = InventoryLocation::latest()->get();
        $spareParts = SparePart::with(['location', 'vendor'])->latest()->get();
        $devices = Device::with(['company', 'vendor'])->latest()->take(30)->get();
        $movements = DeviceMovement::latest()->take(20)->get();

        return view('inventory.index', compact('locations', 'spareParts', 'devices', 'movements'));
    }

    public function storeLocation(Request $request)
    {
        $data = $request->validate([
            'type' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        InventoryLocation::create($data);

        return back()->with('success', 'Inventory location created.');
    }

    public function storeSparePart(Request $request)
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'location_id' => ['nullable', 'exists:inventory_locations,id'],
            'stock_qty' => ['nullable', 'integer'],
            'minimum_stock' => ['nullable', 'integer'],
            'unit_cost' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['stock_qty'] = $data['stock_qty'] ?? 0;
        $data['minimum_stock'] = $data['minimum_stock'] ?? 0;
        $data['status'] = $data['status'] ?? 'active';

        SparePart::create($data);

        return back()->with('success', 'Spare part created.');
    }

    public function moveDevice(Request $request)
    {
        $data = $request->validate([
            'device_id' => ['required', 'exists:devices,id'],
            'to_location_id' => ['required', 'exists:inventory_locations,id'],
            'movement_type' => ['nullable', 'string', 'max:100'],
            'note' => ['nullable', 'string'],
        ]);

        $device = Device::findOrFail($data['device_id']);
        $fromLocationId = $device->current_location_id ?? null;

        DeviceMovement::create([
            'device_id' => $device->id,
            'from_location_id' => $fromLocationId,
            'to_location_id' => $data['to_location_id'],
            'user_id' => auth()->id(),
            'movement_type' => $data['movement_type'] ?? 'transfer',
            'note' => $data['note'] ?? null,
        ]);

        $device->current_location_id = $data['to_location_id'];
        $device->asset_status = $data['movement_type'] ?? 'transfer';
        $device->save();

        return back()->with('success', 'Device movement recorded.');
    }

    public function updateLocation(Request $request, InventoryLocation $location)
    {
        $data = $request->validate([
            'type' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $location->update($data);

        return back()->with('success', 'Inventory location updated.');
    }

    public function deleteLocation(InventoryLocation $location)
    {
        $hasSpareParts = SparePart::where('location_id', $location->id)->exists();
        $hasDevices = Device::where('current_location_id', $location->id)->exists();

        if ($hasSpareParts || $hasDevices) {
            return back()->with('error', 'Location cannot be deleted because it is linked to spare parts or devices.');
        }

        $location->delete();

        return back()->with('success', 'Inventory location deleted.');
    }

    public function updateSparePart(Request $request, SparePart $sparePart)
    {
        $data = $request->validate([
            'sku' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'location_id' => ['nullable', 'exists:inventory_locations,id'],
            'minimum_stock' => ['nullable', 'integer'],
            'unit_cost' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $sparePart->update($data);

        return back()->with('success', 'Spare part updated.');
    }

    public function deleteSparePart(SparePart $sparePart)
    {
        $hasMovements = \App\Models\SparePartMovement::where('spare_part_id', $sparePart->id)->exists();

        if ($hasMovements) {
            return back()->with('error', 'Spare part cannot be deleted because it already has movement history.');
        }

        $sparePart->delete();

        return back()->with('success', 'Spare part deleted.');
    }

    public function moveSparePart(Request $request)
    {
        $data = $request->validate([
            'spare_part_id' => ['required', 'exists:spare_parts,id'],
            'movement_type' => ['required', 'in:in,out,adjustment,return,damaged'],
            'qty' => ['required', 'integer', 'min:1'],
            'to_location_id' => ['nullable', 'exists:inventory_locations,id'],
            'from_location_id' => ['nullable', 'exists:inventory_locations,id'],
            'note' => ['nullable', 'string'],
        ]);

        $part = SparePart::findOrFail($data['spare_part_id']);
        $before = (int) $part->stock_qty;

        if ($data['movement_type'] === 'in' || $data['movement_type'] === 'return') {
            $after = $before + (int) $data['qty'];
        } elseif ($data['movement_type'] === 'adjustment') {
            $after = (int) $data['qty'];
        } else {
            $after = max(0, $before - (int) $data['qty']);
        }

        \App\Models\SparePartMovement::create([
            'spare_part_id' => $part->id,
            'from_location_id' => $data['from_location_id'] ?? $part->location_id,
            'to_location_id' => $data['to_location_id'] ?? $part->location_id,
            'user_id' => auth()->id(),
            'movement_type' => $data['movement_type'],
            'qty' => $data['qty'],
            'before_qty' => $before,
            'after_qty' => $after,
            'note' => $data['note'] ?? null,
        ]);

        $part->stock_qty = $after;

        if (!empty($data['to_location_id'])) {
            $part->location_id = $data['to_location_id'];
        }

        $part->save();

        return back()->with('success', 'Spare part stock movement recorded.');
    }

    public function export()
    {
        $filename = 'inventory-report-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Type', 'SKU/Code', 'Name', 'Category', 'Location', 'Stock/Status', 'Minimum Stock', 'Notes']);

            foreach (SparePart::with('location')->orderBy('name')->get() as $part) {
                fputcsv($handle, [
                    'Spare Part',
                    $part->sku,
                    $part->name,
                    $part->category,
                    optional($part->location)->name,
                    $part->stock_qty,
                    $part->minimum_stock,
                    $part->notes,
                ]);
            }

            foreach (Device::with('currentLocation')->orderBy('device_code')->get() as $device) {
                fputcsv($handle, [
                    'Device',
                    $device->device_code,
                    $device->name,
                    $device->category ?? '',
                    optional($device->currentLocation)->name,
                    $device->asset_status,
                    '',
                    '',
                ]);
            }

            fclose($handle);
        }, $filename);
    }

}
