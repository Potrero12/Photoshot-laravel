<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function config(){

        return view('user.config');

    }

    public function update(Request $request){

        
        // conseguir al usuario identificado
        $user = Auth::user(); 
        // $id = Auth::user()->id;
        $id = $user->id;
        
        // validar el formulario
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            // validacion para que no se repida un valor
            'nick' => ['required', 'string', 'max:255', Rule::unique('users','nick')->ignore($id, 'id')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id, 'id')],
        ]);
        
        // capturamos los valores del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        // setear lo valores del formulario al objeto de usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        
        // subir la imagen
        $image_path = $request->file('image_path');
        if($image_path) {
            // ponerle nombre unico a la imagen
            $image_path_name = time().$image_path->getClientOriginalName();

            // guardarla en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // asignar la imagen al campo
            $user->image = $image_path_name;
        }
        
        // actualizar el usuario - visual studio si no lo reconoce pero si funciona
        $user->update();

        return redirect()->route('configuracion')
                         ->with(['message' => 'Usuario Actualizado Correctamente']);


    }

    public function getImage($filename) {

        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);

    }

}
