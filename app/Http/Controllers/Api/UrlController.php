<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUrl;
use App\Models\{Url, User};
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Acortar URL (POST /api/shorten).
     */
    public function create(StoreUrl $request)
    {
        $url = Url::create([
            'user_id'     => auth('sanctum')->id(), // Si usas autenticación con Sanctum
            'destination' => $request->long_url,
            'title'       => app(Url::class)->getWebTitle($request->long_url),
            'keyword'     => app(Url::class)->getKeyword($request),
            'is_custom'   => $request->custom_key ? true : false,
            'user_sign'   => app(User::class)->signature(),
        ]);

        return response()->json([
            'status' => 'success',
            'data'   => [
                'short_url' => url($url->keyword),
                'destination' => $url->destination,
                'title'       => $url->title,
                'keyword'     => $url->keyword,
            ]
        ], 201);
    }

    /**
     * Ver detalles de una URL (GET /api/url/{keyword}).
     */
    public function show($keyword)
    {
        $url = Url::where('keyword', $keyword)->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data'   => $url,
        ]);
    }

    /**
     * Eliminar una URL (DELETE /api/url/{keyword}).
     */
    public function delete($keyword)
    {
        $url = Url::where('keyword', $keyword)->firstOrFail();

        // Aquí podrías verificar permisos si quieres
        $url->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'URL eliminada',
        ]);
    }

    /**
     * Listar URLs del usuario autenticado (GET /api/urls).
     */
    public function index()
    {
        $urls = Url::where('user_id', auth('sanctum')->id())->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $urls,
        ]);
    }
}