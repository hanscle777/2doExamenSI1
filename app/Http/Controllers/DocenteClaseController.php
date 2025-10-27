<?php

namespace App\Http\Controllers;

use App\Models\DocenteClase;
use App\Models\Docente;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;

class DocenteClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docenteClases = DocenteClase::with(['docente.usuario', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        return response()->json($docenteClases);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::with('usuario')->get();
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])->get();
        return view('docente-clases.create', compact('docentes', 'grupoMaterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_grupo_materia' => 'required|exists:grupo_materias,id_grupo_materia'
        ]);

        // Verificar que no exista ya esta combinación
        $existing = DocenteClase::where('id_docente', $request->id_docente)
                                ->where('id_grupo_materia', $request->id_grupo_materia)
                                ->first();

        if ($existing) {
            return response()->json(['error' => 'Este docente ya está asignado a esta clase'], 400);
        }

        $docenteClase = DocenteClase::create($request->all());
        return response()->json($docenteClase, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DocenteClase $docenteClase)
    {
        $docenteClase->load(['docente.usuario', 'grupoMateria.grupo', 'grupoMateria.materia']);
        return response()->json($docenteClase);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocenteClase $docenteClase)
    {
        $docentes = Docente::with('usuario')->get();
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])->get();
        return view('docente-clases.edit', compact('docenteClase', 'docentes', 'grupoMaterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocenteClase $docenteClase)
    {
        $request->validate([
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_grupo_materia' => 'required|exists:grupo_materias,id_grupo_materia'
        ]);

        // Verificar que no exista ya esta combinación (excluyendo el registro actual)
        $existing = DocenteClase::where('id_docente', $request->id_docente)
                                ->where('id_grupo_materia', $request->id_grupo_materia)
                                ->where('id_docente_clase', '!=', $docenteClase->id_docente_clase)
                                ->first();

        if ($existing) {
            return response()->json(['error' => 'Este docente ya está asignado a esta clase'], 400);
        }

        $docenteClase->update($request->all());
        return response()->json($docenteClase);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocenteClase $docenteClase)
    {
        $docenteClase->delete();
        return response()->json(['message' => 'Docente-Clase eliminado correctamente']);
    }
}
