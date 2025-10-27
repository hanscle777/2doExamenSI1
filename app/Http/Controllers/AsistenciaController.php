<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Docente;
use App\Models\DocenteClase;
use App\Models\Horario;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asistencias = Asistencia::with([
            'docente.usuario', 
            'docenteClase.docente.usuario', 
            'docenteClase.grupoMateria.grupo', 
            'docenteClase.grupoMateria.materia',
            'horario.aula',
            'horario.grupoMateria.grupo',
            'horario.grupoMateria.materia'
        ])->get();
        return response()->json($asistencias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $docentes = Docente::with('usuario')->get();
        $docenteClases = DocenteClase::with(['docente.usuario', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        $horarios = Horario::with(['aula', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        return view('asistencias.create', compact('docentes', 'docenteClases', 'horarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida' => 'nullable|date_format:H:i:s|after:hora_entrada',
            'estado' => 'required|string|max:10',
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_docente_clase' => 'required|exists:docente_clases,id_docente_clase',
            'id_horario' => 'required|exists:horarios,id_horario'
        ]);

        // Verificar que no exista ya una asistencia para el mismo docente, clase y fecha
        $existing = Asistencia::where('id_docente', $request->id_docente)
                              ->where('id_docente_clase', $request->id_docente_clase)
                              ->where('fecha', $request->fecha)
                              ->first();

        if ($existing) {
            return response()->json(['error' => 'Ya existe una asistencia para este docente en esta clase y fecha'], 400);
        }

        $asistencia = Asistencia::create($request->all());
        return response()->json($asistencia, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asistencia $asistencia)
    {
        $asistencia->load([
            'docente.usuario', 
            'docenteClase.docente.usuario', 
            'docenteClase.grupoMateria.grupo', 
            'docenteClase.grupoMateria.materia',
            'horario.aula',
            'horario.grupoMateria.grupo',
            'horario.grupoMateria.materia'
        ]);
        return response()->json($asistencia);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asistencia $asistencia)
    {
        $docentes = Docente::with('usuario')->get();
        $docenteClases = DocenteClase::with(['docente.usuario', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        $horarios = Horario::with(['aula', 'grupoMateria.grupo', 'grupoMateria.materia'])->get();
        return view('asistencias.edit', compact('asistencia', 'docentes', 'docenteClases', 'horarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida' => 'nullable|date_format:H:i:s|after:hora_entrada',
            'estado' => 'required|string|max:10',
            'id_docente' => 'required|exists:docentes,id_docente',
            'id_docente_clase' => 'required|exists:docente_clases,id_docente_clase',
            'id_horario' => 'required|exists:horarios,id_horario'
        ]);

        // Verificar que no exista ya una asistencia para el mismo docente, clase y fecha (excluyendo el registro actual)
        $existing = Asistencia::where('id_docente', $request->id_docente)
                              ->where('id_docente_clase', $request->id_docente_clase)
                              ->where('fecha', $request->fecha)
                              ->where('id_asistencia', '!=', $asistencia->id_asistencia)
                              ->first();

        if ($existing) {
            return response()->json(['error' => 'Ya existe una asistencia para este docente en esta clase y fecha'], 400);
        }

        $asistencia->update($request->all());
        return response()->json($asistencia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();
        return response()->json(['message' => 'Asistencia eliminada correctamente']);
    }
}
