<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Aula;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = Horario::with(['aula', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        return response()->json($horarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aulas = Aula::all();
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])->get();
        return view('horarios.create', compact('aulas', 'grupoMaterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'horario_inicio' => 'required|string|max:10',
            'horario_fin' => 'required|string|max:10',
            'diasemana' => 'required|string|max:10',
            'id_aula' => 'required|exists:aulas,id_aula',
            'id_grupo_materia' => 'required|exists:grupo_materias,id_grupo_materia'
        ]);

        // Verificar que no haya conflicto de horarios en la misma aula
        $conflicto = Horario::where('id_aula', $request->id_aula)
                           ->where('diasemana', $request->diasemana)
                           ->where(function($query) use ($request) {
                               $query->whereBetween('horario_inicio', [$request->horario_inicio, $request->horario_fin])
                                     ->orWhereBetween('horario_fin', [$request->horario_inicio, $request->horario_fin])
                                     ->orWhere(function($q) use ($request) {
                                         $q->where('horario_inicio', '<=', $request->horario_inicio)
                                           ->where('horario_fin', '>=', $request->horario_fin);
                                     });
                           })
                           ->first();

        if ($conflicto) {
            return response()->json(['error' => 'Ya existe un horario en esta aula para el mismo día y hora'], 400);
        }

        $horario = Horario::create($request->all());
        return response()->json($horario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        $horario->load(['aula', 'grupoMateria.grupo', 'grupoMateria.materia']);
        return response()->json($horario);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        $aulas = Aula::all();
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])->get();
        return view('horarios.edit', compact('horario', 'aulas', 'grupoMaterias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'horario_inicio' => 'required|string|max:10',
            'horario_fin' => 'required|string|max:10',
            'diasemana' => 'required|string|max:10',
            'id_aula' => 'required|exists:aulas,id_aula',
            'id_grupo_materia' => 'required|exists:grupo_materias,id_grupo_materia'
        ]);

        // Verificar que no haya conflicto de horarios en la misma aula (excluyendo el registro actual)
        $conflicto = Horario::where('id_aula', $request->id_aula)
                           ->where('diasemana', $request->diasemana)
                           ->where('id_horario', '!=', $horario->id_horario)
                           ->where(function($query) use ($request) {
                               $query->whereBetween('horario_inicio', [$request->horario_inicio, $request->horario_fin])
                                     ->orWhereBetween('horario_fin', [$request->horario_inicio, $request->horario_fin])
                                     ->orWhere(function($q) use ($request) {
                                         $q->where('horario_inicio', '<=', $request->horario_inicio)
                                           ->where('horario_fin', '>=', $request->horario_fin);
                                     });
                           })
                           ->first();

        if ($conflicto) {
            return response()->json(['error' => 'Ya existe un horario en esta aula para el mismo día y hora'], 400);
        }

        $horario->update($request->all());
        return response()->json($horario);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return response()->json(['message' => 'Horario eliminado correctamente']);
    }
}
