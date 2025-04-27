@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name',  $toDoList->name ?? '') }}" required>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('lists.index') }}" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-success">Save</button>
</div>
