<?php

namespace App\Utils;

use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\FinanceiroConta;
use App\Http\Controllers\Controller;
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

    static function getUsuarioParent($id){
        return  User::where('user_parent_id',$id)->pluck('id');;
    }

    static function getUsuarioParentClientes($id){
        return  User::where(['user_parent_id' => $id, 'role_id' => 6])->pluck('id');
    }

    static function getUsuarioParentAnalistas($id){
        $result = User::where('user_parent_id',$id)->pluck('id');
        return User::whereIn('user_parent_id',$result)->pluck('id');
    }

    static function getUsuarioAuthId(){
        $userAuth = Auth::user();
        return $userAuth->id;
    }

    static function retornaQuantidadeDias($mes, $ano){

        $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!


        return $ultimo_dia;
    }

    static function dividirDiasPorPorcentagem($quantidadeDiasMes, $porcentagem, $diasRestantes){
        $result = $porcentagem/$quantidadeDiasMes;
        $diasCorreto=0;
        if($diasRestantes != 01){
            $diasCorreto = $quantidadeDiasMes - $diasRestantes;
        }else{
            $diasCorreto = $quantidadeDiasMes;
        }
        $i =  $result *  $diasCorreto;
        return  $i;
    }

    static function diasParaCalcular($quantidadeDiasMes, $diasRestantes){
        if($diasRestantes == 01){
            return  $quantidadeDiasMes;
        }
        $diasCorreto = $quantidadeDiasMes - $diasRestantes;
        return   $diasCorreto;
    }

    static function calcularValorPorcentagem($valor, $porcentagem){
       return  (($valor * $porcentagem) / 100);
    }

    static function montaArrayMeses(){
        $arr_meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );
        return $arr_meses;
    }

    static function retornaIntervaloDatas($mes){
        $ano = '2021';//date('Y');
        $finalMes = Helper::retornaQuantidadeDias($mes,$ano);
        $inicio = date($ano.'-'.$mes.'-01');
        $fim = date($ano.'-'.$mes.'-'.$finalMes);
        return[$inicio,$fim];
    }

    static function retornarTipoID($tipoRegistro){
        switch ($tipoRegistro) {
            case 1:
                return 'relatorio_id';
                break;
            case 2:
                return 'contrato_id';
                break;
            case 3:
                return 'fornecedor_id';
                break;
            case 4:
                return 'meta_cliente_id';
                break;
            case 5:
                return 'banca_id';
                break;
        }
    }

    public function registroContas($obj) {
        $new = $obj;
        $new[$this->retornarTipoID($obj['tipo_registro'])] = $obj['id'];
        unset($new['id']);

        return FinanceiroConta::create($new);
    }
}
