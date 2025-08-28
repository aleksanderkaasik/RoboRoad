<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

class VideoStreamingController extends Controller
{
    public function ViewStream($id) {

        $TestList = [1, 2];

        if (in_array($id, $TestList)){
            return view('VideoStream' , compact('id'));
        }
        return redirect('/');
    }

    public function ProxiedVideoStream($id)
    {
        switch ($id) {
            case '1':
                $streamUrl= 'http://pi0.camera.loc:5000/video_feed';
                break;
            case '2':
                $streamUrl='http://pi1.camera.loc:5000/video_feed';
            default:
                break;
        }

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
