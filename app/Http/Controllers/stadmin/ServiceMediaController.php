<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceMedia;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceMediaController extends Controller
{
    public function index()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $services = Service::where('service_provider_id', $sprovider->id)->get();
        $medias = ServiceMedia::all();
        return view('stadmin.media.index', compact('services','medias'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'files.*' => 'required|mimes:jpg,png,jpeg,mp4,mov,avi',
        ]);
        
        if ($file) {
            $destinationPath = 'image/services/';
            $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profileImage);
            $service->file = $profileImage;
            
            // Determine file type
            $type = in_array($file->getClientOriginalExtension(), ['mp4', 'mov', 'avi']) ? 'video' : 'image';
        }
        
        // Save only the filename (not full path) in the database
            ServiceMedia::create([
                'service_id' => $request->service_id,
                'file_path' => $profileImage, // Only filename stored
                'type' => $type
            ]);
    
    
        return back()->with('success', 'Media upload successfully.');
        
    }

    public function destroy($id)
    {
        $media = ServiceMedia::findOrFail($id);
        $media->delete();

        // Redirect to the previous page with success message
        return back()->with('success', 'Media deleted successfully.');
    }
}
