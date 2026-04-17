<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Knowledge Base</title>
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
            max-width:1100px;
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

        .card{
            background:rgba(255,255,255,.94);
            backdrop-filter:blur(12px);
            border:1px solid rgba(148,163,184,.18);
            box-shadow:0 20px 50px rgba(15,23,42,.10);
            border-radius:28px;
            padding:22px;
        }

        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:18px;
        }

        .group{ margin-bottom:18px; }
        .full{ grid-column:1 / -1; }

        .label{
            display:block;
            font-size:13px;
            font-weight:800;
            margin-bottom:8px;
            color:#334155;
        }

        .input, .textarea{
            width:100%;
            padding:13px 14px;
            border-radius:14px;
            border:1px solid #cbd5e1;
            background:white;
            font-size:14px;
            color:#0f172a;
            outline:none;
        }

        .textarea{
            min-height:130px;
            resize:vertical;
        }

        .input:focus, .textarea:focus{
            border-color:#60a5fa;
            box-shadow:0 0 0 4px rgba(96,165,250,.18);
        }

        .gallery{
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(170px,1fr));
            gap:12px;
        }

        .imgbox{
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:10px;
            background:white;
        }

        .imgbox img{
            width:100%;
            height:140px;
            object-fit:cover;
            border-radius:12px;
        }

        .actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-top:8px;
        }

        @media (max-width: 860px){
            .grid{ grid-template-columns:1fr; }
            .full{ grid-column:auto; }
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
                        Admin Knowledge Editor
                    </div>
                    <h1>Edit Knowledge Base</h1>
                    <p>Refine the AI title, summary, steps, category, and gallery to keep the knowledge base premium and reliable.</p>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('resolution-library.index') }}" class="btn btn-secondary">Back to KB</a>
                    <a href="{{ route('resolution-library.show', $resolutionTemplate) }}" class="btn btn-secondary">Open Article</a>
                </div>
            </div>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('resolution-library.update', $resolutionTemplate) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid">
                    <div class="group">
                        <label class="label">Original Title</label>
                        <input class="input" type="text" name="title" value="{{ old('title', $resolutionTemplate->title) }}">
                    </div>

                    <div class="group">
                        <label class="label">AI Title</label>
                        <input class="input" type="text" name="ai_title" value="{{ old('ai_title', $resolutionTemplate->ai_title) }}">
                    </div>

                    <div class="group">
                        <label class="label">Original Category</label>
                        <input class="input" type="text" name="category" value="{{ old('category', $resolutionTemplate->category) }}">
                    </div>

                    <div class="group">
                        <label class="label">AI Category</label>
                        <input class="input" type="text" name="ai_category" value="{{ old('ai_category', $resolutionTemplate->ai_category) }}">
                    </div>

                    <div class="group full">
                        <label class="label">Symptoms</label>
                        <textarea class="textarea" name="symptom_keywords">{{ old('symptom_keywords', $resolutionTemplate->symptom_keywords) }}</textarea>
                    </div>

                    <div class="group full">
                        <label class="label">Original Resolution Steps</label>
                        <textarea class="textarea" name="resolution_steps">{{ old('resolution_steps', $resolutionTemplate->resolution_steps) }}</textarea>
                    </div>

                    <div class="group full">
                        <label class="label">AI Summary</label>
                        <textarea class="textarea" name="ai_summary">{{ old('ai_summary', $resolutionTemplate->ai_summary) }}</textarea>
                    </div>

                    <div class="group full">
                        <label class="label">AI Steps (one line per step)</label>
                        <textarea class="textarea" name="ai_steps">{{ old('ai_steps', is_array($resolutionTemplate->ai_steps) ? implode("\n", $resolutionTemplate->ai_steps) : '') }}</textarea>
                    </div>

                    <div class="group full">
                        <label class="label">Upload Images (multiple)</label>
                        <input class="input" type="file" name="kb_images[]" multiple accept="image/*">
                    </div>

                    <div class="group full">
                        <label class="label">Existing Images</label>
                        <div class="gallery">
                            @forelse($resolutionTemplate->images as $image)
                                <div class="imgbox">
                                    <img src="{{ url('/storage/' . $image->image_path) }}" alt="KB Image">
                                    <label style="display:block; margin-top:10px; font-size:13px;">
                                        <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}"> Delete this image
                                    </label>
                                </div>
                            @empty
                                <div>No images uploaded.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="group full">
                        <label style="font-size:14px; font-weight:700;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $resolutionTemplate->is_active) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">Save Changes</button>

                    @if(in_array(auth()->user()->role ?? '', ['admin']))
                        <form method="POST"
                              action="{{ route('resolution-library.destroy', $resolutionTemplate) }}"
                              onsubmit="return confirm('Delete this knowledge base item?');"
                              style="display:inline-flex;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit" style="background:#7f1d1d; border:1px solid rgba(255,255,255,.18);">
                                Delete
                            </button>
                        </form>
                    @endif

                    <a class="btn btn-secondary" href="{{ route('resolution-library.index') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
