@props([
    'action',
    'confirm' => 'Delete this record? This action cannot be undone.',
])

<form action="{{ $action }}" method="POST" class="d-inline js-delete-form"
    data-confirm="{{ $confirm }}">
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->merge(['class' => 'btn btn-delete']) }}>Delete</button>
</form>
