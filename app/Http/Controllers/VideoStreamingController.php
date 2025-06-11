<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

class VideoStreamingController extends Controller
{
    public function ViewStream() {
        return view('VideoStream');
    }

    public function ProxiedVideoStream()
    {
        $streamUrl = 'http://192.168.1.13:5000/video_feed';

        $response = Http::withOptions([
            'stream' => true,
        ])->get($streamUrl);

        return response()->stream(function () use ($response) {
            $body = $response->getBody();

            while (!$body->eof()) {
                echo $body->read(1024); // Read in chunks
                ob_flush();
                flush();
            }
        }, 200, [
            //'Content-Type' => 'multipart/x-mixed-replace; boundary=--boundarydonotcross',
            'Content-Type' => 'multipart/x-mixed-replace; boundary=frame',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}
