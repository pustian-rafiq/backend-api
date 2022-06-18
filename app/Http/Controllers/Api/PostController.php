<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
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
    //  public function store(Request $request,$page_id=null){
    //     $validateData = $request->validate([
    //         'post_content' => "required|string",
    //     ]);

    //     $data = new Post();

    //     $data->post_content = $request->post_content;
    //     $data->user_id = Auth::id();
    //     if($page_id){
    //         $data->page_id = $page_id;
    //     }
       
    //     $data->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => "Post created successfully"
    //     ]);
    // }

     /**
      * Check validation for post request data of person
      * This method create a new post for logged in persons
      * Route: api/person/attach-post
     */
    public function PersonPostStore(Request $request){

        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

       

         $data = new Post();

        $data->post_content = $request->post_content;
        $data->person_id = Auth::id();
 
        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Post created successfully"
        ]);
       
    }

     /**
      * Check validation for post request data of page
      * This method create a new post from the page of the current logged in persons 
      * Route: api/page/attach-post
     */
    public function PagePostStore(Request $request,$page_id){

        $validateData = $request->validate([
            'post_content' => "required|string",
        ]);

        //Check authenticated user page exist or not
        $page = Page::where('person_id',AUth::id())->find($page_id);

        $data = new Post();

       
        if($page){
            $data->post_content = $request->post_content;
            $data->person_id = Auth::id();
            $data->page_id = $page_id;

            $data->save();

            return response()->json([
                'success' => true,
                'message' => "Post created successfully"
            ]);
        } else{
            return response()->json([
                'success' => false,
                'message' => "This page not exist. So can not create any post"
            ]); 
        }
    }



    /**
      * This method fetch all the posts for the logged in persons
      * Route: api/person/feed
     */
    public function getAllPost(){
        $posts = Post::where('person_id', Auth::id())
        ->where('page_id', null)
        ->select('post_content')->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]); 
    }
}