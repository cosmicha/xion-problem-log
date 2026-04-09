<!DOCTYPE html>
<html>
<head>
    <title>View Problem Log</title>
</head>
<body style="font-family: Arial; padding: 40px;">

@php use Illuminate\Support\Facades\Storage; @endphp

<h1>{{ $problemLog->title }}</h1>

<p><strong>Status:</strong> {{ $problemLog->status }}</p>
<p><strong>Priority:</strong> {{ $problemLog->priority }}</p>

@if($problemLog->photo)
    <p><strong>Photo:</strong></p>
    <p>
        <img src="{{ Storage::url($problemLog->photo) }}" style="max-width: 400px;">
    </p>
@endif

<p><strong>Description:</strong></p>
<p>{{ $problemLog->description }}</p>

<hr>

<h3>Timeline</h3>
<p>Opened at: {{ $problemLog->opened_at }}</p>
<p>In Progress at: {{ $problemLog->in_progress_at }}</p>
<p>Closed at: {{ $problemLog->closed_at }}</p>

@if($problemLog->closed_photo)
    <p><strong>Closed Photo:</strong></p>
    <img src="{{ Storage::url($problemLog->closed_photo) }}" style="max-width: 400px;">
@endif

<p><a href="/problem-logs">Back</a></p>

</body>
</html>
