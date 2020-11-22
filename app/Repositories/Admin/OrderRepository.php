<?php


namespace App\Repositories\Admin;


use App\Models\Order;
use App\Models\OrderAddress;

class OrderRepository
{
    public function getOrderList($keyword, $startDate = null, $endDate = null)
    {
        return Order::orderby('id', 'desc')
            ->where(function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('order_number', '=', $keyword);
                }
            })
            ->where(function ($q) use ($startDate) {
                if ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                }
            })
            ->where(function ($q) use ($endDate) {
                if ($endDate) {
                    $q->where('created_at', '<=', $endDate . ' 23:59:59');
                }
            })
            ->paginate();
    }

    public function getOrderAddressByOrderAddress($orderNumber)
    {
        return OrderAddress::where('order_number', '=', $orderNumber)->first();
    }
}
