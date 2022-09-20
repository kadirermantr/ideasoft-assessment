<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @return JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'revenue' => $request->revenue,
            'since' => now()->format('Y-m-d'),
        ]);

        return $this->show($customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->destroy($id);

        return response()->json([
            'message' => 'Customer deleted',
        ]);
    }
}
