<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request) {

        // validar formulario
        $validate = $this->validate($request, [
            "image_id" => ['integer', 'required'],
            "content" => ['string', 'required']
        ]);

        // caputar los datos del formulario
        $user = Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // asigno los valores al objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id  = $image_id;
        $comment->content = $content;

        // guardar en la db
        $comment->save();

        // redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with(['message' => 'Comentario agregado correctamente']);


    }

    public function delete($id){

        // conseguir los datos del usuario logeado
        $user = Auth::user();

        // sacar el objeto del comentario
        $comment = Comment::find($id);;

        // comprobar si soy el dueño del comentario o de la publicacion
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();

			return redirect()->route('image.detail', ['id' => $comment->image->id])
						 ->with([
							'message' => 'Comentario eliminado correctamente!!'
						 ]);
        } else {
			return redirect()->route('image.detail', ['id' => $comment->image->id])
						 ->with([
							'message' => 'EL COMENTARIO NO SE HA ELIMINADO!!'
						 ]);
        }

    }
}
