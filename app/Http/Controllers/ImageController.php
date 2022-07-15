<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;

class ImageController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){

        return view('image.create');

    }

    public function save(Request $request) {

        // validacion
        $validate = $this->validate($request, [
            
            "description" => ['required'],
            "image" => ['required', 'image']

        ]);

        // capturamos los datos
        $image_subir = $request->file('image');
        $description = $request->input('description');

        // asignamos los valores al objeto
        $user = Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        // subir la imagen
        if($image_subir) {
            $image_path_name = time().$image_subir->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_subir));
            $image->image_path = $image_path_name;
        }
        

        $image->save();

        return redirect()->route('home')
                         ->with(["message" => "La foto se subio correctamente"]);

    }

    public function getImage($filename){

        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);

    }

    public function detail($id) {

        $image = Image::find($id);

        return view('image.detail', [
            "image" => $image
        ]);

    }

    public function delete($id) {

        $user = Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id) {

            // eliminar los comentarios
            if($comments && count($comments) >= 1) {
                foreach($comments as $comment) {
                    $comment->delete();
                }
            }

            // eliminar los likes
            if($likes && count($likes) >= 1) {
                foreach($likes as $like) {
                    $like->delete();
                }
            }

            // eliminar ficheros
            Storage::disk('images')->delete($image->image_path);

            // eliminar registro imagen
            $image->delete();

            $message = ["message" => "La imagen se borro correctamente"];

        } else {
            $message = ["message" => "La imagen no se ha borrado"];
        }

        return redirect()->route('home')->with($message);

    }

    public function edit($id) {

        $user = Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id) {

            return view('image.edit', [
                "image" => $image
            ]);

        } else {
            return redirect()->route('home');
        }

    }

    public function update(Request $request){
        
        $validate = $this->validate($request, [     
            "description" => ['required'],
            "image" => ['image']
        ]);

        // capurar los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image');
        $description = $request->input('description');

        // conseguir el objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        // subir la imagen
        if($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        // actualizar registro
        $image->update();

        return redirect()->route('image.detail', ["id" => $image_id])
                         ->with(['message' => 'Imagen actualizada Correctamente']);
    }
}
