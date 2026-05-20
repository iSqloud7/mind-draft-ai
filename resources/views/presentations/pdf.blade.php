<style>
    .page {
        width: 297mm;
        height: 210mm;
        padding: 50px;
        box-sizing: border-box;
        page-break-after: always;
        color: #ffffff;
        font-family: sans-serif;
    }
    h1 {
        font-size: 40px;
        border-bottom: 3px solid #ef4444;
        padding-bottom: 15px;
        margin-bottom: 30px;
        text-transform: uppercase;
    }
    .bullet { font-size: 22px; margin-bottom: 20px; color: #e5e7eb; }
    .footer { position: absolute; bottom: 30px; left: 50px; font-size: 12px; color: #666; }
</style>

@foreach($presentation->structure['slides'] as $index => $slide)
    <div class="page">
        <h1>{{ $slide['title'] }}</h1>
        @foreach($slide['bullets'] as $bullet)
            <div class="bullet">■ {{ $bullet }}</div>
        @endforeach

        <div class="footer">Страна {{ $index + 1 }} од {{ count($presentation->structure['slides']) }}</div>
    </div>
@endforeach
