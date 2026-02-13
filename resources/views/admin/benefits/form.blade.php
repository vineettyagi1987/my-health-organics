<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="{{ old('title',$benefit->title ?? '') }}">
</div>


<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control">{{ old('description',$benefit->description ?? '') }}</textarea>
</div>


<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="1">Active</option>
<option value="0">Inactive</option>
</select>
</div>


<button class="btn btn-success">Save</button>