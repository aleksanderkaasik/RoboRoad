<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\RoboRoadNodes;

class RoboRoadController extends Controller
{

    #-------- Web pages --------

    public function Index() {
        //$NodeIds = RoboRoadNodes::pluck('NodeID');
        $Nodes=RoboRoadNodes::select('NodeID', 'NodeName')->get();
        return view('Index', compact('Nodes'));
    }

    public function Info($id) {
        $nodeName = RoboRoadNodes::where('NodeID', $id)->value('NodeName');
        return view('SystemInfoPage', compact('id', 'nodeName') );
    }

    public function ViewStream($id) {
        $checkNodeIdExist=(bool)RoboRoadNodes::where('NodeID', $id)->value('NodeID');
        if ( !$checkNodeIdExist ) { return redirect(route('nodes.menu')); }
        $NodeAddress=RoboRoadNodes::where('NodeID', $id)->value('NodeAddress');
        $streamUrl='http://' . $NodeAddress . '/video_feed';
        return view('VideoStream', compact('id', 'streamUrl'));
    }

    #-------- API calls --------   

    public function ProxiedVideoStream($id)
    {
        $NodeAddress=RoboRoadNodes::where('NodeID', $id)->value('NodeAddress');
        
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

    public function SystemInfo($id)
    {
        $nodeAddress = RoboRoadNodes::where('NodeID', $id)->value('NodeAddress');
        $response = Http::get("http://$nodeAddress/system_info");
        return $response->json();
    }
}
