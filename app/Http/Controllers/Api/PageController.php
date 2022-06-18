<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PagePerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

     /**
      * Check validation for page request data
      * This method create a new page for logged in persons
      * Route: api/page/create
     */

    public function store(Request $request){
        $validateData = $request->validate([
            'page_name' => "required|string",
        ]);

        $data = new Page();

        $data->page_name = $request->page_name;
        $data->person_id = Auth::id();

        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Page created successfully"
        ]);
    }


     /**
    * Currently logged in person follow a page
    * If the following page id exists in the database, we unfollow the page and delete it
    * If the following page id not exists in the database, follow that page
    * Route: api/follow/page/following_page_id
    */

    public function StoreFollowingPage($page_id){

        $data = new PagePerson();

        $data->person_id = Auth::id();
        $data->page_id = $page_id;

        $data->save();

        return response()->json([
            'success' => true,
            'message' => "You are following this page"
        ]);
    }
}