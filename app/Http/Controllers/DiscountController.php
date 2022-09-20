<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\JsonResponse;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $discounts = Discount::all();

        return response()->json($discounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DiscountRequest $request
     * @return JsonResponse
     */
    public function store(DiscountRequest $request)
    {
        $totalDiscount = 0;
        $discountedTotal = 0;

        foreach ($request->discounts as $discount) {
            $totalDiscount = $totalDiscount + $discount['discountAmount'];
            $discountedTotal = $discountedTotal + $discount['subtotal'];
        }

        $discount = Discount::create([
            'orderId' => $request->orderId,
            'discounts' => $request->discounts,
            'totalDiscount' => $totalDiscount,
            'discountedTotal' => $discountedTotal,
        ]);

        return $this->show($discount->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $discount = Discount::findOrFail($id);

        return response()->json($discount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);

        $discount->destroy($id);

        return response()->json([
            'message' => 'Discount deleted',
        ]);
    }
}
