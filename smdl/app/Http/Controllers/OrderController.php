<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Jobs\SubscriptionOrder;
use App\Models\Order;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request   $request){
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string',
            'basket' => 'required|array|min:1',
            'basket.*.name' => 'required|string|max:255',
            'basket.*.type' => 'required|string|in:unit,subscription',
            'basket.*.price' => 'required|numeric|min:0'
        ]);


        try {
            DB::beginTransaction();


            $order = Order::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'address' => $validated['address']
            ]);

            foreach ($validated['basket'] as $item) {
                $basketItems = $order->basketItems()->create([
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'price' => $item['price']
                ]);

                if($item['type'] === 'subscription'){
                    SubscriptionOrder::dispatch($order,$basketItems);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'data' => $order->load('basketItems')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
