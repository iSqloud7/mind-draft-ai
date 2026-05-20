<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $presentation->title }}</title>
</head>
<body>
<h1>{{ $presentation->title }}</h1>
<p><strong>Topic:</strong> {{ $presentation->topic }}</p>

@foreach($presentation->structure['slides'] as $slide)
    <div style="border:1px solid #ccc; padding:16px; margin:16px 0;">
        <h2>{{ $slide['title'] }}</h2>
        <ul>
            @foreach($slide['bullets'] as $bullet)
                <li>{{ $bullet }}</li>
            @endforeach
        </ul>
        <p><em>Notes: {{ $slide['notes'] }}</em></p>
    </div>
@endforeach

<a href="/presentations">← Back to list</a>
</body>
</html>
