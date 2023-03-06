<?php

namespace App\Http\Controllers;

//importar models
use App\Models\Acoes;
//imoportar outros controllers
use App\Http\Controllers\AcoesController;
use App\Http\Controllers\ChartsController;
//outros controllers
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Auth,Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //se nao tiver logado ainda na nova plataforma , tera de mudar a palavra passe opara uma á sua escolha
        if(Auth::user()->first_login  == NULL)
        {
            return redirect('/user/changepassword');
        }

        //dar prioridade
        AcoesController::givePriority();

        //chart->obter as concluidas
        $conc=ChartsController::getConcluded();

        //chart->obter as processing
        $proc=ChartsController::getProcessing();

        //chart->obter as processing
        $delay=ChartsController::getDelay();


        return view('home')
        ->with('conc',$conc)
        ->with('proc',$proc)
        ->with('delay',$delay);
    }
}
