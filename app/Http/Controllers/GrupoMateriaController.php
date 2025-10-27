<?php

namespace App\Http\Controllers;

use App\Models\GrupoMateria;
use App\Models\Grupo;
use App\Models\Materia;
use Illuminate\Http\Request;

class GrupoMateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupoMaterias = GrupoMateria::with(['grupo', 'materia'])->get();
        return response()->json($grupoMaterias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        return view('grupo-materias.create', compact('grupos', 'materias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_materia' => 'required|exists:materias,id_materia'
        ]);

        // Verificar que no exista ya esta combinación
        $existing = GrupoMateria::where('id_grupo', $request->id_grupo)
                                ->where('id_materia', $request->id_materia)
                                ->first();

        if ($existing) {
            return response()->json(['error' => 'Esta combinación de grupo y materia ya existe'], 400);
        }

        $grupoMateria = GrupoMateria::create($request->all());
        return response()->json($grupoMateria, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GrupoMateria $grupoMateria)
    {
        $grupoMateria->load(['grupo', 'materia']);
        return response()->json($grupoMateria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GrupoMateria $grupoMateria)
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        return view('grupo-materias.edit', compact('grupoMateria', 'grupos', 'materias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GrupoMateria $grupoMateria)
    {
        $request->validate([
            'id_grupo' => 'required|exists:grupos,id_grupo',
            'id_materia' => 'required|exists:materias,id_materia'
        ]);

        // Verificar que no exista ya esta combinación (excluyendo el registro actual)
        $existing = GrupoMateria::where('id_grupo', $request->id_grupo)
                                ->where('id_materia', $request->id_materia)
                                ->where('id_grupo_materia', '!=', $grupoMateria->id_grupo_materia)
                                ->first();

        if ($existing) {
            return response()->json(['error' => 'Esta combinación de grupo y materia ya existe'], 400);
        }

        $grupoMateria->update($request->all());
        return response()->json($grupoMateria);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GrupoMateria $grupoMateria)
    {
        $grupoMateria->delete();
        return response()->json(['message' => 'Grupo-Materia eliminado correctamente']);
    }
}
