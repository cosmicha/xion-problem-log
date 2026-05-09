@php
    $groups = $groups ?? [
        'problem' => 'Problem Photos',
        'solution' => 'Solution Photos',
    ];

    $allAttachments = \App\Models\Attachment::where('attachable_type', $attachableType)
        ->where('attachable_id', $attachableId)
        ->latest()
        ->get()
        ->groupBy('attachment_group');
@endphp

<div style="margin-top:24px;padding:22px;border-radius:22px;background:#fff;border:1px solid #e2e8f0;box-shadow:0 12px 30px rgba(15,23,42,.06);">
    <h3 style="margin:0 0 16px;font-size:22px;font-weight:950;">Photo Attachments</h3>

    <form method="POST" action="{{ route('attachments.store', [$uploadType, $attachableId]) }}" enctype="multipart/form-data" style="margin-bottom:22px;">
        @csrf

        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <select name="attachment_group" required style="height:48px;border:1px solid #cbd5e1;border-radius:14px;padding:0 12px;background:#f8fafc;">
                @foreach($groups as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <input type="file" name="photos[]" multiple accept="image/*"
                   style="border:1px solid #cbd5e1;border-radius:14px;padding:12px;background:#f8fafc;">

            <button type="submit"
                    style="border:0;border-radius:14px;background:#2563eb;color:white;font-weight:900;padding:13px 18px;cursor:pointer;">
                Upload Photos
            </button>
        </div>

        <div style="font-size:13px;color:#64748b;margin-top:8px;">
            Select photo type, then upload one or multiple photos.
        </div>
    </form>

    @foreach($groups as $groupKey => $groupTitle)
        <div style="margin-top:22px;">
            <h4 style="font-size:18px;font-weight:950;margin:0 0 12px;">{{ $groupTitle }}</h4>

            @php
                $attachments = $allAttachments->get($groupKey, collect());
            @endphp

            @if($attachments->count())
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:14px;">
                    @foreach($attachments as $photo)
                        <div style="border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;background:#f8fafc;">
                            <a href="{{ asset('storage/'.$photo->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/'.$photo->file_path) }}"
                                     style="width:100%;height:140px;object-fit:cover;display:block;">
                            </a>

                            <form method="POST" action="{{ route('attachments.destroy', $photo) }}" onsubmit="return confirm('Delete this photo?')" style="padding:8px;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        style="width:100%;border:0;border-radius:10px;background:#dc2626;color:white;font-weight:800;padding:8px;cursor:pointer;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="color:#64748b;">No photos uploaded yet.</div>
            @endif
        </div>
    @endforeach
</div>
