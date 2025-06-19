<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Productos"},
     *     summary="Obtener lista de productos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos obtenida exitosamente"
     *     )
     * )
     */
    public function index()
    {
        try {
            $products = Product::with('currency', 'prices.currency')->get();
            return response()->json($products);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los productos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Productos"},
     *     summary="Crear un nuevo producto",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","description","price","currency_id","tax_cost","manufacturing_cost"},
     *             @OA\Property(property="name", type="string", example="Producto A"),
     *             @OA\Property(property="description", type="string", example="Descripción del producto"),
     *             @OA\Property(property="price", type="number", format="float", example=100.00),
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=10.00),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=20.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'currency_id' => 'required|exists:currencies,id',
                'tax_cost' => 'required|numeric',
                'manufacturing_cost' => 'required|numeric',
            ]);

            $product = Product::create($validated);

            return response()->json($product, 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear el producto.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Productos"},
     *     summary="Obtener un producto por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $product = Product::with('currency', 'prices.currency')->findOrFail($id);
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener el producto.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"Productos"},
     *     summary="Actualizar un producto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Producto actualizado"),
     *             @OA\Property(property="description", type="string", example="Descripción actualizada"),
     *             @OA\Property(property="price", type="number", format="float", example=120.00),
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=12.00),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=22.00)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'price' => 'sometimes|required|numeric|min:0',
                'currency_id' => 'sometimes|required|exists:currencies,id',
                'tax_cost' => 'sometimes|required|numeric|min:0',
                'manufacturing_cost' => 'sometimes|required|numeric|min:0',
            ]);

            $product->update($validated);

            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el producto.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"Productos"},
     *     summary="Eliminar un producto",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'message' => 'Producto eliminado exitosamente.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Producto no encontrado.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar el producto.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
