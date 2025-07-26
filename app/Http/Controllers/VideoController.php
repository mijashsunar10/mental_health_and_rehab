<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Video;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $videos = Video::paginate(10);
        return view('video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return view('video.create');
    }

   
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'video' => 'required|file|mimes:mp4,mov,avi|max:102400', // 100MB max
    ]);

    try {
        // Verify file exists
        if (!$request->hasFile('video')) {
            throw new \Exception('No video file uploaded');
        }

        // Initialize Cloudinary
        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true
            ]
        ]);

        // Upload video
        $uploadResult = $cloudinary->uploadApi()->upload(
            $request->file('video')->getRealPath(),
            [
                'folder' => 'videos',
                'resource_type' => 'video'
            ]
        );

        // Create thumbnail URL
        $thumbnailUrl = "https://res.cloudinary.com/".config('cloudinary.cloud_name').
                       "/image/upload/w_500,h_500,c_fill,q_auto,f_auto/".
                       str_replace('.mp4', '.jpg', $uploadResult['public_id']);

        Video::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_url' => $uploadResult['secure_url'],
            'video_public_id' => $uploadResult['public_id'],
            'thumbnail_url' => $thumbnailUrl,
        ]);

        return redirect()->route('videos.index')
               ->with('success', 'Video uploaded successfully!');

    } catch (\Exception $e) {
        return back()->withInput()
               ->with('error', 'Error uploading video: '.$e->getMessage());
    }
}


    public function destroy(Video $video)
    {
        try {
            // First delete from Cloudinary
            $cloudinary = new \Cloudinary\Cloudinary([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => true
                ]
            ]);

            $result = $cloudinary->uploadApi()->destroy($video->video_public_id, [
                'resource_type' => 'video',
                'invalidate' => true // Optional: clears CDN cache
            ]);

            // Then delete from database
            $video->delete();

            return redirect()->route('videos.index')
                ->with('success', 'Video deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting video: ' . $e->getMessage());
        }
    }
}