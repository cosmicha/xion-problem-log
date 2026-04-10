<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::with('company')->latest()->get();
        $companies = Company::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'companies'));
    }

    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'code' => 'required|string|max:50|unique:companies,code',
        ]);

        Company::create($validated);

        return back()->with('success', 'Company created successfully.');
    }

    public function approve(Request $request, User $user)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $user->update([
            'is_approved' => true,
            'company_id' => $request->company_id,
        ]);

        return back()->with('success', 'User approved and assigned to company.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,engineer,customer',
            'company_id' => 'nullable|exists:companies,id',
            'is_approved' => 'required|in:0,1',
        ]);

        $user->update([
            'role' => $validated['role'],
            'company_id' => $validated['company_id'] ?: null,
            'is_approved' => (bool) $validated['is_approved'],
        ]);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
