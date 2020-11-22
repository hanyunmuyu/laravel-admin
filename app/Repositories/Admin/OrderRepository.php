<?php


namespace App\Repositories\Admin;


use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getOrderList($orderNumber = null, $mobile = null, $startDate = null, $endDate = null)
    {
        return Order::orderby('id', 'desc')
            ->where(function ($q) use ($orderNumber) {
                if ($orderNumber) {
                    $q->where('order_number', '=', $orderNumber);
                }
            })
            ->where(function ($q) use ($mobile) {
                if ($mobile) {
                    $q->whereRaw(DB::raw("user_id in (select id from users where mobile='$mobile')"))
                        ->orWhereRaw(DB::raw("order_number in (select order_number from order_addresses where mobile='$mobile')"));
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

    public function getNumberByOrderNumber($orderNumber)
    {
        return Order::where('order_number', '=', $orderNumber)->first();
    }

    public function deleteOrder($orderNumber)
    {
        return Order::where('order_number', '=', $orderNumber)->delete();
    }
}
