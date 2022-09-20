<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return JsonResponse
     */
    public function store(OrderRequest $request)
    {
        $totalAmount = 0;
        $products = [];

        foreach ($request->items as $item) {
            $product = Product::find($item['productId']);

            if ($product->stock < 1) {
                return response()->json([
                    'message' => 'Product is out of stock.',
                    'productId' => $product->id,
                ]);
            }

            $product->update([
                'stock' => $product->stock - 1,
            ]);

            if ($product->category == 1 && $item['quantity'] >= 2) {
                $products[] = [
                    'price' => $product->price,
                    'id' => $product->id,
                ];
            }

            if ($product->category == 2 && $item['quantity'] >= 6) {
                $giftCount = floor($item['quantity'] / 6);

                $totalAmount = $totalAmount - ($giftCount * $product->price);
            }

            $totalAmount = $totalAmount + ($item['quantity'] * $product->price);
        }

        if ($products) {
            $totalAmount = $totalAmount - (min($products)['price'] * 0.20);
        }

        if ($totalAmount >= 1000) {
            $totalAmount = $totalAmount - ($totalAmount * 0.10);
        }

        $order = Order::create([
            'customerId' => $request->customerId,
            'items' => $request->items,
            'total' => $totalAmount,
        ]);

        return $this->show($order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order)
    {
        $order = Order::findOrFail($order->id);

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->destroy($order->id);

        return response()->json([
            'message' => 'Order deleted',
        ]);
    }
}
