<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base Detail</title>
    <style>
        * { box-sizing:border-box; }

        body{
            margin:0;
            font-family:Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 26%),
                radial-gradient(circle at top right, rgba(14,165,233,.16), transparent 24%),
                linear-gradient(180deg, #09111f 0%, #0d1728 34%, #f4f7fb 34%, #f4f7fb 100%);
            color:#0f172a;
        }

        .page{
            max-width:1180px;
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
            gap:18px;
            align-items:flex-start;
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

        .dot{
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
            max-width:700px;
            color:rgba(255,255,255,.82);
            font-size:15px;
            line-height:1.7;
        }

        .hero-actions{
            display:flex;
            gap:10px;
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

        .grid{
            display:grid;
            grid-template-columns:1.2fr .8fr;
            gap:20px;
        }

        .card{
            background:rgba(255,255,255,.94);
            backdrop-filter:blur(12px);
            border:1px solid rgba(148,163,184,.18);
            box-shadow:0 20px 50px rgba(15,23,42,.10);
            border-radius:28px;
            padding:22px;
        }

        .section-title{
            margin:0 0 8px;
            font-size:21px;
            font-weight:800;
        }

        .muted{
            color:#64748b;
            font-size:14px;
            margin-bottom:18px;
        }

        .label{
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#64748b;
            margin-bottom:6px;
            font-weight:800;
        }

        .value{
            margin-bottom:18px;
            line-height:1.7;
            color:#0f172a;
            font-size:14px;
        }

        .pills{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            margin-bottom:18px;
        }

        .pill{
            display:inline-flex;
            align-items:center;
            padding:8px 12px;
            border-radius:999px;
            font-size:12px;
            font-weight:800;
        }

        .pill-blue{ background:#dbeafe; color:#1d4ed8; }
        .pill-green{ background:#dcfce7; color:#166534; }
        .pill-slate{ background:#eef2ff; color:#475569; }

        .steps{
            margin:0;
            padding-left:18px;
            color:#0f172a;
        }

        .steps li{
            margin-bottom:10px;
            line-height:1.7;
        }

        .gallery{
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(170px,1fr));
            gap:12px;
        }

        .gallery img{
            width:100%;
            height:170px;
            object-fit:cover;
            border-radius:16px;
            border:1px solid #e5e7eb;
            background:#fff;
        }

        @media (max-width: 900px){
            .grid{ grid-template-columns:1fr; }
        }

        @media (max-width: 760px){
            .page{ padding:18px 14px 40px; }
            .hero, .card{ border-radius:20px; padding:18px; }
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
                        <span class="dot"></span>
                        Knowledge Base Article
                    </div>
                    <h1><?php echo e($resolutionTemplate->displayTitle()); ?></h1>
                    <p><?php echo e($resolutionTemplate->displaySummary()); ?></p>
                </div>

                <div class="hero-actions">
                    <a href="/resolution-library" class="btn btn-secondary">Back</a>

                    <?php if(in_array(auth()->user()->role ?? '', ['admin'])): ?>
                        <a href="<?php echo e(route('resolution-library.edit', $resolutionTemplate)); ?>" class="btn btn-secondary">Edit</a>
                    <?php endif; ?>

                    <?php if(request('ticket_id')): ?>
                        <form method="POST"
                              action="<?php echo e(route('problem-logs.apply-resolution-template', ['problemLog' => request('ticket_id'), 'resolutionTemplate' => $resolutionTemplate->id])); ?>"
                              style="display:inline-flex;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">
                                Problem Solved for This Ticket
                            </button>
                        </form>
                    <?php else: ?>
                        <button type="button" class="btn btn-primary" onclick="copySolution()">Use Solution</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid">
            <div class="card">
                <h2 class="section-title">Resolution Overview</h2>
                <div class="muted">AI-cleaned summary, symptom mapping, and structured steps.</div>

                <div class="label">Category</div>
                <div class="value"><?php echo e($resolutionTemplate->displayCategory()); ?></div>

                <div class="label">Matched Symptoms</div>
                <div class="value"><?php echo e($resolutionTemplate->symptom_keywords ?: '-'); ?></div>

                <div class="label">AI Summary</div>
                <div class="value" id="solutionText"><?php echo e($resolutionTemplate->displaySummary()); ?></div>

                <div class="label">AI Steps</div>
                <div class="value">
                    <?php if(is_array($resolutionTemplate->ai_steps) && count($resolutionTemplate->ai_steps)): ?>
                        <ol class="steps">
                            <?php $__currentLoopData = $resolutionTemplate->ai_steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($step); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                    <?php else: ?>
                        <?php echo e($resolutionTemplate->resolution_steps ?: '-'); ?>

                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <h2 class="section-title">Learning Metrics</h2>
                <div class="muted">Shows how frequently and successfully this resolution has been used.</div>

                <div class="pills">
                    <span class="pill pill-blue">Usage <?php echo e($resolutionTemplate->usage_count); ?>x</span>
                    <span class="pill pill-green">Success <?php echo e($resolutionTemplate->success_count); ?>x</span>
                    <span class="pill pill-slate">Score <?php echo e(number_format($resolutionTemplate->learning_score ?? 0, 2)); ?></span>
                </div>

                <div class="label">Last Used</div>
                <div class="value"><?php echo e($resolutionTemplate->last_used_at ? $resolutionTemplate->last_used_at->format('d M Y H:i') : '-'); ?></div>

                
        <?php if($resolutionTemplate->alternatives && $resolutionTemplate->alternatives->count()): ?>
            <div class="label">Alternative Solutions</div>
            <div class="value">
                <?php $__currentLoopData = $resolutionTemplate->alternatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="padding:12px 14px; border:1px solid #e5e7eb; border-radius:14px; margin-bottom:10px;">
                        <div style="font-weight:800;"><?php echo e($alt->displayTitle()); ?></div>
                        <div style="color:#64748b; font-size:13px; margin-top:4px;"><?php echo e($alt->displaySummary()); ?></div>
                        <div style="margin-top:8px;">
                            <a href="<?php echo e(route('resolution-library.show', $alt)); ?>" class="btn btn-secondary" style="padding:8px 12px; font-size:12px;">Open Alternative</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

<div class="label">Gallery</div>
                <div class="value">
                    <?php if($resolutionTemplate->images->count()): ?>
                        <div class="gallery">
                            <?php $__currentLoopData = $resolutionTemplate->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(url('/storage/' . $image->image_path)); ?>" alt="KB Image">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        No images uploaded.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copySolution() {
            const text = document.getElementById('solutionText')?.innerText || '';
            navigator.clipboard.writeText(text).then(() => {
                alert('Solution copied.');
            });
        }
    </script>
</body>
</html>
<?php /**PATH /Users/macbookair/Sites/xion-local/resources/views/resolution/show.blade.php ENDPATH**/ ?>