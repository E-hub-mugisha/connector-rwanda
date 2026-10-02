<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerLogo;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display partners.
     */
    public function index()
    {
        $partners = PartnerLogo::latest()->get();

        return view('admin.partners.index', compact('partners'));
    }


    /**
     * Store a new partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png',
                'max:5120',
            ],
        ]);


        $partner = new PartnerLogo();

        $partner->name = $request->name;


        if ($request->hasFile('image')) {

            $destinationPath = public_path('image/partner');

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $image = $request->file('image');

            $imageName = date('YmdHis')
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();

            $image->move(
                $destinationPath,
                $imageName
            );

            $partner->image = $imageName;
        }


        $partner->save();


        return redirect()
            ->route('admin.partners')
            ->with(
                'message',
                'Partner created successfully!'
            );
    }


    /**
     * Show partner.
     */
    public function show($id)
    {
        $partner = PartnerLogo::findOrFail($id);

        return view(
            'admin.partners.show',
            compact('partner')
        );
    }


    /**
     * Edit partner.
     *
     * Not required because editing is now handled
     * directly through the index modal.
     */
    public function edit($id)
    {
        $partner = PartnerLogo::findOrFail($id);

        return view(
            'admin.partners.edit',
            compact('partner')
        );
    }


    /**
     * Update partner.
     */
    public function update(Request $request, $id)
    {
        $partner = PartnerLogo::findOrFail($id);


        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png',
                'max:5120',
            ],
        ]);


        $partner->name = $request->name;


        /*
        |--------------------------------------------------------------------------
        | Replace Image Only If New Image Was Uploaded
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $oldImagePath =
                public_path(
                    'image/partner/' . $partner->image
                );


            if (
                $partner->image &&
                file_exists($oldImagePath)
            ) {
                unlink($oldImagePath);
            }


            $destinationPath =
                public_path('image/partner');


            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }


            $image =
                $request->file('image');


            $imageName =
                date('YmdHis')
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();


            $image->move(
                $destinationPath,
                $imageName
            );


            $partner->image = $imageName;
        }


        $partner->save();


        return redirect()
            ->route('admin.partners')
            ->with(
                'message',
                'Partner updated successfully!'
            );
    }


    /**
     * Delete partner.
     */
    public function destroy($id)
    {
        $partner = PartnerLogo::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Image From Public Folder
        |--------------------------------------------------------------------------
        */

        $imagePath =
            public_path(
                'image/partner/' . $partner->image
            );


        if (
            $partner->image &&
            file_exists($imagePath)
        ) {
            unlink($imagePath);
        }


        $partner->delete();


        return redirect()
            ->route('admin.partners')
            ->with(
                'message',
                'Partner deleted successfully!'
            );
    }
}