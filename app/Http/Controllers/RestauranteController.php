<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestauranteController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurante::with(['categoria', 'ubicacion', 'tiposComida']);

        // Obtener restaurantes del gerente si está autenticado y es gerente
        $restaurantesGerente = null;
        if (Auth::check() && Auth::user()->rol === 'gerente') {
            $restaurantesGerente = Restaurante::with(['categoria', 'ubicacion', 'tiposComida'])
                ->where('user_id', Auth::id())
                ->where('activo', true)
                ->paginate(4, ['*'], 'gerente_page');
        }

        // Obtener restaurantes patrocinados
        $restaurantesPatrocinados = Restaurante::with(['categoria', 'ubicacion', 'tiposComida'])
            ->where('patrocinados', true)
            ->where('activo', true)
            ->inRandomOrder()
            ->paginate(5, ['*'], 'patrocinados_page');

        // Aplicar ordenamiento
        $ordenar = $request->get('ordenar', 'nombre');
        
        switch ($ordenar) {
            case 'valoracion':
                $query->orderBy('valoracion_promedio', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'soles':
                $query->orderBy('soles', 'desc');
                break;
            case 'nombre':
            default:
                $query->orderBy('nombre', 'asc');
                break;
        }

        $restaurantes = $query->where('activo', true)->paginate(6);

        return view('restaurantes', compact('restaurantes', 'restaurantesPatrocinados', 'restaurantesGerente'));
    }

    public function show($id)
    {
        $restaurante = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'valoraciones.usuario', 'resenas.usuario'])
            ->findOrFail($id);

        return view('restaurante-detalle', compact('restaurante'));
    }
}
