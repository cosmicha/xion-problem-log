<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $companyId = null;

        // Support either company_name or company field from the register form
        $companyName = trim((string) ($request->input('company_name') ?? $request->input('company') ?? ''));

        if ($companyName !== '') {
            $company = Company::firstOrCreate(
                ['name' => $companyName],
                [
                    'code' => strtoupper(Str::random(6)),
                    'sla_response_minutes' => 2,
                    'sla_resolution_minutes' => 8,
                    'sla_active' => true,
                    'notification_emails' => $request->email,
                ]
            );

            $companyId = $company->id;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'company_id' => $companyId,
            'is_approved' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/waiting-approval');
    }
}
