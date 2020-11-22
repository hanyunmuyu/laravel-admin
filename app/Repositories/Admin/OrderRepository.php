<?php


namespace App\Repositories\Admin;


use App\Models\Order;

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
}
