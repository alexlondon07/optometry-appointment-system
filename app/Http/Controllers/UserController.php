<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Attachment;
use View;
use Redirect;
use Auth;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $items = User::paginate();
      //dd($items);
      $items->setPath('user');
      return View::make('admin.user.view_user', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $user = new User;
      $show = false;
      return View::make('admin.user.new_edit_user', compact('user', 'show'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(CreateUserRequest $request)
     {
         $user = User::create($request->all());
         //Ingresamos la imagen relacionada
         if (\Input::hasFile('file')) {
             $f = \Input::file('file');
             if ($f) {
                 $att = new Attachment;
                 $att->user_id = $user->id;
                 $r = array();
                 $r = AttachmentController::uploadAttachment($f, $att);
             }
         }
         return Redirect::to('admin/user')->with('success_message', 'Registro guardado!');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = User::findOrFail($id);
      $show = true;
      return View::make('admin.user.new_edit_user', compact('user', 'show'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);
      $show = false;
      return View::make('admin.user.new_edit_user', compact('user', 'show'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
      $user = User::findOrFail($id);
      $user->fill($request->all());
      $user->save();
      //Ingresamos la imagen seleccionada nuevamente
      if (\Input::hasFile('file')) {
          //Eliminamos la imagen anterior
          AttachmentController::destroyAllBy('user_id', $user->id);
          $f = \Input::file('file');
          if ($f) {
              $att = new Attachment;
              $att->user_id = $user->id;
              $r = array();
              $r = AttachmentController::uploadAttachment($f, $att);
          }
      }
      return Redirect::to('admin/user')->with('success_message', 'Registro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::find($id);
      $user->delete();
      //Eliminamos imagen asociada de usuario
      AttachmentController::destroyAllByUserId($user->id);
      return Redirect::to('admin/user')->with('success_message', 'El registro ha sido borrado.')->withInput();
    }

    /**
     * Metodo para cerrar la sesion del usuario
     */
    public function doLogout() {
        if (Auth::check()) {
            Auth::logout();
        }
        return Redirect::to('/');
    }

    /**
     * Metodo para hacer la busqueda
     */
    public static function search(Request $request) {
        $items = array();
        $search = '';
        if ($request->input('search')) {
            $search = $request->input('search');
            $arrparam = explode(' ', $search);
            $items = User::whereNested(function($q) use ($arrparam) {
                $p = $arrparam[0];
                $q->whereNested(function($q) use ($p) {
                    $q->where('id', 'LIKE', '%' . $p . '%');
                    $q->orwhere('name', 'LIKE', '%' . $p . '%');
                    $q->orwhere('email', 'LIKE', '%' . $p . '%');
                    $q->orwhere('enable', 'LIKE', '%' . $p . '%');
                });
                $c = count($arrparam);
                if ($c > 1) {
                  for ($i = 1; $i < $c; $i++) {
                        $p = $arrparam[$i];
                        $q->whereNested(function($q) use ($p) {
                            $q->where('id', 'LIKE', '%' . $p . '%');
                            $q->orwhere('name', 'LIKE', '%' . $p . '%');
                            $q->orwhere('email', 'LIKE', '%' . $p . '%');
                            $q->orwhere('enable', 'LIKE', '%' . $p . '%');
                        }, 'OR');
                    }
                }
            })
            ->whereNull('deleted_at')
            ->orderBy('name', 'ASC')
            ->paginate(10);
            return View::make('admin.user.view_user', compact('items', 'search'));
        }
    }
}
