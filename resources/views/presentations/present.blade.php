<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $presentation->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f0f1a;
            color: white;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
        }

        .slide {
            display: none;
            height: 100vh;
            width: 100vw;
            padding: 80px 100px;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .slide.active { display: flex; }

        .slide-number-badge {
            position: absolute;
            top: 32px;
            right: 40px;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        .slide-index {
            font-size: 13px;
            font-weight: 700;
            color: #818cf8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 20px;
        }

        .slide h1 {
            font-size: 52px;
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 40px;
            max-width: 900px;
        }

        .bullets {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 18px;
            max-width: 820px;
        }

        .bullets li {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            font-size: 26px;
            color: rgba(255,255,255,0.85);
            line-height: 1.4;
        }

        .bullet-dot {
            flex-shrink: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #818cf8;
            margin-top: 10px;
        }

        .notes-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,0.05);
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 14px 100px;
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notes-label {
            font-size: 11px;
            font-weight: 700;
            color: #f59e0b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            flex-shrink: 0;
        }

        .nav {
            position: fixed;
            bottom: 60px;
            right: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav button {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav button:hover {
            background: rgba(129,140,248,0.3);
            border-color: #818cf8;
        }

        .nav button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #818cf8, #a855f7);
            transition: width 0.4s ease;
        }

        .exit-btn {
            position: fixed;
            top: 24px;
            left: 32px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.5);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .exit-btn:hover {
            background: rgba(255,255,255,0.12);
            color: white;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .slide.active { animation: slideIn 0.35s ease; }
    </style>
</head>
<body>

<div class="progress" id="progress"></div>

<a href="/presentations/{{ $presentation->id }}" class="exit-btn">✕ Exit</a>

@php $slides = $presentation->structure['slides']; $total = count($slides); @endphp

@foreach($slides as $index => $slide)
    <div class="slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
        <div class="slide-number-badge">
            {{ $index + 1 }} / {{ $total }}
        </div>
        <div class="slide-index">Slide {{ $index + 1 }}</div>
        <h1>{{ $slide['title'] }}</h1>
        <ul class="bullets">
            @foreach($slide['bullets'] as $bullet)
                <li>
                    <span class="bullet-dot"></span>
                    <span>{{ $bullet }}</span>
                </li>
            @endforeach
        </ul>

        @if(!empty($slide['notes']))
            <div class="notes-bar">
                <span class="notes-label">Notes</span>
                <span>{{ $slide['notes'] }}</span>
            </div>
        @endif
    </div>
@endforeach

<div class="nav">
    <button onclick="prevSlide()" id="prev-btn" disabled>
        ← Prev
    </button>
    <button onclick="nextSlide()" id="next-btn">
        Next →
    </button>
</div>

<script>
    const slides = document.querySelectorAll('.slide');
    const total = slides.length;
    let current = 0;

    function updateUI() {
        slides.forEach((s, i) => s.classList.toggle('active', i === current));
        document.getElementById('prev-btn').disabled = current === 0;
        document.getElementById('next-btn').disabled = current === total - 1;
        document.getElementById('next-btn').textContent = current === total - 1 ? 'End' : 'Next →';
        document.getElementById('progress').style.width = ((current + 1) / total * 100) + '%';
    }

    function nextSlide() { if (current < total - 1) { current++; updateUI(); } }
    function prevSlide() { if (current > 0) { current--; updateUI(); } }

    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'Space') nextSlide();
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'Escape') window.location = '/presentations/{{ $presentation->id }}';
    });

    updateUI();
</script>
</body>
</html>
