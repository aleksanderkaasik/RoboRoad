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
        $nodes = RoboRoadNodes::select('NodeID', 'NodeName')->get();

        return view('Index', compact('nodes'));
    }

    public function getStreamPreviewPage($nodeId) {
        $doesNodeExists = (bool)RoboRoadNodes::where('NodeID', $nodeId)->value('NodeID');

        if ( !$doesNodeExists  ) { return redirect(route('nodes.index')); }

        $nodeAddress = RoboRoadNodes::where('NodeID', $nodeId)->value('NodeAddress');
        $streamUrl = 'http://' . $nodeAddress  . '/video_feed';

        return view('VideoStream', compact('nodeId', 'streamUrl'));
    }

    public function getNodeStatusPage($nodeId) {
        $nodeName = RoboRoadNodes::where('NodeID', $nodeId)->value('NodeName');

        return view('SystemInfoPage', compact('nodeId', 'nodeName') );
    }
    
    public function getCreateNodePage(){
        return view('NodeCreation');
    }

    #-------- API calls --------   

    public function getProxiedStream($nodeId)
    {
        $nodeAddress = RoboRoadNodes::where('NodeID', $nodeId)->value('NodeAddress');
        
        $streamUrl = 'http://' . $nodeAddress . '/video_feed';

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

    public function getNodeSystemInfo($nodeId)
    {
        $nodeAddress = RoboRoadNodes::where('NodeID', $nodeId)->value('NodeAddress');
        $response = Http::get("http://$nodeAddress/system_info");
        return $response->json();
    }

    public function createNode(Request $request)
    {
        $node  = RoboRoadNodes::create([
            'NodeName'=> $request['NodeName'],
            'NodeAddress'=> $request['NodeAddress']
        ]);

        return response()->json([
            'success' => true,
            'node'    => $node ,
            'message' => 'node created successfully',
            
        ], 201);
    }
    
}
