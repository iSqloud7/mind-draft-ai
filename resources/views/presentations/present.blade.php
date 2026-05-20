<!DOCTYPE html>
<html>
<head>
    <title>{{ $presentation->title }}</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #111;
            color: white;
            overflow: hidden;
        }

        .slide {
            display: none;
            height: 100vh;
            width: 100vw;
            padding: 80px;
            box-sizing: border-box;
        }

        .active {
            display: block;
        }

        h1 {
            font-size: 48px;
        }

        ul {
            font-size: 28px;
        }

        .nav {
            position: fixed;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
        }

        .counter {
            position: fixed;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

<div class="counter">
    Slide <span id="current">1</span> / {{ count($presentation->structure['slides']) }}
</div>

@foreach($presentation->structure['slides'] as $index => $slide)
    <div class="slide {{ $index === 0 ? 'active' : '' }}">
        <h1>{{ $slide['title'] }}</h1>

        <ul>
            @foreach($slide['bullets'] as $bullet)
                <li>{{ $bullet }}</li>
            @endforeach
        </ul>

        <p style="margin-top:40px;">
            {{ $slide['notes'] }}
        </p>
    </div>
@endforeach

<div class="nav">
    <button onclick="prevSlide()">Prev</button>
    <button onclick="nextSlide()">Next</button>
</div>

<script>
    let slides = document.querySelectorAll('.slide');
    let current = 0;

    function showSlide(index) {
        slides.forEach((s, i) => {
            s.classList.remove('active');
            if (i === index) s.classList.add('active');
        });

        document.getElementById('current').innerText = index + 1;
    }

    function nextSlide() {
        if (current < slides.length - 1) {
            current++;
            showSlide(current);
        }
    }

    function prevSlide() {
        if (current > 0) {
            current--;
            showSlide(current);
        }
    }

    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight') nextSlide();
        if (e.key === 'ArrowLeft') prevSlide();
    });
</script>

</body>
</html><?php
