<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $devices = Device::when($q, function ($query) use ($q) {
            $query->where('device_code', 'like', "%$q%")
                  ->orWhere('cms_device_name', 'like', "%$q%")
                  ->orWhere('serial_number', 'like', "%$q%");
        })->latest()->paginate(15);

        return view('devices.index', compact('devices','q'));
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $device->update($request->except('photos'));

        return redirect('/devices')->with('success','Device updated');
    }
}
