<!DOCTYPE html>
<html>
<head>
    <title>{{ $presentation->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans;
            margin: 30px;
        }

        .slide {
            page-break-after: always;
            padding: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        ul {
            margin-left: 20px;
        }

        .notes {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

@foreach($presentation->structure['slides'] as $slide)
    <div class="slide">
        <h1>{{ $slide['title'] }}</h1>

        <ul>
            @foreach($slide['bullets'] as $bullet)
                <li>{{ $bullet }}</li>
            @endforeach
        </ul>

        <div class="notes">
            <strong>Notes:</strong>
            {{ $slide['notes'] }}
        </div>
    </div>
@endforeach

</body>
</html>
