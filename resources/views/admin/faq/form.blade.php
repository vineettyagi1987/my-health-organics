<div class="mb-3">
    <label>Question</label>
    <input type="text" name="question" class="form-control"
           value="{{ old('question', $faq->question ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Answer</label>
    <textarea name="answer" class="form-control" rows="4" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ old('status', $faq->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $faq->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

<button class="btn btn-success">Save</button>
<a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">Back</a>
