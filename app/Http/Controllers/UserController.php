<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('rol')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rols = Rol::all();
        return view('users.create', compact('rols'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:50|unique:users,correo',
            'contrasena' => 'required|string|min:6',
            'telefono' => 'required|integer',
            'estado' => 'required|string|max:10',
            'id_rol' => 'required|exists:rols,id_rol'
        ]);

        $data = $request->all();
        $data['contrasena'] = Hash::make($request->contrasena);

        $user = User::create($data);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('rol');
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $rols = Rol::all();
        return view('users.edit', compact('user', 'rols'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|max:50|unique:users,correo,' . $user->id_usuario . ',id_usuario',
            'telefono' => 'required|integer',
            'estado' => 'required|string|max:10',
            'id_rol' => 'required|exists:rols,id_rol'
        ]);

        $data = $request->all();
        
        // Solo actualizar contraseña si se proporciona
        if ($request->has('contrasena') && !empty($request->contrasena)) {
            $data['contrasena'] = Hash::make($request->contrasena);
        } else {
            unset($data['contrasena']);
        }

        $user->update($data);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
