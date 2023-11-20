<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orderList = Order::query()
            ->join('products', 'products.id', 'orders.product_id')
            ->where('orders.user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get(['orders.*', 'products.name as product_name', 'products.image']);
        return [
            'orderList' => OrderResource::collection($orderList)
        ];
    }
    public function store(OrderRequest $orderRequest)
    {
        $data = $orderRequest->validated();
        foreach ($data['products'] as $product) {
            Order::create(
                [
                    'user_id' => $data['user_id'],
                    'seller_id' => $product['seller_id'],
                    'product_id' => $product['product_id'],
                    'name' => $data['user_name'],
                    'phone_number' => $data['phone_number'],
                    'email' => $data['email'],
                    'address' => $data['address'],
                    'payment_method' => $data['payment_method'],
                    'price' => $product['price'],
                    'quantity' => $product['quantity'],
                ]
            );
            Cart::query()->where('user_id', $data['user_id'])
                ->where('product_id', $product['product_id'])
                ->delete();
            // Product::query()->where('seller_id',  $product['seller_id'])
            //     ->where('id', $product['product_id'])
            //     ->update(['stock' =>  $product['stock'] - $product['quantity']]);
        }
        $quantity = Cart::query()->where("user_id", $data['user_id'])->sum("quantity");
        return [
            'quantity' =>  $quantity ? $quantity : 0,
        ];
    }
    public function update(OrderRequest $orderRequest, Order $order)
    {
        $data = $orderRequest->validated();
        $order->update($data);
        return [
            'success' => true
        ];
    }
    public function show($id)
    {
        return OrderResource::collection(Order::query()
            ->join('products', 'products.id', 'orders.product_id')
            ->where('orders.id', $id)
            ->get(['orders.*', 'products.name as product_name', 'products.image']));
    }
}
