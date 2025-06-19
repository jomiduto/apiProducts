<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CurrencyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     tags={"Divisas"},
     *     summary="Obtener lista de divisas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de divisas obtenida exitosamente"
     *     )
     * )
     */
    public function index()
    {
        try {
            return response()->json(Currency::all());
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener divisas'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/currencies",
     *     tags={"Divisas"},
     *     summary="Crear nueva divisa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","symbol","exchange_rate"},
     *             @OA\Property(property="name", type="string", example="Dólar"),
     *             @OA\Property(property="symbol", type="string", example="$"),
     *             @OA\Property(property="exchange_rate", type="number", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Divisa creada exitosamente")
     * )
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'exchange_rate' => 'required|numeric|min:0'
            ]);

            $currency = Currency::create($validated);
            return response()->json($currency, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear divisa', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/currencies/{id}",
     *     tags={"Divisas"},
     *     summary="Obtener una divisa por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Divisa encontrada"),
     *     @OA\Response(response=404, description="Divisa no encontrada")
     * )
     */
    public function show($id)
    {
        try {
            $currency = Currency::findOrFail($id);
            return response()->json($currency);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Divisa no encontrada'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/currencies/{id}",
     *     tags={"Divisas"},
     *     summary="Actualizar una divisa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Peso"),
     *             @OA\Property(property="symbol", type="string", example="$"),
     *             @OA\Property(property="exchange_rate", type="number", example=4000)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Divisa actualizada")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $currency = Currency::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'symbol' => 'sometimes|required|string|max:10',
                'exchange_rate' => 'sometimes|required|numeric|min:0'
            ]);

            $currency->update($validated);
            return response()->json($currency);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Divisa no encontrada'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/currencies/{id}",
     *     tags={"Divisas"},
     *     summary="Eliminar una divisa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Divisa eliminada"),
     *     @OA\Response(response=404, description="Divisa no encontrada")
     * )
     */
    public function destroy($id)
    {
        try {
            $currency = Currency::findOrFail($id);
            $currency->delete();
            return response()->json(['message' => 'Divisa eliminada']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Divisa no encontrada'], 404);
        }
    }
}
