<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::all();
        return response()->json($aulas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_aula' => 'required|string|max:50',
            'tipo_aula' => 'required|string|max:50',
            'estado_aula' => 'required|boolean',
            'capacidad_aula' => 'required|integer|min:1'
        ]);

        $aula = Aula::create($request->all());
        return response()->json($aula, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aula $aula)
    {
        return response()->json($aula);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aula $aula)
    {
        return view('aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aula $aula)
    {
        $request->validate([
            'nombre_aula' => 'required|string|max:50',
            'tipo_aula' => 'required|string|max:50',
            'estado_aula' => 'required|boolean',
            'capacidad_aula' => 'required|integer|min:1'
        ]);

        $aula->update($request->all());
        return response()->json($aula);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aula $aula)
    {
        $aula->delete();
        return response()->json(['message' => 'Aula eliminada correctamente']);
    }
}
