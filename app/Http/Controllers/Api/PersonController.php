<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{

    /**
    * Currently logged in person follow another person
    * If the following person id exists in the database, we unfollow the person and delete it
    * If the following person id not exists in the database, follow that person
    * Route: api/follow/person/following_person_id
    */
    public function StoreFollowingPerson($following_id){

        $following_user = FollowPerson::where('person_id',AUth::id())->find($following_id);

        if($following_user){
            $following_user->delete();

            $data = new FollowPerson();

            $data->person_id = Auth::id();
            $data->following_id = $following_id;
        
            $data->save();
        
            return response()->json([
                'success' => true,
                'message' => "You are following this person"
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => "This person doesn't exist"
            ]);
        }
   
}
}