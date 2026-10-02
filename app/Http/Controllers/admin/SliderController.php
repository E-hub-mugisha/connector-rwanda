<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ]);

        $slider = new Slider();

        $slider->title = $request->title;
        $slider->status = $request->status;

        if ($request->hasFile('image')) {

            $destinationPath = public_path('image/slider');

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image = $request->file('image');

            $imageName = date('YmdHis')
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();

            $image->move($destinationPath, $imageName);

            $slider->image = $imageName;
        }

        $slider->save();

        return redirect()
            ->route('admin.slider')
            ->with('message', 'Slider created successfully!');
    }

    public function show($id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.sliders.show', compact('slider'));
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ]);

        $slider->title = $request->title;
        $slider->status = $request->status;

        if ($request->hasFile('image')) {

            $oldImage = public_path('image/slider/' . $slider->image);

            if (
                $slider->image &&
                file_exists($oldImage)
            ) {
                unlink($oldImage);
            }

            $destinationPath = public_path('image/slider');

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image = $request->file('image');

            $imageName = date('YmdHis')
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();

            $image->move($destinationPath, $imageName);

            $slider->image = $imageName;
        }

        $slider->save();

        return redirect()
            ->route('admin.slider')
            ->with('message', 'Slider updated successfully!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        $imagePath = public_path('image/slider/' . $slider->image);

        if (
            $slider->image &&
            file_exists($imagePath)
        ) {
            unlink($imagePath);
        }

        $slider->delete();

        return redirect()
            ->route('admin.slider')
            ->with('message', 'Slider deleted successfully!');
    }
}