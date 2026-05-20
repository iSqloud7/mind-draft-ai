<form method="POST" action="/presentations">
    @csrf

    <input name="title" placeholder="Title">

    <input name="topic" placeholder="Topic">

    <input name="points[]" placeholder="Point 1">
    <input name="points[]" placeholder="Point 2">
    <input name="points[]" placeholder="Point 3">

    <button type="submit">Generate</button>
</form>
