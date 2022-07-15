<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index() {
        
        $user = Auth::user();
        $likes = Like::where('user_id', $user->id)
                     ->orderBy('id', 'desc')
                     ->paginate(5);
    
        return view('like.likes', [
            "likes" => $likes
        ]);
    
    }

    public function like($image_id) {
        
        // recoger el datos del usuario y la imagen
        $user = Auth::user();

        // condicion para saber si exist el like y no duplicarlo
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->count();

        if($isset_like == 0){
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;
    
            // guardar el la db
            $like->save();

            return response()->json([
                "like" => $like
            ]);
        } else {
            return response()->json([
                "message" => "Ya le diste like a la publicacion"
            ]);
        }

    }

    public function dislike($image_id) {

        // recoger el datos del usuario y la imagen
        $user = Auth::user();

        // condicion para saber si exist el like y no duplicarlo
        $like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)
                            ->first();

        if($like){

            // guardar el la db
            $like->delete();

            return response()->json([
                "like" => $like,
                "message" => 'Haz dado dislike'
            ]);
        } else {
            return response()->json([
                "message" => "No hay like"
            ]);
        }

    }


}
