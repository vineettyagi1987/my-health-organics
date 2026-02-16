<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $distributor->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $distributor->email ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $distributor->phone ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Region / Area</label>
    <input type="text" name="region_area" class="form-control"
           value="{{ old('region_area', $distributor->region_area ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Commission Rate (%)</label>
    <input type="number" step="0.01" name="commission_rate" class="form-control"
           value="{{ old('commission_rate', $distributor->commission_rate ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Password {{ isset($distributor) ? '(leave blank to keep same)' : '' }}</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ old('status', $distributor->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $distributor->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

<button class="btn btn-success">Save</button>
<a href="{{ route('admin.distributors.index') }}" class="btn btn-secondary">Back</a>
