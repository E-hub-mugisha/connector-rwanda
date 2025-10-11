@extends('layouts.staradmin')
@section('title', 'Edit Working Hour')
@section('content')

<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow mb-4">
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Card Title -->
                    <h4 class="card-title ">@yield('title')'</h4>
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    <form action="{{ route('working_hours.update', $workingHour->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="day" class="form-label">Day</label>
                                <input type="text" class="form-control" name="day" id="day" value="{{ $workingHour->day }}">
                                @error('day')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="start_time" value="{{ $workingHour->start_time }}">
                                @error('start_time')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="end_time" value="{{ $workingHour->end_time }}">
                                @error('end_time')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="is_closed" class="form-label">Is Closed</label>
                                <input type="checkbox" name="is_closed" id="is_closed" value="1" {{ $workingHour->is_closed ? 'checked' : '' }}>
                            </div>
                            <button type="submit" class="btn btn-primary col-md-2">Submit</button>
                        </div>
                    </form>
                </div>
                <script>
                    document.getElementById('is_closed').addEventListener('change', function() {
                        let timeFields = document.querySelectorAll('#time-fields');
                        if (this.checked) {
                            timeFields.forEach(function(field) {
                                field.style.display = 'none';
                            });
                        } else {
                            timeFields.forEach(function(field) {
                                field.style.display = 'block';
                            });
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection