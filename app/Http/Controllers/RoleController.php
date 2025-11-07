<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() 
    { 
    
        $roles = Role::included()->filter()->get(); 
 
        return response()->json($roles); 
    } 
 
    // Crear categoría (vista o preparación) 
    public function create() 
    { 
        // Aquí podrías preparar datos si fuera una vista 
    } 
 
    // Guardar categoría 
    public function store(Request $request) 
    { 
         
 
        $Role = Role::create($request->all()); 
 
        return response()->json($Role); 
    } 
 
    // Mostrar una categoría 
    public function show(Role $Role) 
    { 
        // Cargar relaciones si están en el modelo 
        $Role->load(['']); 
 
        return response()->json( $Role); 
    } 
 
    // Editar categoría (vista o preparación) 
    public function edit(Role $Role) 
    { 
        // Aquí podrías enviar datos a una vista 
    } 
 
    // Actualizar categoría 
    public function update(Request $request, Role $Role) 
    { 
 
        $Role->update($request->all()); 
 
        return response()->json( $Role); 
    } 
 
    // Eliminar categoría 
    public function destroy(Role $Role) 
    { 
       $Role->delete(); 
         
        return response()->json('eliminada correctamente'); 
    }
}
