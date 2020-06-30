<?php

namespace App\Utils;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class Helper extends Controller
{


    static function getUsuarioAuthTipo(){
        $userAuth = Auth::user();
        $result = User::with('roles')->where('id', $userAuth->id)->get();
        return $result[0]['roles'][0]['name'];
    }

    static function getUsuarioAuthParent(){
        $userAuth = Auth::user();
        $result = User::where('user_parent_id', $userAuth->id)->pluck('id');
        return $result;

    }

    static function getUsuarioAuthId(){
        $userAuth = Auth::user();
        return $userAuth->id;
    }


    static function retornaQuantidadeDias($mes, $ano){

        $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // 31
        return $dias;
    }

    static function dividirDiasPorPorcentagem($quantidadeDiasMes, $porcentagem, $diasRestantes){
        $result = $porcentagem/$quantidadeDiasMes;
        $diasCorreto = $quantidadeDiasMes - $diasRestantes;
        return $result *  $diasCorreto;
    }

    static function diasParaCalcular($quantidadeDiasMes, $diasRestantes){

        $diasCorreto = $quantidadeDiasMes - $diasRestantes;
        return   $diasCorreto;
    }

    static function calcularValorPorcentagem($valor, $porcentagem){
       return  (($valor * $porcentagem) / 100);
    }
}
