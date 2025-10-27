<?php

namespace App\Http\Controllers;

use App\Models\RolPermiso;
use App\Models\Rol;
use App\Models\Permiso;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rolPermisos = RolPermiso::with(['rol', 'permiso'])->get();
        return response()->json($rolPermisos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rols = Rol::all();
        $permisos = Permiso::all();
        return view('rol-permisos.create', compact('rols', 'permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:rols,id_rol',
            'id_permiso' => 'required|exists:permisos,id_permiso'
        ]);

        // Verificar que no exista ya esta combinación
        $existing = RolPermiso::where('id_rol', $request->id_rol)
                              ->where('id_permiso', $request->id_permiso)
                              ->first();

        if ($existing) {
            return response()->json(['error' => 'Este rol ya tiene asignado este permiso'], 400);
        }

        $rolPermiso = RolPermiso::create($request->all());
        return response()->json($rolPermiso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RolPermiso $rolPermiso)
    {
        $rolPermiso->load(['rol', 'permiso']);
        return response()->json($rolPermiso);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RolPermiso $rolPermiso)
    {
        $rols = Rol::all();
        $permisos = Permiso::all();
        return view('rol-permisos.edit', compact('rolPermiso', 'rols', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RolPermiso $rolPermiso)
    {
        $request->validate([
            'id_rol' => 'required|exists:rols,id_rol',
            'id_permiso' => 'required|exists:permisos,id_permiso'
        ]);

        // Verificar que no exista ya esta combinación (excluyendo el registro actual)
        $existing = RolPermiso::where('id_rol', $request->id_rol)
                              ->where('id_permiso', $request->id_permiso)
                              ->where('id_rol_permiso', '!=', $rolPermiso->id_rol_permiso)
                              ->first();

        if ($existing) {
            return response()->json(['error' => 'Este rol ya tiene asignado este permiso'], 400);
        }

        $rolPermiso->update($request->all());
        return response()->json($rolPermiso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RolPermiso $rolPermiso)
    {
        $rolPermiso->delete();
        return response()->json(['message' => 'Rol-Permiso eliminado correctamente']);
    }
}
