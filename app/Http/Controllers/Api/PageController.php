<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

     /**
      * Check validation for page request data
      * This method create a new page for logged in users
      * Route: api/page/create
     */

    public function store(Request $request){
        $validateData = $request->validate([
            'page_name' => "required|string|unique:pages,page_name",
        ]);

        $data = new Page();

        $data->page_name = $request->page_name;
        $data->user_id = Auth::id();

        $data->save();

        return response()->json([
            'success' => true,
            'message' => "Page created successfully"
        ]);
    }
}