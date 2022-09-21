<?php

namespace App\Http\Controllers;

use App\Http\Constants\Products;
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
        if (!$this->checkStock($request->items)) {
            return response()->json([
                'message' => 'Product is out of stock.',
            ]);
        }

        $products = $this->giveDiscount($request->items);

        $order = Order::create([
            'customerId' => $request->customerId,
            'items' => $products['items'],
            'total' => $products['total'],
        ]);

        return $this->show($order);
    }

    /**
     * @param array $products
     * @return bool
     */
    private function checkStock(array $products)
    {
        foreach ($products as $item) {
            $product = Product::find($item['productId']);

            if ($product->stock < 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $products
     * @return array
     */
    private function giveDiscount(array $products)
    {
        $totalAmount = 0;

        foreach ($products as $item) {
            $product = Product::find($item['productId']);

            $product->update([
                'stock' => $product->stock - 1,
            ]);

            if ($product->category == Products::CATEGORY_IDS[1] && $item['quantity'] >= Products::DISCOUNT_QUANTITIES['BUY_5_GET_1']) {
                $products[] = [
                    'price' => $product->price,
                    'id' => $product->id,
                ];
            }

            if ($product->category == Products::CATEGORY_IDS[2] && $item['quantity'] >= Products::DISCOUNT_QUANTITIES['10_PERCENT_OVER_1000']) {
                $giftCount = floor($item['quantity'] / Products::DISCOUNT_QUANTITIES['10_PERCENT_OVER_1000']);

                $totalAmount -= $giftCount * $product->price;
            }

            $totalAmount += $item['quantity'] * $product->price;
        }

        if ($products) {
            $totalAmount -= min($products)['price'] * 0.20;
        }

        if ($totalAmount >= 1000) {
            $totalAmount -= $totalAmount * 0.10;
        }

        return [
            'items' => $products,
            'total' => $totalAmount,
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order)
    {
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
