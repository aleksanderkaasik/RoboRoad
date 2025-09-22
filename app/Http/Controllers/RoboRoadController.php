<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\RoboRoadNodes;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class RoboRoadController extends Controller
{

    #-------- Web pages --------

    public function Index() {
        //$NodeIds = RoboRoadNodes::pluck('NodeId');
        //$nodes = RoboRoadNodes::select('NodeId', 'NodeName')->get();
        //return view('Index', compact('nodes'));
        return view('Index');
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
        try {
            $nodeAddress = RoboRoadNodes::where('NodeId', $nodeId)->value('NodeAddress');
        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Server error while creatomg node, having database connection issue',
                'error'   => $error->getMessage()
            ], 500);
        }

        try {
            $response = Http::timeout(5)->get("http://$nodeAddress/system_info");
    
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'error' => "Failed to retrieve system info from $nodeAddress.", 
                ],502);
            }
    
            return response()->json($response->json(), 200);
    
        } catch (\Exception $e) {
            // Handle connection errors, timeouts, etc.
            return response()->json([
                'success' => false,
                'error' => "Exception occurred while connecting to node: " . $e->getMessage()
            ], 500); // Internal Server Error
        }
    }

    public function createNode(Request $request)
    {
        if ( empty($request['NodeName']) or empty($request['NodeAddress']) ) {
            return response()->json([
                'success' => false,
                'message' => 'Missing values',
            ], 404);
        }
        try {
            $node  = RoboRoadNodes::create([
                'NodeName'=> $request['NodeName'],
                'NodeAddress'=> $request['NodeAddress']
            ]);
        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Server error while creatomg node, having database connection issue',
                'error'   => $error->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'node'    => $node ,
            'message' => 'node created successfully',
            
        ], 201);
    }

    public function deleteNode($nodeId)
    {
        try {
            $node = RoboRoadNodes::find($nodeId);
        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Server error while getting node or having database connection issue',
                'error'   => $error->getMessage()
            ], 500);
        }

        if (!$node) {
            return response()->json([
                'success' => false,
                'message' => 'Couldn\'t find nodd to delete',
            ], 404);
        }

        $node->delete();

        return response()->json([
            'success' => true,
            'message' => 'node deleted successfully',
            
        ], 200);

        //return redirect()->route('nodes.index')->with('success', 'node deleted successfully');
    }

    public function updateNode(Request $request, $nodeId)
    {
        try {
            $node = RoboRoadNodes::find($nodeId);
        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Server error while getting node or having database connection issue',
                'error'   => $error->getMessage()
            ], 500);
        }
       
        if (!$node) {
            return response()->json([
                'success' => false,
                'message' => 'Couldn\'t find nodd to update',
            ], 404);
        }

        if ( empty($request['NodeName']) && empty($request['NodeAddress']) ){
            return response()->json([
                'success' => true,
                'message' => 'No values were added',
                
            ], status: 400  );
        }
        
        if ( !empty($request['NodeName']) ) {
            $node['NodeName'] = $request['NodeName'];
        }

        if ( !empty($request['NodeAddress']) ) {
            $node['NodeAddress'] = $request['NodeAddress'];
        }

        $node->save();

        return response()->json([
            'success' => true,
            'message' => 'node update successfully',
            
        ], 200);

        //return redirect()->route('nodes.index')->with('success', 'Item updated successfully');
    }

    public function getNode(){
        try {
            $nodes = RoboRoadNodes::select('NodeId', 'NodeName', 'NodeAddress')->get();
        } catch (\Throwable $error) {
            return response()->json([
                'success' => false,
                'message' => 'Server error while getting node or having database connection issue',
                'error'   => $error->getMessage()
            ], 500);
        }

        if (!$nodes) {
            return response()->json([
                'success' => false,
                'message' => 'Couldn\'t find nodd to update',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'nodes'    => $nodes ,
            'message' => 'node created successfully',

        ], 201);
    }
}
