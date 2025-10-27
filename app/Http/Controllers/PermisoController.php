<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permiso::all();
        return response()->json($permisos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permisos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:permisos,nombre'
        ]);

        $permiso = Permiso::create($request->all());
        return response()->json($permiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Permiso $permiso)
    {
        return response()->json($permiso);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permiso $permiso)
    {
        return view('permisos.edit', compact('permiso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:permisos,nombre,' . $permiso->id_permiso . ',id_permiso'
        ]);

        $permiso->update($request->all());
        return response()->json($permiso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return response()->json(['message' => 'Permiso eliminado correctamente']);
    }
}
