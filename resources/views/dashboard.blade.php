<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- MENU -->
            <div style="display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
                <a href="/devices" style="background:#2563eb;color:white;padding:16px 20px;border-radius:16px;text-decoration:none;font-weight:700;">
                    Device Master
                </a>

                <a href="/vendors" style="background:#0f172a;color:white;padding:16px 20px;border-radius:16px;text-decoration:none;font-weight:700;">
                    Vendor Management
                </a>

                <a href="/problem-logs" style="background:#16a34a;color:white;padding:16px 20px;border-radius:16px;text-decoration:none;font-weight:700;">
                    Ticket System
                </a>
            </div>

            <!-- CARD -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                Welcome to Xion1 System Dashboard 🚀
            </div>

        </div>
    </div>
</x-app-layout>
