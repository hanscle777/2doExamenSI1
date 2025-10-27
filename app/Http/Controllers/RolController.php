<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rols = Rol::all();
        return response()->json($rols);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rols.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:rols,nombre'
        ]);

        $rol = Rol::create($request->all());
        return response()->json($rol, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        return response()->json($rol);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        return view('rols.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:rols,nombre,' . $rol->id_rol . ',id_rol'
        ]);

        $rol->update($request->all());
        return response()->json($rol);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        $rol->delete();
        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
