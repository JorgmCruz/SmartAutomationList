<?php

namespace App\Http\Controllers;

//import de models
use App\Models\User;
//import datatable
use App\DataTables\UserDataTable;
//outros imports
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth,Redirect;

class UserController extends Controller
{

    //index pra datatable
    public function index(UserDataTable $dataTable)
    {
        //caso o utilizador logado nao tenha permissioes éredirecionado para a pagina HOme
        if (Auth::user()->permission!=3)
        {
            return redirect('/');
        }

        return $dataTable->render('user.index');
    }

    //mostrar view para edit do user
    public function update()
    {
        return view('user.update');
    }

    //editar user
    public function edit($iduser, Request $request)
    {
        //procurar user
        $user=User::find($iduser);

        //binding parametros
        $user->name=request('name');
        $user->email=request('email');
        $user->zf_number=request('zf_number');

      if(!empty(request('password')))
      {
        if(request('password')===request('password_confirmation'))
        {
            $user->password=Hash::make(request('password'));

            //salvar
             $user->save();
             //redirecionar
            return redirect()->back()->with('message', 'User updated.');

 
        }
        else
        {
            return Redirect::back()->withErrors(['Password are not the same.', 'The Message']);
        }
      }

        //salvar
        $user->save();
      //redirecionar
      return redirect()->back()->with('message', 'User updated.');

    }
    
    //funcao para mosstrar o view mudarpassword
    public function updatePassword()
    {

        return view('user.resetpassword');
    }

    //edita password
    public function editpassword(Request $request )
    {
        //novo objeto user
        $user = new User();

        //procurar user pelo id 
        $user=User::findOrFail(request('id'));


        //se o campo password nao estiver nulo nem vazio -> entao utilizador quer mudar a apassword
        if(!empty(request('password')))
        {
                    //datetime atual
                     $date= Carbon::now();
            //se a password for igual á password confirmation 
            if(request('password')===request('password_confirmation'))
            {
                //fazer hash da nova password e atualizar a mesma
                $user->password=Hash::make(request('password'));
                $user->first_login=$date;
            }
            else
            {
                //caso passwords nao sejam iguais envia mensagem de erro.
                return redirect()->back()->withErrors(['Passwords need to be the same.', 'The Message']);
            }
    
        }

        //se a alteracao for concluida com sucesso manda mensaghem de sucesso
        if($user->save())
        {
               //redirecionar para tras
               return redirect()->back()->with('message', 'Password updated.');

        }
        else
        {
            return redirect()->back()->withErrors(['Error! Something is not right', 'The Message']);
        }


    }

    //funcoa para dar permissao aos users   
    public function givePermission($iduser)
    {
        //objeto user
        $user=User::findOrFail($iduser);

        //confirmar permissao
        if($user->permission==3)
        {
            //manda erro
            return Redirect::back()->withErrors(['This User has already permissions', 'The Message']);
        }
        else
        {
            //fdaz o update
            $user->permission=3;
            $user->save();

            return redirect('/user/all')->with('message', 'Permission Granted Successfully.');

        }

    }

      //funcoa para dar permissao aos users   
      public function removePermission($iduser)
      {
          //objeto user
          $user=User::findOrFail($iduser);
  
          //confirmar permissao
          if($user->permission!=3)
          {
              return Redirect::back()->withErrors(['This User doesnt have permissions', 'The Message']);
          }
          else
          {
            $user->permission=NULL;
            $user->save();
              return redirect('/user/all')->with('message', 'Permission Annulled Successfully.');
          }
  
      }


    
}
