<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Models\Image;

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
        }
        
        $image->image_path = $image_path_name;

        $image->save();

        return redirect()->route('home')
                         ->with(["message" => "La foto se subio correctamente"]);

    }
}
