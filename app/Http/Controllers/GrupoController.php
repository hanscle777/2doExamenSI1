<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = Grupo::all();
        return response()->json($grupos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grupos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos,codigo'
        ]);

        $grupo = Grupo::create($request->all());
        return response()->json($grupo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grupo $grupo)
    {
        return response()->json($grupo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grupo $grupo)
    {
        return view('grupos.edit', compact('grupo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:grupos,codigo,' . $grupo->id_grupo . ',id_grupo'
        ]);

        $grupo->update($request->all());
        return response()->json($grupo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return response()->json(['message' => 'Grupo eliminado correctamente']);
    }
}
