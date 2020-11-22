<?php


namespace App\Repositories\Admin;


use App\Models\Order;
use App\Models\OrderAddress;

class OrderRepository
{
    public function getOrderList($keyword)
    {
        return Order::orderby('id', 'desc')
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('order_number', '=', $keyword);
                }
            })
            ->paginate();
    }

    public function getOrderAddressByOrderAddress($orderNumber)
    {
        return OrderAddress::where('order_number', '=', $orderNumber)->first();
    }
}
