@extends('layouts.staradmin')
@section('title', 'Working Hours')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <div>
                            <h4 class="card-title card-title-dash">@yield('title')</h4>
                        </div>
                        <div>
                            <div class="btn-wrapper">
                                <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button" data-bs-toggle="modal" data-bs-target="#portfolioModal"><i class="mdi mdi-plus"></i>Add new Hours</button>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    <div class="table-responsive  mt-1">
                        <table class="table select-table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Is Closed</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workingHours as $workingHour)
                                <tr>
                                <td>{{ $workingHour->day }}</td>
                                <td>{{ $workingHour->is_closed ? 'Yes' : 'No' }}</td>
                                <td>{{ $workingHour->start_time }}</td>
                                <td>{{ $workingHour->end_time }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('working_hours.edit', $workingHour->id) }}">Edit</a>
                                    <form action="{{ route('working_hours.destroy', $workingHour->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="portfolioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@yield('title')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif

                    <form action="{{ route('working_hours.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="sprovider_id" value="{{ $sprovider->id }}">
                                <div class="mb-3">
                                    <label for="day" class="form-label">Day</label>
                                    <input type="text" class="form-control" name="day" id="day" placeholder="Enter Day">
                                    @error('day')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="is_closed" class="form-label">Is Closed</label>
                                    <input type="checkbox" name="is_closed" id="is_closed" value="1">
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                    @error('start_time')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control" name="end_time" id="end_time">
                                    @error('end_time')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
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
@endsection