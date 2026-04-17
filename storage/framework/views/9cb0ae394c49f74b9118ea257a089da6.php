<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Create Ticket</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.20), transparent 28%),
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 980px;
            margin: 0 auto;
            padding: 36px 24px 60px;
        }

        .hero {
            color: white;
            padding: 28px 30px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.94), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 24px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            margin-bottom: 12px;
        }

        .brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            box-shadow: 0 0 16px rgba(96,165,250,0.8);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 32px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            max-width: 680px;
            font-size: 15px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
            backdrop-filter: blur(8px);
        }

        .card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 26px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .section-title {
            margin: 0 0 8px;
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .full {
            grid-column: 1 / -1;
        }

        .label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #334155;
        }

        .input,
        .select,
        .textarea,
        .file {
            width: 100%;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .textarea {
            min-height: 140px;
            resize: vertical;
        }

        .input:focus,
        .select:focus,
        .textarea:focus,
        .file:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96,165,250,0.18);
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .btn-outline {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
        }

        .helper-box {
            margin-top: 22px;
            padding: 18px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
        }

        .helper-title {
            font-size: 13px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        .helper-text {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
        }

        @media (max-width: 760px) {
            .page {
                padding: 18px 14px 40px;
            }

            .hero,
            .card {
                border-radius: 18px;
                padding: 18px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="brand">
                <span class="brand-dot"></span>
                TICKETING SYSTEM
            </div>

            <div class="hero-top">
                <div>
                    <h1>Create Ticket</h1>
                    <p>
                        Record a new issue with title, description, priority, current status, and supporting evidence photo.
                    </p>
                    <p style="margin-top:10px;">
                        <strong><?php echo e(auth()->user()->company->name ?? 'No Company'); ?></strong>
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to List</a>
                    <a href="/resolution-library" class="btn btn-secondary">📚 Knowledge Base</a>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title">New Ticket Form</h2>
            <div class="muted">Fill in the issue details below.</div>

            <form method="POST" action="/problem-logs" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="grid">
                    <div class="form-group full">
                        <label class="label">Title</label>
                        <input type="text" name="title" class="input" placeholder="Example: Screen offline at store entrance" required>
                    </div>

                    <div class="form-group">
                        <label class="label">Status</label>
                        <select name="status" class="select">
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    
                            <div class="form-group">
                                <label class="label">Company</label>
                                <?php if((auth()->user()->role ?? '') === 'customer'): ?>
                                    <input type="text" class="input" value="<?php echo e(optional(auth()->user()->company)->name ?? 'No Company'); ?>" disabled>
                                    <input type="hidden" name="company_id" value="<?php echo e(auth()->user()->company_id); ?>">
                                <?php else: ?>
                                    <select name="company_id" class="select" required>
                                        <option value="">Select Company</option>
                                        <?php $__currentLoopData = ($companies ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>" <?php echo e(old('company_id') == $company->id ? 'selected' : ''); ?>>
                                                <?php echo e($company->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                        <label class="label">Priority</label>
                        <select name="priority" class="select">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>

                    <div class="form-group full">
                        <label class="label">Description</label>
                        <textarea name="description" class="textarea" placeholder="Describe the issue, impact, location, symptoms, or actions needed" required></textarea>
                    </div>

                    <div class="form-group full">
                        <label class="label">Photo</label>
                        <input type="file" name="photo" class="file">
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Save Ticket</button>
                    <a href="/problem-logs" class="btn btn-outline">Cancel</a>
                </div>
            
                <div id="aiSuggestionBox" class="helper-box" style="display:none;">
                    <div class="helper-title">AI Assistance</div>

                    <div style="margin-bottom:12px;">
                        <div class="label" style="margin-bottom:4px;">Problem Summary</div>
                        <div id="aiProblemSummary" class="helper-text">-</div>
                    </div>

                    <div style="margin-bottom:12px;">
                        <div class="label" style="margin-bottom:4px;">Category</div>
                        <div id="aiCategory" class="helper-text">-</div>
                    </div>

                    <div class="label" style="margin-bottom:8px;">Suggested Resolutions</div>
                    <div id="aiSuggestionList"></div>
                    
                    <div style="margin-top:16px;">
                        <div class="label">Knowledge Base Match</div>
                        <div id="aiKbList"></div>
                    </div>

                </div>
            </form>

            <script>
                (function () {
                    const titleInput = document.querySelector('input[name="title"]');
                    const descInput = document.querySelector('textarea[name="description"]');
                    const box = document.getElementById('aiSuggestionBox');
                    const summaryEl = document.getElementById('aiProblemSummary');
                    const categoryEl = document.getElementById('aiCategory');
                    const listEl = document.getElementById('aiSuggestionList');

                    if (!titleInput || !descInput || !box || !summaryEl || !categoryEl || !listEl) {
                        return;
                    }

                    let timer = null;

                    function escapeHtml(str) {
                        return String(str ?? '')
                            .replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(/"/g, '&quot;')
                            .replace(/'/g, '&#039;');
                    }

                    

                    const kbEl = document.getElementById('aiKbList');

                    function renderKbMatches(data) {
                        const items = data?.kb_matches || [];

                        if (!items.length) {
                            kbEl.innerHTML = '<div class="helper-text">No matching knowledge base.</div>';
                            return;
                        }

                        kbEl.innerHTML = items.map(item => {
                            const score = ((item.score || 0) * 100).toFixed(1);

                            return `
                                <a href="/resolution-library/${item.id}" target="_blank"
                                   style="display:block; border:1px solid #dbeafe; border-radius:12px; padding:10px; margin-bottom:8px; text-decoration:none; background:white;">
                                    
                                    <div style="display:flex; justify-content:space-between;">
                                        <div style="font-weight:800; color:#0f172a;">${item.title}</div>
                                        <div style="font-size:12px; color:#1d4ed8;">${score}%</div>
                                    </div>

                                    <div style="font-size:13px; color:#475569; margin-top:4px;">
                                        ${item.summary}
                                    </div>

                                    <div style="margin-top:8px;">
                                        <button type="button"
                                                class="useKbBtn"
                                                data-kb-title="${item.title || ''}"
                                                data-kb-summary="${item.summary || ''}"
                                                style="padding:8px 10px; border:none; border-radius:10px; background:#1d4ed8; color:white; font-weight:700; cursor:pointer;">
                                            Use Solution
                                        </button>
                                    </div>
                                </a>
                            `;
                        }).join('');
                    }

                    function renderSuggestions(data) {
                        const suggestions = data?.suggestions || [];

                        if (!suggestions.length) {
                            box.style.display = 'none';
                            listEl.innerHTML = '';
                            return;
                        }

                        box.style.display = 'block';
                        summaryEl.textContent = data.problem_summary || '-';
                        categoryEl.textContent = data.category || '-';

                        listEl.innerHTML = suggestions.map((item) => {
                            const score = ((item.score || 0) * 100).toFixed(1);
                            const matched = Array.isArray(item.matched_keywords)
                                ? item.matched_keywords.join(', ')
                                : '';
                            const steps = item.resolution_steps || '';

                            return `
                                <div style="border:1px solid #dbeafe; border-radius:14px; padding:12px; background:white; margin-bottom:10px;">
                                    <div style="display:flex; justify-content:space-between; gap:10px; align-items:flex-start;">
                                        <div style="font-weight:800; color:#0f172a;">${escapeHtml(item.title || '-')}</div>
                                        <div style="font-size:12px; font-weight:800; color:#1d4ed8;">${score}%</div>
                                    </div>

                                    <div style="font-size:13px; color:#475569; margin-top:6px;">
                                        ${escapeHtml(item.reason || '-')}
                                    </div>

                                    <div style="font-size:12px; color:#64748b; margin-top:6px;">
                                        ${escapeHtml(matched)}
                                    </div>

                                    <div style="font-size:12px; color:#94a3b8; margin-top:6px;">
                                        ${escapeHtml(steps)}
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }

                    async function fetchSuggestions() {
                        const title = titleInput.value.trim();
                        const description = descInput.value.trim();

                        if ((title + ' ' + description).trim().length < 3) {
                            box.style.display = 'none';
                            listEl.innerHTML = '';
                            return;
                        }

                        try {
                            const response = await fetch('/ai/suggest-resolution', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ title, description })
                            });

                            if (!response.ok) return;

                            const data = await response.json();
                            renderSuggestions(data);
                            renderKbMatches(data);
                        } catch (e) {
                        }
                    }

                    function triggerSuggestions() {
                        clearTimeout(timer);
                        timer = setTimeout(fetchSuggestions, 700);
                    }

                    titleInput.addEventListener('input', triggerSuggestions);
                    descInput.addEventListener('input', triggerSuggestions);

                    document.addEventListener('click', function (e) {
                        const btn = e.target.closest('.useKbBtn');
                        if (!btn) return;

                        e.preventDefault();
                        e.stopPropagation();

                        const title = btn.getAttribute('data-kb-title') || '';
                        const summary = btn.getAttribute('data-kb-summary') || '';
                        const current = descInput.value.trim();

                        const suggestionText = 'Suggested solution: ' + title + (summary ? ' — ' + summary : '');

                        if (!current.includes(suggestionText)) {
                            descInput.value = (current ? current + "\n\n" : "") + suggestionText;
                        }
                    });
                })();
            </script>


            <div class="helper-box">
                <div class="helper-title">Workflow</div>
                <div class="helper-text">
                    After a ticket is created, it can be acknowledged, updated, and closed with final note and proof photo.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/macbookair/Sites/xion-local/resources/views/problem-logs/create.blade.php ENDPATH**/ ?>