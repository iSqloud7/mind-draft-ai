<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #0d0d12;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .page {
            width: 297mm;
            height: 210mm;
            padding: 40px; /* Намален малку за сигурност */
            box-sizing: border-box;
            position: relative;
            /* Клучната промена: се користи page-break-after само ако не е последен слајд */
            page-break-after: always;
        }

        /* Елиминирање на вишокот простор во блоковите */
        h1 { font-size: 30px; border-bottom: 2px solid #ef4444; padding-bottom: 8px; margin: 0 0 20px 0; color: #ffffff; text-transform: uppercase; }
        .bullet { font-size: 19px; margin-bottom: 10px; color: #e5e7eb; line-height: 1.2; }
        .footer { position: absolute; bottom: 20px; left: 40px; font-size: 10px; color: #444; }
    </style>
</head>
<body>

@foreach($presentation->structure['slides'] as $index => $slide)
    {{-- Спречување на празна страна по последниот слајд --}}
    <div class="page" @if($loop->last) style="page-break-after: avoid;" @endif>
        <h1>{{ $slide['title'] }}</h1>

        @foreach($slide['bullets'] as $bullet)
            <div class="bullet">■ {{ $bullet }}</div>
        @endforeach

        <div class="footer">Страна {{ $index + 1 }} од {{ count($presentation->structure['slides']) }}</div>
    </div>
@endforeach

</body>
</html>
