@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <h1 class="mb-4">Create Post</h1>

    <form id="create-post-form">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Post</button>
    </form>
@endsection

@section('scripts')
<script>
document.getElementById('create-post-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    fetch('/api/posts', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ title, content })
    }).then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    }).then(() => {
        window.location.href = '/';
    }).catch(error => {
        console.error('Error creating post:', error);
    });
});
</script>
@endsection
