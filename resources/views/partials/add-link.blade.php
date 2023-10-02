<!-- resources/views/partials/add-link.blade.php -->

<form action="{{ route('store') }}" method="post">
    @csrf
    <label for="url">URL:</label>
    <input type="text" name="url" id="url" required>
    <button type="submit">Agregar Enlace</button>
</form>
