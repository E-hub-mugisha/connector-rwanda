<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use App\Models\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WorkingHourController extends Controller
{
    public function index()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $workingHours = WorkingHour::where('sprovider_id', $sprovider->id)->get();
        return view('stadmin.working_hours.index', compact('workingHours', 'sprovider'));
    }

    public function create()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        return view('stadmin.working_hours.create', compact('sprovider'));
    }

    public function store(Request $request)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'day' => [
                'required',
                Rule::in([
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ]),
            ],
            'start_time' => [
                'nullable',
                'date_format:H:i',
                'required_unless:is_closed,1',
            ],
            'end_time' => [
                'nullable',
                'date_format:H:i',
                'required_unless:is_closed,1',
                'after:start_time',
            ],
            'is_closed' => [
                'nullable',
                'boolean',
            ],
        ], [
            'start_time.required_unless' => 'Please enter the opening time.',
            'end_time.required_unless' => 'Please enter the closing time.',
            'end_time.after' => 'Closing time must be after opening time.',
        ]);

        $isClosed = $request->boolean('is_closed');

        /*
         * Prevent duplicate days.
         */
        $exists = WorkingHour::where('service_provider_id', $sprovider->id)
            ->where('day', $validated['day'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Working hours for ' . $validated['day'] . ' already exist.');
        }

        WorkingHour::create([
            'service_provider_id' => $sprovider->id,
            'day' => $validated['day'],
            'start_time' => $isClosed ? null : $validated['start_time'],
            'end_time' => $isClosed ? null : $validated['end_time'],
            'is_closed' => $isClosed,
        ]);

        return back()->with(
            'success',
            'Working hours for ' . $validated['day'] . ' added successfully.'
        );
    }

    /**
     * Return a working hour for editing.
     */
    public function edit($id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::id())
            ->firstOrFail();

        $workingHour = WorkingHour::where('service_provider_id', $sprovider->id)
            ->findOrFail($id);

        return response()->json([
            'id' => $workingHour->id,
            'day' => $workingHour->day,
            'start_time' => $workingHour->start_time
                ? substr($workingHour->start_time, 0, 5)
                : '',
            'end_time' => $workingHour->end_time
                ? substr($workingHour->end_time, 0, 5)
                : '',
            'is_closed' => (bool) $workingHour->is_closed,
        ]);
    }

    /**
     * Update a working hour.
     */
    public function update(Request $request, $id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::id())
            ->firstOrFail();

        $workingHour = WorkingHour::where('service_provider_id', $sprovider->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'day' => [
                'required',
                Rule::in([
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                ]),
            ],
            'start_time' => [
                'nullable',
                'date_format:H:i',
                'required_unless:is_closed,1',
            ],
            'end_time' => [
                'nullable',
                'date_format:H:i',
                'required_unless:is_closed,1',
                'after:start_time',
            ],
            'is_closed' => [
                'nullable',
                'boolean',
            ],
        ], [
            'start_time.required_unless' => 'Please enter the opening time.',
            'end_time.required_unless' => 'Please enter the closing time.',
            'end_time.after' => 'Closing time must be after opening time.',
        ]);

        $isClosed = $request->boolean('is_closed');

        /*
         * Prevent another working-hour record from using the same day.
         */
        $duplicate = WorkingHour::where('service_provider_id', $sprovider->id)
            ->where('day', $validated['day'])
            ->where('id', '!=', $workingHour->id)
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->with('error', 'Working hours for ' . $validated['day'] . ' already exist.');
        }

        $workingHour->update([
            'day' => $validated['day'],
            'start_time' => $isClosed ? null : $validated['start_time'],
            'end_time' => $isClosed ? null : $validated['end_time'],
            'is_closed' => $isClosed,
        ]);

        return back()->with(
            'success',
            'Working hours updated successfully.'
        );
    }

    /**
     * Delete a working hour.
     */
    public function destroy($id)
    {
        $sprovider = ServiceProvider::where('user_id', Auth::id())
            ->firstOrFail();

        $workingHour = WorkingHour::where('service_provider_id', $sprovider->id)
            ->findOrFail($id);

        $day = $workingHour->day;

        $workingHour->delete();

        return back()->with(
            'success',
            'Working hours for ' . $day . ' deleted successfully.'
        );
    }
}
