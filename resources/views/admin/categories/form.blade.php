<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control"
value="{{ old('name', $category->name ?? '') }}" required>
</div>


<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="1" {{ old('status', $category->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
<option value="0" {{ old('status', $category->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
</select>
</div>


<button class="btn btn-success">Save</button>
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>