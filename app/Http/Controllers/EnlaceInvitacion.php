<?php

namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Participantes;
use App\Models\Portales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class EnlaceInvitacion extends Controller
{


     public function crearEnlace(){
        //creamos un nuevo token para el portal y lo devolvemos
        $portal=Portales::find(Session::get('portal')->id);
        $portal->token_portal=Str::random(20);
        $portal->save();
        Session::put('portal',$portal);
        return response()->json($portal->token_portal);
     }

     public function redirigir($dir){
        //recibe el token y busca un portal con ese token
        // Si existe reenvia al portal, sino error
        $token=Portales::where('token_portal',$dir)->first();
        if($token){
            Session::put('portal',$token);
            if(Participantes::where('id_portal',$token->id)->where('id_usuario',Auth::id())->first())
                return redirect()->to('/portal');
            Session::put('invitacion',true);
            return redirect()->to('/portal');
        }
        return redirect()->route('error404');
     }
     public function aniadirParticipante(){
        //añade el usuario al participante y lo añade al chat grupal
        $nombrePart = str_replace("-", " ",request("par"));
        $participante = Participantes::where('id_portal',Session::get('portal')->id)->where('nombre_en_portal',$nombrePart)->first();
        if($participante){
            $participante->id_usuario = Auth::id();
        }else{
            $participante = new Participantes();
            $participante->id_usuario = Auth::id();
            $participante->id_portal = Session::get('portal')->id;
            $participante->nombre_en_portal = $nombrePart;
        }
        $participante->save();
        $conversacion=Conversacion::where('id_portal',Session::get('portal')->id)->where('chat_global',true)->first();
        
        $array=json_decode($conversacion->participantes_group);
        $array[]=$participante->nombre_en_portal;
        $conversacion->participantes_group=json_encode($array);
        $conversacion->save();
        Session::forget('invitacion');
        Session::put('participanteUser',Participantes::where('id_usuario',Auth::user()->id)->where('id_portal',Session::get('portal')->id)->first());
        return redirect()->to('/portal');
        
     }
}
