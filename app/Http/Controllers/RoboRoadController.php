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
        //$NodeIds = RoboRoadNodes::pluck('NodeId');
        $nodes = RoboRoadNodes::select('NodeId', 'NodeName')->get();

        return view('Index', compact('nodes'));
    }

    public function getStreamPreviewPage($nodeId) {
        $doesNodeExists = (bool)RoboRoadNodes::where('NodeId', $nodeId)->value('NodeId');

        if ( !$doesNodeExists  ) { return redirect(route('nodes.index')); }

        $nodeAddress = RoboRoadNodes::where('NodeId', $nodeId)->value('NodeAddress');
        $streamUrl = 'http://' . $nodeAddress  . '/video_feed';

        return view('VideoStream', compact('nodeId', 'streamUrl'));
    }

    public function getNodeStatusPage($nodeId) {
        $nodeName = RoboRoadNodes::where('NodeId', $nodeId)->value('NodeName');

        return view('SystemInfoPage', compact('nodeId', 'nodeName') );
    }
    
    public function getCreateNodePage(){
        return view('NodeCreation');
    }

    public function getConfirmationDeletionPage($nodeId)
    {
        $node = RoboRoadNodes::find($nodeId);

        return view('ConfirmationDeletion', compact('node'));
    }
    
    public function getEditNodePage($nodeId)
    {
        $node = RoboRoadNodes::find($nodeId);

        return view('Edit', compact('node'));
    }
    #-------- API calls --------   

    public function getProxiedStream($nodeId)
    {
        $nodeAddress = RoboRoadNodes::where('NodeId', $nodeId)->value('NodeAddress');
        
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
        $nodeAddress = RoboRoadNodes::where('NodeId', $nodeId)->value('NodeAddress');
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

    public function deleteNode($nodeId)
    {
        $node = RoboRoadNodes::find($nodeId);

        $node->delete();

        return redirect()->route('nodes.index')->with('success', 'node deleted successfully');
    }

    public function updateNode(Request $request, $nodeId)
    {
        $node = RoboRoadNodes::find($nodeId);
        $node['NodeName'] = $request['NodeName'];
        $node['NodeAddress'] = $request['NodeAddress'];
        $node->save();

        return redirect()->route('nodes.index')->with('success', 'Item updated successfully');
    }
}
