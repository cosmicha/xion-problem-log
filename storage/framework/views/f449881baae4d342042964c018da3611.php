<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolution Knowledge Base</title>
    <style>
        * { box-sizing: border-box; }

        :root{
            --bg:#081120;
            --bg2:#0f172a;
            --line:#dbe4f0;
            --text:#0f172a;
            --muted:#64748b;
            --blue:#2563eb;
            --blue2:#1d4ed8;
            --soft:#eff6ff;
            --card:#ffffff;
            --shadow:0 20px 50px rgba(15,23,42,.10);
            --radius:24px;
        }

        body{
            margin:0;
            font-family:Inter, Arial, sans-serif;
            color:var(--text);
            background:
                radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 26%),
                radial-gradient(circle at top right, rgba(14,165,233,.16), transparent 24%),
                linear-gradient(180deg, #09111f 0%, #0d1728 34%, #f4f7fb 34%, #f4f7fb 100%);
        }

        .page{
            max-width:1360px;
            margin:0 auto;
            padding:34px 22px 56px;
        }

        .hero{
            border-radius:30px;
            padding:28px 30px;
            color:white;
            margin-bottom:24px;
            background:linear-gradient(135deg, rgba(15,23,42,.96), rgba(29,78,216,.88));
            box-shadow:0 24px 60px rgba(2,6,23,.30);
            border:1px solid rgba(255,255,255,.08);
        }

        .hero-top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:18px;
            flex-wrap:wrap;
        }

        .eyebrow{
            display:inline-flex;
            gap:10px;
            align-items:center;
            font-size:12px;
            font-weight:800;
            letter-spacing:.12em;
            text-transform:uppercase;
            color:rgba(255,255,255,.75);
            margin-bottom:12px;
        }

        .eyebrow-dot{
            width:10px;
            height:10px;
            border-radius:999px;
            background:linear-gradient(135deg,#60a5fa,#22d3ee);
            box-shadow:0 0 16px rgba(96,165,250,.8);
        }

        .hero h1{
            margin:0 0 10px;
            font-size:34px;
            line-height:1.08;
        }

        .hero p{
            margin:0;
            max-width:760px;
            color:rgba(255,255,255,.82);
            font-size:15px;
            line-height:1.7;
        }

        .hero-actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:12px 18px;
            border-radius:14px;
            text-decoration:none;
            font-size:14px;
            font-weight:700;
            border:none;
            cursor:pointer;
            transition:.2s ease;
        }

        .btn-primary{
            background:linear-gradient(135deg, #3b82f6, #2563eb);
            color:white;
            box-shadow:0 12px 24px rgba(37,99,235,.34);
        }

        .btn-secondary{
            background:rgba(255,255,255,.10);
            color:white;
            border:1px solid rgba(255,255,255,.16);
            backdrop-filter:blur(8px);
        }

        .surface{
            background:rgba(255,255,255,.94);
            backdrop-filter:blur(12px);
            border:1px solid rgba(148,163,184,.18);
            box-shadow:var(--shadow);
            border-radius:28px;
            padding:22px;
        }

        .search-bar{
            display:flex;
            gap:12px;
            align-items:center;
            flex-wrap:wrap;
            margin-bottom:18px;
        }

        .input{
            flex:1;
            min-width:260px;
            border:1px solid #cbd5e1;
            border-radius:16px;
            padding:14px 16px;
            font-size:15px;
            background:white;
            outline:none;
        }

        .input:focus{
            border-color:#60a5fa;
            box-shadow:0 0 0 4px rgba(96,165,250,.16);
        }

        .table-wrap{
            overflow:auto;
            border-radius:20px;
            border:1px solid #e5e7eb;
            background:white;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:1080px;
        }

        th, td{
            text-align:left;
            padding:16px 16px;
            vertical-align:top;
            border-bottom:1px solid #eef2f7;
        }

        th{
            font-size:12px;
            font-weight:800;
            letter-spacing:.08em;
            text-transform:uppercase;
            color:#64748b;
            background:#f8fafc;
        }

        tr:hover td{
            background:#fbfdff;
        }

        .preview{
            width:68px;
            height:68px;
            border-radius:16px;
            object-fit:cover;
            border:1px solid #e5e7eb;
            background:#f8fafc;
        }

        .title-main{
            font-size:15px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:6px;
        }

        .title-sub{
            font-size:12px;
            color:#64748b;
            line-height:1.5;
        }

        .summary{
            font-size:14px;
            color:#334155;
            line-height:1.7;
            max-width:360px;
        }

        .pill{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:7px 10px;
            border-radius:999px;
            font-size:12px;
            font-weight:800;
            margin:0 8px 8px 0;
            white-space:nowrap;
        }

        .pill-blue{ background:#dbeafe; color:#1d4ed8; }
        .pill-green{ background:#dcfce7; color:#166534; }
        .pill-slate{ background:#eef2ff; color:#475569; }

        .action-stack{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .btn-lite{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 13px;
            border-radius:12px;
            text-decoration:none;
            font-size:13px;
            font-weight:800;
            border:1px solid #dbeafe;
            background:#eff6ff;
            color:#1d4ed8;
        }

        .btn-dark{
            border:1px solid #e2e8f0;
            background:#0f172a;
            color:white;
        }

        .empty{
            text-align:center;
            padding:36px 16px;
            color:#64748b;
            font-size:14px;
        }

        @media (max-width: 760px){
            .page{ padding:18px 14px 40px; }
            .hero, .surface{ border-radius:20px; padding:18px; }
            .hero h1{ font-size:28px; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        AI Resolution Library
                    </div>
                    <h1>Resolution Knowledge Base</h1>
                    <p>
                        Premium library of reusable, AI-cleaned resolutions, ranked by usage, success rate, and learning score.
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="surface">
            <form method="GET" action="/resolution-library" class="search-bar">
                <input class="input" type="text" name="q" value="<?php echo e($q); ?>" placeholder="Search title, category, symptom, or AI summary...">
                <button class="btn btn-primary" type="submit">Search</button>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>AI Summary</th>
                            <th>Category</th>
                            <th>Learning</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($item->images->first()): ?>
                                        <img class="preview" src="<?php echo e(url('/storage/' . $item->images->first()->image_path)); ?>" alt="KB Image">
                                    <?php else: ?>
                                        <div class="preview" style="display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:12px;">No Image</div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="title-main"><?php echo e($item->displayTitle()); ?></div>
                                    <div class="title-sub"><?php echo e($item->title); ?></div>
                                </td>

                                <td>
                                    <div class="summary"><?php echo e($item->displaySummary()); ?></div>
                                </td>

                                <td>
                                    <span class="pill pill-slate"><?php echo e($item->displayCategory()); ?></span>
                                </td>

                                <td>
                                    <div>
                                        <span class="pill pill-blue">Usage <?php echo e($item->usage_count); ?>x</span>
                                        <span class="pill pill-green">Success <?php echo e($item->success_count); ?>x</span>
                                        <span class="pill pill-slate">Score <?php echo e(number_format($item->learning_score ?? 0, 2)); ?></span>
                                    </div>
                                </td>

                                <td>
                                    <div class="action-stack">
                                        <a href="<?php echo e(route('resolution-library.show', $item)); ?>" class="btn-lite">Open</a>
                                        <?php if(in_array(auth()->user()->role ?? '', ['admin'])): ?>
                                            <a href="<?php echo e(route('resolution-library.edit', $item)); ?>" class="btn-lite btn-dark">Edit</a>
                                        <?php endif; ?>
                                    
                                        <?php if(in_array(auth()->user()->role ?? '', ['admin'])): ?>
                                            <form method="POST"
                                                  action="<?php echo e(route('resolution-library.destroy', $item)); ?>"
                                                  onsubmit="return confirm('Delete this knowledge base item?');"
                                                  style="display:inline-flex;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-lite" style="border:1px solid #fecaca; background:#fef2f2; color:#b91c1c;">
                                                    Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
</div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="empty">No reusable resolutions found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /Users/macbookair/Sites/xion-local/resources/views/resolution/index.blade.php ENDPATH**/ ?>