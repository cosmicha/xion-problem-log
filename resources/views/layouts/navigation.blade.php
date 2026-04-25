<nav style="padding: 16px 24px; background: white; border-bottom: 1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
    <div style="font-weight:700;">
        Ticketing System
    </div>

    <div style="display:flex; align-items:center; gap:12px;">
        <a href="/devices" class="btn btn-secondary">Devices</a>
                        <a href="/problem-logs" style="text-decoration:none; color:#2563eb; font-weight:600;">Tickets</a>

        <form method="POST" action="/logout" style="margin:0;">
            @csrf
            <button type="submit" style="
                background:#ef4444;
                color:white;
                border:none;
                padding:8px 12px;
                border-radius:8px;
                cursor:pointer;
                font-weight:600;
            ">
                Logout
            </button>
        </form>
    </div>
</nav>
