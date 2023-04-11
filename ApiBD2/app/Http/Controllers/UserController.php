<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\AccountBank;
use GuzzleHttp\Psr7\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if($users){
            return new UserCollection($users);
        } else {
            return Response("Not found users");
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User($request->all());
        $user->save();

        $count = new AccountBank();
        $count->user_id = $user->id;
        $count->balance = 0;
        $count->save();

        return Response()->json(new UserResource($user), status: 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Obtener el usuario por ID
        $user = User::find($id);

        // Verificar si se encontró el usuario
        if (!$user) {
            // Retornar una respuesta de error en caso de que no se encuentre el usuario
            return response()->json([
                'error' => 'Usuario no encontrado'
            ], 404);
        }

        // Retornar el usuario como una respuesta en formato JSON
        return response()->json([
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User :: find($id);

        if($user) {
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->indentification = $request->indentification;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save(); 
            return Response()->json(new UserResource($user), status: 200);           
        } else {
            return Response("User not found");
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User :: find($id);

        if($user) {
            $user->delete();
            return Response("User ".$id." deleted");
        } else {
            return Response("User not found");
        }
    }
}
