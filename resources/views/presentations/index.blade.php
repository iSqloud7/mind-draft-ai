<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Presentations</title>
</head>
<body>
<h1>All Presentations</h1>
<a href="/presentations/create">+ Create New</a>

@foreach($presentations as $presentation)
    <div style="border:1px solid #ccc; padding:16px; margin:16px 0;">
        <h2>{{ $presentation->title }}</h2>
        <p>{{ $presentation->topic }}</p>
        <a href="/presentations/{{ $presentation->id }}">View →</a>
    </div>
@endforeach
</body>
</html>
