<?php

namespace App\Http\Controllers;

//importar models
use App\Models\Acoes;
use App\Models\User;

//import mail
use App\Mail\IssueMail;
//importar datatables
use App\DataTables\MinhasAcoesDataTable;
use App\DataTables\AcoesDataTable;
//importar outros
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\PDF;
use Validator;
use View, Input, Redirect,Auth;

class AcoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($estado,AcoesDataTable $dataTable)
    {
            //detatar atraso

            //AcoesController::detectDelay();

            $deps=AcoesController::getDepartamento();

        $locals=AcoesController::getLocation();

            //inputs
            $inputs=AcoesController::getInput();

            //retorna o render e envia para o datatable.php as variaveis
            return $dataTable->with("estado", $estado)->with("deps", $deps)->with("inputs", $inputs)->with('locals', $locals)->render('acoes.index',['deps'=> $deps,'inputs'=>$inputs,'locals'=> $locals]);

    }

      /**
     * Mostra as minhas acoes
     *
     * @return \Illuminate\Http\Response
     */
    public function indexminhasacoes($estado,MinhasAcoesDataTable $dataTable)
    {

            //detatar atraso

            //AcoesController::detectDelay();

        return $dataTable->with('estado', $estado)->render('acoes.minhasacoes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //departamentos
        $deps=AcoesController::getDepartamento();

        //inputs
        $inputs=AcoesController::getInput();

        //localizacao
        $local=AcoesController::getLocation();

        //utilizadores
        $users=AcoesController::getUsers();



        return View::make("acoes.create")
        ->with('deps',$deps)
        ->with('inputs',$inputs)
        ->with('locals',$local)
        ->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'issueDescription' => 'bail|required',
            'correctiveMeasure' => 'required',
        ]);
        //novo objeto acoes
        $acoes= new Acoes();


        //formatar data ->enddate
        $data=date("Y-m-d H:i:s", strtotime(request("endDate")));


        //binding com a view
        $acoes->issueDescription=request('issueDescription');
        $acoes->correctiveMeasure=request('correctiveMeasure');
        $acoes->planDate=request('planDate');
        $acoes->endDate=$data;
        $acoes->name_input=request('input');
        $acoes->name_department=request('department');
        $acoes->number_priority=request('priority');
        $acoes->name_localization=request('location');
        $acoes->name_responsible=AcoesController::getName(request('responsible'));
        $acoes->number_responsible=request('responsible');
        $acoes->condition='Processing';
        $acoes->remarks=request('remarks');
        $acoes->createdby=Auth::user()->name;
        if($acoes->save()) {
            //obter  ultima adicao
            $acoes->latest()->first();

            //adicionar log->novos remarks
            AcoesController::addLog($acoes->idissue,request('remarks'),Auth::user()->name);
            //novo objeto de mail
            $mail= new IssueMail($acoes,AUTH::user()->name,'New Issue Created','New Issue');
            //enviar mail
            Mail::send($mail);

              //redirecionar para pagina especifica
         return redirect('/acoes/minhasacoes/Processing')->with('message', 'New Issue Added. 🎇🎇🎇');
        } else {
            return 0;
        }

      //  $acoes->

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acoes  $acoes
     * @return \Illuminate\Http\Response
     */
    public function show($idissue)
    {
        //mostrar issues em detalhe

        //procurar issue
        $aux=Acoes::findOrFail($idissue);

        //mostrar todos os remarks da issue
        $remarks=AcoesController::getRemarks($idissue);

        return View::make("acoes.issuedetails")
        ->with('issue',$aux)
        ->with('remarks',$remarks);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acoes  $acoes
     * @return \Illuminate\Http\Response
     */
    public function edit($idissue)
    {
        //procurar issue
        $aux=Acoes::findOrFail($idissue);

        //departamentos
        $deps=AcoesController::getDepartamento();

        //inputs
        $inputs=AcoesController::getInput();

        //localizacao
        $local=AcoesController::getLocation();

        //utilizadores
        $users=AcoesController::getUsers();

        return View::make("acoes.update")
        ->with('deps',$deps)
        ->with('inputs',$inputs)
        ->with('locals',$local)
        ->with('users',$users)
        ->with('issue',$aux);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acoes  $acoes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$idissue)
    {
        //objeto acoes
        $acao=Acoes::findOrFail($idissue);


        //caso haja request de startdate
        if(request('startDate')!=Null)
        {
            $acao->startDate=request('startDate');
        }

        if(!empty(request('planDateRemark')))
        {
            AcoesController::addLog($idissue,request('planDateRemark'),AUTH::user()->name);
        }

        if(!empty(request('endDateRemark')))
        {
            AcoesController::addLog($idissue,request('endDateRemark'),AUTH::user()->name);
        }

        //binding parametros
        $acao->issueDescription=request('issueDescription');
        $acao->correctiveMeasure=request('correctiveMeasure');
        $acao->planDate=request('planDate');
        $acao->endDate=request('endDate');
        $acao->name_input=request('input');
        $acao->name_department=request('department');
        $acao->number_priority=request('priority');
        $acao->name_localization=request('location');
        $acao->name_responsible=AcoesController::getName(request('responsible'));
        $acao->number_responsible=request('responsible');
        if($acao->save()) {

        //novo objeto de mail
        $mail= new IssueMail($acao,AUTH::user()->name,' Issue Updated','Issue Updated');
        //enviar mail
        Mail::send($mail);

            return redirect()->back()->with('message', 'Issue Updated.🎊🎊🎊');
        }else {
            return 0;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acoes  $acoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acoes $acoes)
    {
        //
    }

    //guarda a nova remark
    public function storeRemark(Request $request)
    {

        if(empty(request('remarks')))
        {
            return Redirect::back()->withErrors(['You need to write a remark', 'The Message']);
        }
        //adicionar log
        AcoesController::addLog(request('idissue'),request('remarks'),AUTH::user()->name);

        //obter issue
        $acao= Acoes::find(request('idissue'));

        //novo objeto de mail
        $mail= new IssueMail($acao,AUTH::user()->name,'New Remark added','New Remark Added');
        //enviar mail
        Mail::send($mail);

        //redirecionar para tras
        return redirect()->back()->with('message', 'New Remarked Added Sucessfully.');


    }

    //atualizar estado da issue para concluido (ou anular o mesmoi)
    public function changetoconcluded(Request $request)
    {
        //objeto acoes
        $acao = new Acoes();



        //obter estado da issue
        $estado = $acao->find(request('idissue'));

        if(empty(request('conc')))
        {
            return Redirect::back()->withErrors(['You need to write a remark', 'The Message']);
        }

        //decode json
        //$estado = json_decode($estado, true);
        //adicionar log
        AcoesController::addLog(request('idissue'),request('conc'),AUTH::user()->name, 2);



        //update
        $acao->where('idissue', request('idissue'))
        ->update(['condition' => 'Concluded']);

        $acao->save();

        //novo objeto de mail
        $mail= new IssueMail($estado,AUTH::user()->name,'Issue Concluded','Issue Concluded');
        //enviar mail
        Mail::send($mail);

        return redirect()->back()->with('message', 'Issue is Now Concluded 🎉🎉🎉');


    }

    //atualizar estado da issue para cancelado (ou anular o mesmoi)
    public function changetocancelled(Request $request)
    {
        //objeto acoes
        $acao = new Acoes();

        //obter estado da issue
        $estado = $acao->find(request('idissue'));

        //decode json
        //$estado = json_decode($estado, true);

        if(empty(request('canc')))
        {
            return Redirect::back()->withErrors(['You need to write a remark', 'The Message']);
        }

        $estado->condition=request('canc');
        AcoesController::addLog(request('idissue'),request('canc'),AUTH::user()->name,1);

        //fazer o update
        $acao->where('idissue', request('idissue'))
        ->update(['condition' => 'Cancelled']);
        $acao->save();

        //novo objeto de mail
        $mail= new IssueMail($estado,AUTH::user()->name,'Issue Cancelled','Issue Canceled');
        //enviar mail
        Mail::send($mail);

        return redirect()->back()->with('message', 'Issue is Now Cancelled 😪😪😪');


    }

            //guardar novos inputs
    public function storeInput(Request $request )
    {
        //obter request do input
        $input=request('input');


        //adicionar na bd
        DB::insert('INSERT INTO tbc_input VALUES(?)',[$input]);

        //redirecionar para tras com menmsagem de sucesso.
        return redirect()->back()->with('message', 'New Input Added Sucessfully 💪💪💪.');
    }

    //guardar novos dptos
    public function storeDpto(Request $request )
    {
        //obter request do dpto
        $dpto=request('dpto');


        //adicionar na bd
        DB::insert('INSERT INTO tbc_department VALUES(?)',[$dpto]);

        //redirecionar para tras com menmsagem de sucesso.
        return redirect()->back()->with('message', 'New Department Added Sucessfully 👌👌👌.');
    }

    //guardar novos Locations
    public function storeLocal(Request $request )
    {
        //obter request do local
        $local=request('local');


        //adicionar na bd
        DB::insert('INSERT INTO Linhas (nome_linha) VALUES(?)',[$local]);

        //redirecionar para tras com menmsagem de sucesso.
        return redirect()->back()->with('message', 'New Location Added Sucessfully 🙌🙌🙌.');
    }

    //reverter concluido
    public function revertConcluded($idissue)
    {

        //obter acao
        $issue=Acoes::findOrFail($idissue);

        if($issue->condition==='Concluded')
        {
            $issue->condition='Processing';

            $issue->save();


        //novo objeto de mail
        $mail= new IssueMail($issue,AUTH::user()->name,'Issue Back to Processing','Issue Back to Processing');
        //enviar mail
        Mail::send($mail);

            return redirect()->back()->with('message', 'Issue is now Processing.');

        }
        else
        {
            return Redirect::back()->withErrors(['Issue is already processing.', 'The Message']);
        }

    }

    //reverter cancelado
    public function revertCancelled($idissue)
    {

        //obter acao
        $issue=Acoes::findOrFail($idissue);

        if($issue->condition==='Cancelled')
        {
            $issue->condition='Processing';

            $issue->save();

         //novo objeto de mail
        $mail= new IssueMail($issue,AUTH::user()->name,'Issue Back to Processing','Issue Back to Processing');
        //enviar mail
        Mail::send($mail);

            return redirect()->back()->with('message', 'Issue is now Processing.');

        }
        else
        {
            return Redirect::back()->withErrors(['Issue is already processing.', 'The Message']);
        }

    }


    //----------------------------------------------outros----------------------------------------------------------------
    //obter todos os departamentos
    public static function getDepartamento()
    {
        $results= DB::connection('sqlsrv')
                ->table('tbc_department')
                ->orderBy('id_department')
                ->get();

        return $results;
    }

    //obter todos os inputs
    public static function getInput()
    {
        $results= DB::connection('sqlsrv')
                ->table('tbc_input')
                ->orderBy('id_input')
                ->get();

        return $results;
    }

    //funcao que deteta os nulos e retorna a query para acoes -datatable
    public static function detectNull($estado, $depto, $input, $location)
    {

        // var_dump($estado);
        // var_dump($depto);
        // var_dump($input);
        // exit;

        //objeto acoes
        $acao = Acoes::all();

      if ($estado != 'All'){
          $acao=$acao->whereIn('condition',['',$estado])->where('name_department','!=',null);
        }else{
          $acao=$acao->where('name_department','!=',null);
      }

        if(!empty($depto)){
            $acao=$acao->where('name_department','=',$depto);
        }
        if(!empty($input)){
            $acao=$acao->where('name_input','=',$input);
        }
        if(!empty($location)){
            $acao=$acao->where('name_localization','=',$location);
        }

        $acao= $acao->sortByDesc('priorityissue')->sortByDesc('startDate');

        return $acao;

    }

    //funcao que deteta todas as issues que estao atrasadas e muda o seu estado para delay
    public static function detectDelay()
    {
        //definir local
        setlocale(LC_TIME, 'PT_pt');

        //objeto acoes
        $acao = new Acoes();

        //caso a data
        $acao=$acao->where('condition','=', 'Processing')->whereRaw('GetDate() > endDate')
        ->update(['priorityissue' => 4 , 'condition'=>'Delay']);
        $acao->save();

    }

    //obter localizacao do projeto
    public static function getLocation()
    {
        $results= DB::connection('sqlsrv')
                ->table('Linhas')
                ->orderBy('id_linhas')
                ->get();

        return $results;
    }

    //obter Utilizadores
    public static function getUsers()
    {
        $results= DB::connection('sqlsrv2')
                ->table('G_Users')
                ->orderBy('Number')
                ->get();

        return $results;
    }

    //obter Utilizadores(nome) atraves do numero zf
    public static function getName($numeroZF)
    {
        //
        $results= DB::connection('sqlsrv2')
                ->table('G_Users')
                ->select('Name')
                ->where('Number', '=', $numeroZF)
                ->get();


        $results=json_decode($results,true);

        return $results[0]['Name'];
    }

    //obter mail atraves de numero
    public static function getMail($numeroZF)
    {
        //objeto user
        $user= new User();
        //obter mail do utilizador a enviar
       $aux= $user->select('email')->where('zf_number',$numeroZF)->get();


        return $aux;
    }


    //adicionar log de remarks
    public static function addLog($idissue,$remarks,$nome,$final=Null)
    {
        $results= DB::connection('sqlsrv')
        ->table('changelog')
        ->insert([
            ['idissue' => $idissue, 'remarks' => $remarks,'nome'=>$nome, 'final'=>$final]
        ]);
    }

    //obter todas as remarks de uma issue
    public static function getRemarks($idIssue)
    {
        $results= DB::connection('sqlsrv')
                ->table('changelog')
                ->where('idissue','=',$idIssue)
                ->orderBy('created_at','desc')
                ->get();

        return $results;
    }

    //funcao corre sempre que ha login de forma a atualizar a tabela NOTA: Após o uso desta plataforma ser generalizado este método pode ser apagado
    public static function givePriority()
    {

        //objeto acoes
        $acao= new Acoes();

        //buscar os novos issues(os que tem a coluna priorityissue null)
        $auxs=$acao->whereNull('tb_issues.priorityissue')->get();

        //para cada
        foreach($auxs as $aux)
        if($aux->number_priority='High')
        {

            $aux->where('idissue', $aux->idissue)
            ->update(['tb_issues.priorityissue' => 3]);
            $acao->save();
        }
        else if($aux->number_priority='Medium')
        {
            $aux->where('idissue', $aux->idissue)
            ->update(['tb_issues.priorityissue' => 2]);
            $acao->save();
        }
        else if($aux->number_priority='Low')
        {
            $aux->where('idissue', $aux->idissue)
            ->update(['tb_issues.priorityissue' => 1]);
            $acao->save();
        }else
        {
            $aux->where('idissue', $aux->idissue)
            ->update(['tb_issues.priorityissue' => 0]);
            $acao->save();
        }



    }


}
