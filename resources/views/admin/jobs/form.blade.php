<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" value="{{ $job->title ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4" required>{{ $job->description ?? '' }}</textarea>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Type</label>
        <select name="type" class="form-control" required>
            @foreach(['full-time','part-time','contract'] as $type)
                <option value="{{ $type }}" {{ isset($job) && $job->type==$type ? 'selected' : '' }}>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="{{ $job->location ?? '' }}" required>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Requirements</label>
    <textarea name="requirements" class="form-control" rows="3">{{ $job->requirements ?? '' }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Responsibilities</label>
    <textarea name="responsibilities" class="form-control" rows="3">{{ $job->responsibilities ?? '' }}</textarea>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Company</label>
        <select name="company_id" class="form-control" required>
            @foreach(\App\Models\ServiceProvider::all() as $company)
                <option value="{{ $company->id }}" {{ isset($job) && $job->company_id==$company->id ? 'selected' : '' }}>
                    {{ $company->sprovider_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" value="{{ isset($job) ? $job->deadline->format('Y-m-d') : '' }}">
    </div>
</div>
