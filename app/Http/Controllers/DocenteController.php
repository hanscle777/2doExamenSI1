<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::with('usuario')->get();
        return response()->json($docentes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('docentes.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Especialidad' => 'required|string|max:50',
            'fecha_contratacion' => 'required|date',
            'sueldo' => 'required|integer|min:0',
            'id_usuario' => 'required|exists:users,id_usuario'
        ]);

        $docente = Docente::create($request->all());
        return response()->json($docente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        $docente->load('usuario');
        return response()->json($docente);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        $usuarios = User::all();
        return view('docentes.edit', compact('docente', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'Especialidad' => 'required|string|max:50',
            'fecha_contratacion' => 'required|date',
            'sueldo' => 'required|integer|min:0',
            'id_usuario' => 'required|exists:users,id_usuario'
        ]);

        $docente->update($request->all());
        return response()->json($docente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();
        return response()->json(['message' => 'Docente eliminado correctamente']);
    }
}
