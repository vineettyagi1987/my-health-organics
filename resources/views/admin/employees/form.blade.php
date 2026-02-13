<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control"
value="{{ old('name', $employee->name ?? '') }}" required>
</div>


<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control"
value="{{ old('email', $employee->email ?? '') }}" required>
</div>


<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control"
value="{{ old('phone', $employee->phone ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Department</label>
    <input type="text" name="department" class="form-control"
           value="{{ old('department', $employee->department ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Company Role / Title</label>
    <input type="text" name="company_title" class="form-control"
           value="{{ old('company_title', $employee->company_title ?? '') }}" required>
</div>
<div class="mb-3">
<label>Password {{ isset($employee) ? '(leave blank to keep same)' : '' }}</label>
<input type="password" name="password" class="form-control">
</div>


<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="1" {{ old('status', $employee->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
<option value="0" {{ old('status', $employee->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
</select>
</div>


<button class="btn btn-success">Save</button>
<a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Back</a>