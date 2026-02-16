<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" class="form-control"
           value="{{ old('title', $term->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Content</label>
    <textarea name="content" rows="6" class="form-control" required>{{ old('content', $term->content ?? '') }}</textarea>
</div>

<button class="btn btn-success">Save</button>
<a href="{{ route('admin.terms.index') }}" class="btn btn-secondary">Back</a>
