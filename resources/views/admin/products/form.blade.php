<div class="mb-3">
    <label>Category</label>
    <select name="category_id" class="form-control" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $id => $name)
            <option value="{{ $id }}"
                {{ old('category_id', $product->category_id ?? '') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Product Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" step="0.01" name="price" class="form-control"
           value="{{ old('price', $product->price ?? '') }}" required>
</div>
<div class="mb-3">
    <label>Stock </label>
    <input type="number" name="stock" class="form-control"
           value="{{ old('stock', $product->stock ?? 0) }}" min="0" required>
</div>

<div class="mb-3">
    <label>Product Image</label>
    <input type="file" name="image" class="form-control">

    @if(!empty($product->image))
        <div class="mt-2">
            <img src="{{ asset('storage/'.$product->image) }}" width="90" class="border rounded">
        </div>
    @endif
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="1" {{ old('status', $product->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
        <option value="0" {{ old('status', $product->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

<button type="submit" class="btn btn-success">Save Product</button>
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
