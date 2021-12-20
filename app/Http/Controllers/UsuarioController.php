<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Usuario;
Use Log;

class UsuarioController extends Controller
{

    protected $errors = [];

    public function getAll(){
      $data = Usuario::get();
      return response()->json($data, 200);
    }


    function validation($cedula,$correo,$validar_cedula = true,$validar_correo = true){
        if($validar_cedula && Usuario::where('cedula',$cedula)->first())$this->errors[] = "La cèdula: $cedula ya se encuentra registrada";        

        if($validar_correo && Usuario::where('correo',$correo)->first())$this->errors[] = "El correo: $correo ya se encuentra registrado";       

    }

    public function create(Request $request){

      $message = "Error al registrar el Usuario";
      $data['cedula'] = $request['cedula'];
      $data['correo'] = $request['correo'];
      $data['nombres'] = $request['nombres'];
      $data['apellidos'] = $request['apellidos'];     
      $data['telefono'] = $request['telefono'];

      $this->validation($data['cedula'],$data['correo']);


      if(sizeof($this->errors) < 1){
        Usuario::create($data);
        $message = "Usuario registrado.";
      }
      return response()->json([
          'message' => $message,
          'errors' => $this->errors      
      ], 200);
    }


    public function get($id){
      $data = Usuario::find($id);
      return response()->json($data, 200);
    }


    public function delete($id){
      $res = Usuario::find($id)->delete();
      return response()->json([
          'message' => "Usuario Eliminado.",
          'success' => true
      ], 200);
    }

    public function update(Request $request,$id){
      $message = "Error al actualizar el Usuario";

      $data['nombres'] = $request['nombres'];
      $data['apellidos'] = $request['apellidos'];
      $data['cedula'] = $request['cedula'];
      $data['correo'] = $request['correo'];
      $data['telefono'] = $request['telefono'];


      $usuario = Usuario::find($id);
      if($data['cedula'] != $usuario->cedula)$this->validation($data['cedula'],$data['correo'],true,false);
      if($data['correo'] != $usuario->correo)$this->validation($data['cedula'],$data['correo'],false,true);  

      if(sizeof($this->errors) < 1){
        $usuario->update($data);
        $message = "Usuario actualizado.";
      }
      
      return response()->json([
          'message' => $message,
          'errors' => $this->errors,
          'u' => $usuario      
      ], 200);
    }
}
