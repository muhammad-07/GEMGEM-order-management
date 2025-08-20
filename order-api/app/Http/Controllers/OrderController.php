<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * GET /orders — Return all orders (JSON)
     */
    public function index(): JsonResponse
    {
        return response()->json(Order::orderByDesc('created_at')->get());
    }

    /**
     * POST /orders — Create an order
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = Order::create($request->validated());
        return response()->json($order, 201);
    }

    /**
     * PATCH /orders/{id} — Update status (paid or cancelled only)
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): JsonResponse
    {
        $order->update(['status' => $request->validated()['status']]);
        return response()->json($order);
    }
}
