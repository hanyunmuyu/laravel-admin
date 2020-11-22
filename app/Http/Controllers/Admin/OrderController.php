<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    private $orderRepository;
    private $userRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function getOrderList(Request $request)
    {
        $keyword = $request->get('keyword');
        $orderList = $this->orderRepository->getOrderList($keyword);
        foreach ($orderList as $k => $order) {
            if ($user = $this->userRepository->getUserById($order->user_id)) {
                $order->user = $user->toArray();
            } else {
                $order->user = new \stdClass();
            }
            $orderList[$k] = $order;
        }
        return $this->success($orderList->toArray());
    }
}
