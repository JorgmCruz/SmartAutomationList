<?php

namespace App\Http\Controllers;

//imports de models
use App\Models\Acoes;
//imports de controllers
use App\Http\Controllers\AcoesController;
//outros impoorts
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use View, Input, Redirect,Auth;

class ChartsController extends Controller
{
    
    //obter todas as condicoes concludisa
    public static function getConcluded()
    {
        //obter utilizador logado
        $user= AUTH::user();

        //objeto acao
        $acao= new Acoes();



        //obter todos as issues do utilizador que estao concluidas
        $aux= $acao->where('condition','Concluded')->where('number_responsible',$user->zf_number)->count();

        return $aux;

    }

        
    //obter todas as condicoes em processamento
    public static function getProcessing()
    {
        //obter utilizador logado
        $user= AUTH::user();
        
        //data de hoje
        $data=Carbon::now();

        //objeto acao
        $acao= new Acoes();

        //obter todos as issues do utilizador que estao concluidas
        $aux= $acao->where('number_responsible','=',$user->zf_number)
        ->where(function ($query) {
             $query->where('condition','=','Processing')
             ->orWhere('condition','=','');
        })
        ->Where('endDate', '>' ,Carbon::now())
        ->count();

        return $aux;

    }

    //obter todas as condicoes em delay
    public static function getDelay()
    {
        //obter utilizador logado
        $user= AUTH::user();


        //objeto acao
        $acao= new Acoes();

        //obter todos as issues do utilizador que estao concluidas
        $aux= $acao ->where('number_responsible',$user->zf_number)
                    ->where(function ($query) {
                        $query->where('condition','=','Processing')
                        ->orWhere('condition','=','');
        })
        ->Where('endDate', '<' ,Carbon::now())
        ->count();

        return $aux;

    }



}
