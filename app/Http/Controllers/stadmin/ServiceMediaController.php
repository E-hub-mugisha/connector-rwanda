<?php

namespace App\Http\Controllers\stadmin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceMedia;
use App\Models\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceMediaController extends Controller
{
    public function index()
    {
        $sprovider = ServiceProvider::where('user_id', Auth::user()->id)->first();
        $services = Service::where('service_provider_id', $sprovider->id)->get();
        $medias = ServiceMedia::all();
        return view('stadmin.media.index', compact('services', 'medias'));
    }

     /**
     * Get the authenticated service provider.
     */
    private function provider(): ServiceProvider
    {
        return ServiceProvider::where(
            'user_id',
            Auth::id()
        )->firstOrFail();
    }

    /**
     * Upload service media.
     */
    public function store(Request $request)
    {
        $provider = $this->provider();

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'files' => [
                'required',
                'array',
                'min:1',
            ],

            'files.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,mp4,mov,avi',
                'max:51200', // 50 MB per file
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify service belongs to authenticated provider
        |--------------------------------------------------------------------------
        */

        $service = Service::where('id', $validated['service_id'])
            ->where(
                'service_provider_id',
                $provider->id
            )
            ->firstOrFail();

        $destinationPath = public_path(
            'image/services/media'
        );

        /*
        |--------------------------------------------------------------------------
        | Create directory if it doesn't exist
        |--------------------------------------------------------------------------
        */

        if (!File::exists($destinationPath)) {
            File::makeDirectory(
                $destinationPath,
                0755,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload files
        |--------------------------------------------------------------------------
        */

        foreach ($validated['files'] as $file) {

            $extension = strtolower(
                $file->getClientOriginalExtension()
            );

            $type = in_array(
                $extension,
                ['mp4', 'mov', 'avi']
            )
                ? 'video'
                : 'image';

            $fileName = date('YmdHis')
                . '_'
                . uniqid()
                . '.'
                . $extension;

            $file->move(
                $destinationPath,
                $fileName
            );

            ServiceMedia::create([
                'service_id' => $service->id,
                'file_path'  => $fileName,
                'type'       => $type,
            ]);
        }

        return back()->with(
            'success',
            'Service media uploaded successfully.'
        );
    }

    /**
     * Delete service media.
     */
    public function destroy($id)
    {
        $provider = $this->provider();

        /*
        |--------------------------------------------------------------------------
        | Find media belonging to provider's service
        |--------------------------------------------------------------------------
        */

        $media = ServiceMedia::whereKey($id)
            ->whereHas('service', function ($query) use ($provider) {
                $query->where(
                    'service_provider_id',
                    $provider->id
                );
            })
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Delete physical file
        |--------------------------------------------------------------------------
        */

        $filePath = public_path(
            'image/services/media/' . $media->file_path
        );

        if (
            $media->file_path &&
            File::exists($filePath)
        ) {
            File::delete($filePath);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete database record
        |--------------------------------------------------------------------------
        */

        $media->delete();

        return back()->with(
            'success',
            'Media deleted successfully.'
        );
    }
}
