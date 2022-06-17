<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
     /**
      * Check validation for post request data
      * This method create a new post for logged in persons
      * Route: api/person/attach-post
     */
     public function store(Request $request,$page_id=null){
        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

        $data = new Post();

        $data->post_content = $request->post_content;
        $data->user_id = Auth::id();
        if($page_id){
            $data->page_id = $page_id;
        }
       
        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Post created successfully"
        ]);
    }
}