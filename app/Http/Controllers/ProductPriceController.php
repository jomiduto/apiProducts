<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductPriceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/{id}/prices",
     *     tags={"Precios de productos"},
     *     summary="Obtener precios del producto en diferentes divisas",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de precios obtenida"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function index($id)
    {
        try {
            $product = Product::findOrFail($id);

            $prices = $product->prices()->with('currency')->get();

            return response()->json($prices);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los precios.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}/prices",
     *     tags={"Precios de productos"},
     *     summary="Registrar nuevo precio en divisa para producto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"currency_id","price"},
     *             @OA\Property(property="currency_id", type="integer", example=2),
     *             @OA\Property(property="price", type="number", format="float", example=95.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Precio registrado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function store(Request $request, $id)
    {
        try {
            // Verifica si el producto existe
            $product = Product::findOrFail($id);

            // Valida el request
            $validated = $request->validate([
                'currency_id' => 'required|exists:currencies,id',
                'price' => 'required|numeric|min:0',
            ]);

            $price = ProductPrice::create([
                'product_id' => $product->id,
                'currency_id' => $validated['currency_id'],
                'price' => $validated['price'],
            ]);

            return response()->json($price, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al registrar el precio del producto.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
