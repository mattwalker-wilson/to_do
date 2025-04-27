@csrf

<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title"
           class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $toDoItem->title ?? '') }}" required>
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description (optional)</label>
    <textarea name="description" id="description" rows="3"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $toDoItem->description ?? '') }}</textarea>
    @error('description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="completed" id="completed"
           value="1" {{ old('completed', $toDoItem->completed ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="completed">Mark as completed</label>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('lists.index', $toDoList) }}" class="btn btn-secondary">Back to List</a>
    <button type="submit" class="btn btn-success">Save</button>
</div>
