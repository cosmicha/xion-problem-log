<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::with('company')->orderBy('name')->get();
        $companies = Company::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'companies'));
    }

    public function approve(User $user)
    {
        $user->update([
            'is_approved' => true,
        ]);

        return back()->with('success', 'User approved successfully.');
    }

    public function update(Request $request, User $user)
    {
        $data = [
            'name' => $request->filled('name') ? $request->name : $user->name,
            'email' => $request->filled('email') ? $request->email : $user->email,
            'role' => $request->filled('role') ? $request->role : $user->role,
            'company_id' => $request->filled('company_id') ? $request->company_id : null,
            'is_approved' => $request->has('is_approved'),
        ];

        \Log::info('Admin user update payload', [
            'user_id' => $user->id,
            'has_password' => $request->filled('password'),
            'password_length' => $request->filled('password') ? strlen($request->password) : 0,
            'email_sent' => $request->email,
            'name_sent' => $request->name,
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sla_response_minutes' => ['nullable', 'numeric', 'min:1'],
            'sla_resolution_minutes' => ['nullable', 'numeric', 'min:1'],
            'notification_emails' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');
        }

        Company::create([
            'name' => $request->name,
            'code' => strtoupper(Str::random(6)),
            'sla_response_minutes' => $request->sla_response_minutes ?: 2,
            'sla_resolution_minutes' => $request->sla_resolution_minutes ?: 8,
            'sla_active' => $request->has('sla_active'),
            'notification_emails' => $request->notification_emails,
            'logo_path' => $logoPath,
        ]);

        return back()->with('success', 'Company created successfully.');
    }

    public function updateCompany(Request $request, Company $company)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sla_response_minutes' => ['nullable', 'numeric', 'min:1'],
            'sla_resolution_minutes' => ['nullable', 'numeric', 'min:1'],
            'notification_emails' => ['nullable', 'string', 'max:2000'],
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        $data = [
            'name' => $request->name,
            'sla_response_minutes' => $request->sla_response_minutes ?: 2,
            'sla_resolution_minutes' => $request->sla_resolution_minutes ?: 8,
            'sla_active' => $request->has('sla_active'),
            'notification_emails' => $request->notification_emails,
        ];

        if (empty($company->code)) {
            $data['code'] = strtoupper(Str::random(6));
        }

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('company-logos', 'public');
        }

        $company->update($data);

        return back()->with('success', 'Company updated successfully.');
    }

    public function destroyCompany(Company $company)
    {
        $company->delete();

        return back()->with('success', 'Company deleted successfully.');
    }
    public function companySettings()
    {
        $companies = Company::orderBy('name')->get();

        return view('admin.companies.index', compact('companies'));
    }


}
