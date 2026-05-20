<div id="slides-container">

    @foreach($presentation->structure['slides'] as $index => $slide)

        <div class="slide-card" data-index="{{ $index }}"
             style="border:1px solid gray; padding:10px; margin:20px 0; cursor:grab;">

            <h3>Slide {{ $index + 1 }}</h3>

            <label>Slide Title</label>
            <input
                type="text"
                name="slides[{{ $index }}][title]"
                value="{{ $slide['title'] }}"
            >

            <br><br>

            <form method="POST" action="/presentations/{{ $presentation->id }}/regenerate-slide/{{ $index }}">
                @csrf
                <button type="submit">Regenerate Slide</button>
            </form>

            <br><br>

            <label>Bullets</label>

            @foreach($slide['bullets'] as $bIndex => $bullet)
                <input
                    type="text"
                    name="slides[{{ $index }}][bullets][{{ $bIndex }}]"
                    value="{{ $bullet }}"
                >
                <br>
            @endforeach

            <br>

            <label>Notes</label>
            <textarea name="slides[{{ $index }}][notes]">
            {{ $slide['notes'] }}
        </textarea>

        </div>

    @endforeach

</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    const container = document.getElementById('slides-container');

    Sortable.create(container, {
        animation: 150,
        onEnd: function () {
            reindexSlides();
        }
    });

    function reindexSlides() {
        const cards = document.querySelectorAll('.slide-card');

        cards.forEach((card, index) => {
            const inputs = card.querySelectorAll('input, textarea');

            inputs.forEach(input => {
                input.name = input.name.replace(/slides\[\d+\]/, `slides[${index}]`);
            });

            card.querySelector('h3').innerText = `Slide ${index + 1}`;
        });
    }
</script>
