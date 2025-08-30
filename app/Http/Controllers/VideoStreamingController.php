<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\RoboRoadNodes;

class VideoStreamingController extends Controller
{
    public function Index() {
        //$NodeIds = RoboRoadNodes::pluck('NodeID');
        $Nodes=RoboRoadNodes::select('NodeId', 'NodeName')->get();
        return view('Index', compact('Nodes'));
    }

    public function ViewStream($id) {
        $checkNodeIdExist=(bool)RoboRoadNodes::where('NodeId', $id)->value('NodeId');
        if ( !$checkNodeIdExist ) { return redirect('/'); }
        return view('VideoStream', compact('id'));
    }

    public function ProxiedVideoStream($id)
    {
        $NodeAddress=RoboRoadNodes::where('NodeId', $id)->value('NodeAddress');
        
        $streamUrl='http://' . $NodeAddress . '/video_feed';

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
