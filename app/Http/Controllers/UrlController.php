<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = Url::select('id', 'original_url', 'shortened_url', 'click_count')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return $this->response(true, 'Urls list!', 200, $urls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid information!', 400, $validator->errors());
        }

        // Generate a unique short URL
        $shortenedUrl = $this->generateUniqueShortUrl();

        $url = Url::create([
            'original_url' => $request->input('url'),
            'shortened_url' => $shortenedUrl,
            'user_id' => Auth::id()
        ]);

        return $this->response(true, 'Created successfully.', 200, $url);
    }

    /**
     * Redirect users according to their provided shortened url
     */
    public function redirect($shortened_url)
    {
        $url = Url::where('shortened_url', $shortened_url)->firstOrFail();
        $url->click_count += 1;
        $url->save();
        return redirect($url->original_url);
    }

    /**
     * Generate unique dynamic length of string. Future move it to a helper function for reuse it.
     */
    private function generateUniqueShortUrl($length = 6)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortUrl = '';

        do {
            // Generate a random string of the specified length
            $shortUrl = substr(str_shuffle($characters), 0, $length);

            // Check if the generated short URL already exists in the database
        } while (Url::where('shortened_url', $shortUrl)->exists());

        return $shortUrl;
    }
}
