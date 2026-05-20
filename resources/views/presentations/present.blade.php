<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $presentation->title }} - MindDraft Presenter</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0d0d12;
            color: #f4f4f5;
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            user-select: none;
            cursor: none;
        }

        #laser-pointer {
            position: fixed;
            width: 28px;
            height: 28px;
            background: rgba(239, 68, 68, 0.4);
            border: 2px solid #ffffff;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 15px #ef4444, 0 0 35px #ef4444, inset 0 0 8px #ef4444;
            transition: width 0.2s, height 0.2s, background 0.2s;
            animation: laserPulse 2s infinite alternate;
        }

        @keyframes laserPulse {
            from { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            to   { transform: translate(-50%, -50%) scale(1.15); opacity: 1; }
        }

        body.laser-hover #laser-pointer {
            width: 12px;
            height: 12px;
            background: #ffffff;
            box-shadow: 0 0 20px #ffffff, 0 0 40px #ef4444;
        }

        .top-hud {
            position: fixed;
            top: 24px;
            left: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 100;
        }

        .hud-btn {
            background: rgba(24, 24, 27, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: none;
        }

        .hud-btn:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.4);
        }

        .btn-export {
            border-color: rgba(239, 68, 68, 0.4);
            color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .slide {
            display: none;
            height: 100vh;
            width: 100vw;
            padding: 80px 120px 100px 120px;
            flex-direction: column;
            justify-content: center;
            position: relative;
            background: radial-gradient(circle at 15% 25%, rgba(220, 38, 38, 0.04) 0%, transparent 60%);
        }

        .slide.active { display: flex; }

        .slide-number {
            position: absolute;
            top: 32px;
            right: 40px;
            font-size: 14px;
            color: rgba(255,255,255,0.3);
            font-weight: 700;
            letter-spacing: 0.1em;
            z-index: 30;
        }

        .slide-index {
            font-size: 14px;
            font-weight: 900;
            color: #ef4444;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .slide h1 {
            font-size: 54px;
            font-weight: 900;
            line-height: 1.1;
            color: #ffffff;
            margin-bottom: 40px;
            max-width: 1000px;
            text-transform: uppercase;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
            flex-shrink: 0;
        }

        .scroll-area {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 280px);
            padding-right: 25px;
            padding-top: 4px;
            padding-bottom: 24px;
        }

        .scroll-area::-webkit-scrollbar { width: 4px; }
        .scroll-area::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
        .scroll-area::-webkit-scrollbar-thumb { background: #ef4444; border-radius: 10px; }

        .bullets {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 24px;
            max-width: 950px;
        }

        .bullets:hover li {
            opacity: 0.25;
            transform: scale(0.98);
        }

        .bullets li {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            font-size: 26px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.4;
            font-weight: 500;
            transition: opacity 0.3s ease, transform 0.3s ease, color 0.3s ease, background 0.3s ease;
            padding: 12px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.02);
        }

        .bullets li:hover {
            opacity: 1 !important;
            color: #ffffff;
            background: rgba(239, 68, 68, 0.04);
            border-color: rgba(239, 68, 68, 0.15);
            transform: scale(1.02) translateX(10px) !important;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ef4444;
            margin-top: 12px;
            box-shadow: 0 0 15px #ef4444;
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .bullets li:hover .dot {
            transform: scale(1.4);
            background: #ff6b6b;
            box-shadow: 0 0 20px #ff6b6b;
        }

        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            z-index: 1000;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #ef4444, #7f1d1d);
            box-shadow: 0 0 15px #ef4444;
            transition: width 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .notes-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(20, 20, 25, 0.7);
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 20px 120px;
            font-size: 15px;
            color: rgba(255,255,255,0.6);
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 25;
        }

        .notes-label {
            font-size: 11px;
            font-weight: 900;
            color: #ef4444;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            flex-shrink: 0;
            border: 1px solid rgba(239, 68, 68, 0.4);
            padding: 3px 8px;
            border-radius: 6px;
            background: rgba(239, 68, 68, 0.08);
        }

        .bottom-nav {
            position: fixed;
            bottom: 80px;
            right: 40px;
            display: flex;
            gap: 15px;
            z-index: 100;
        }

        .nav-btn {
            background: #18181b;
            border: 1px solid #27272a;
            color: rgba(255,255,255,0.7);
            padding: 14px 26px;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: none;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-btn:hover:not(:disabled) {
            background: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(239, 68, 68, 0.35);
        }

        .nav-btn:disabled { opacity: 0.15; }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide.active .slide-index { animation: reveal 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .slide.active h1 { animation: reveal 0.55s cubic-bezier(0.16, 1, 0.3, 1) 0.08s forwards; opacity: 0; }
        .slide.active .bullets li { animation: reveal 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }

        .slide.active .bullets li:nth-child(1) { animation-delay: 0.22s; }
        .slide.active .bullets li:nth-child(2) { animation-delay: 0.35s; }
        .slide.active .bullets li:nth-child(3) { animation-delay: 0.48s; }
        .slide.active .bullets li:nth-child(4) { animation-delay: 0.61s; }

        .slide.active .notes-bar { animation: reveal 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.45s forwards; opacity: 0; }
    </style>
</head>
<body>

<div id="laser-pointer"></div>

<div class="progress-container">
    <div class="progress-bar" id="progress"></div>
</div>

<div class="top-hud">
    <a href="/presentations/{{ $presentation->id }}" class="hud-btn HTML-interactive">✕ Exit</a>
    <a href="{{ route('presentations.export-pdf', $presentation) }}" class="hud-btn btn-export HTML-interactive" id="pdf-trigger">
        <svg style="width:14px; height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Export PDF
    </a>
</div>

@php $slides = $presentation->structure['slides']; $total = count($slides); @endphp

@foreach($slides as $index => $slide)
    <div class="slide {{ $index === 0 ? 'active' : '' }}">
        <div class="slide-number">{{ $index + 1 }} / {{ $total }}</div>
        <div class="slide-index">Slide {{ $index + 1 }}</div>
        <h1>{{ $slide['title'] }}</h1>

        <div class="scroll-area">
            <ul class="bullets">
                @foreach($slide['bullets'] as $bullet)
                    <li><span class="dot"></span> <span>{{ $bullet }}</span></li>
                @endforeach
            </ul>
        </div>

        @if(!empty($slide['notes']))
            <div class="notes-bar">
                <span class="notes-label">Notes</span>
                <span>{{ $slide['notes'] }}</span>
            </div>
        @endif
    </div>
@endforeach

<div class="bottom-nav">
    <button onclick="prevSlide(event)" id="prev-btn" class="nav-btn HTML-interactive" disabled>← Prev</button>
    <button onclick="nextSlide(event)" id="next-btn" class="nav-btn HTML-interactive">Next →</button>
</div>

<script>
    const laser = document.getElementById('laser-pointer');
    const slides = document.querySelectorAll('.slide');
    const bar = document.getElementById('progress');
    let current = 0;

    document.addEventListener('mousemove', e => {
        laser.style.left = e.clientX + 'px';
        laser.style.top = e.clientY + 'px';

        const isHovering = e.target.closest('.HTML-interactive') || e.target.closest('a') || e.target.closest('button');
        document.body.classList.toggle('laser-hover', !!isHovering);
    });

    function updateUI() {
        slides.forEach((s, i) => {
            s.classList.toggle('active', i === current);
            if(i === current) {
                const scroll = s.querySelector('.scroll-area');
                if(scroll) scroll.scrollTop = 0;
            }
        });

        document.getElementById('prev-btn').disabled = current === 0;
        document.getElementById('next-btn').disabled = current === slides.length - 1;
        document.getElementById('next-btn').textContent = current === slides.length - 1 ? 'Finish' : 'Next →';
        bar.style.width = ((current + 1) / slides.length * 100) + '%';
    }

    function nextSlide(e) { if(e) e.stopPropagation(); if(current < slides.length - 1) { current++; updateUI(); } }
    function prevSlide(e) { if(e) e.stopPropagation(); if(current > 0) { current--; updateUI(); } }

    document.addEventListener('click', e => {
        if(e.target.closest('.top-hud') || e.target.closest('.bottom-nav') || e.target.closest('.scroll-area')) return;
        e.clientX > window.innerWidth / 2 ? nextSlide() : prevSlide();
    });

    document.addEventListener('keydown', e => {
        if(e.key === 'ArrowRight' || e.key === 'Space' || e.key === 'Enter') nextSlide();
        if(e.key === 'ArrowLeft' || e.key === 'Backspace') prevSlide();
        if(e.key.toLowerCase() === 'p') document.getElementById('pdf-trigger').click();
        if(e.key === 'Escape') window.location = '/presentations/{{ $presentation->id }}';
    });

    updateUI();
</script>
</body>
</html>
