<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Image;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {

    use \App\Http\Controllers\Traits\ResponseTrait;

    public function createOrder(Request $request) {
        $validator = Validator::make(Input::all(), Order::$rules_create_order);
        if ($validator->passes()) {
            $order = new Order;
            $order->maker_id = $request->maker_id;
            $order->user_id = $request->user_id;
            $order->odate = $request->odate;
            $order->description = $request->description;
            $order->status = $request->status;
            $order->save();
            if ($order) {
                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->portfollio_id = $request->portfollio_id;
                $order_detail->qty = $request->qty;
                $order_detail->save();
            }
            return $this->_res(true, ["message" => "Order has been created successfully."]);
        } else {
            $response = $validator->messages();
            return $this->_res(false, $response->all());
        }
    }

    public function getAllOrder(Request $request) {
        if (isset($request->user_id)) {
            $ordersData = array();
            $orders = Order::where('user_id', $request->user_id)
                    ->with('avatar')
                    ->with('orderdetail')
                    ->get();
            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $ordersData[] = array(
                        'id' => (string) $order->id,
                        'user_id' => (string) $order->user_id,
                        'makername' => $order->orderdetail->name,
//                        'image' => $order->avatar->path,
                        'description' => $order->description,
                        'status' => $order->status
                    );
                }
                return $this->_res(true, $ordersData);
            } else {
                return $this->_res(false);
            }
        } else {
            return $this->_res(false, ["message" => "User ID is required."]);
        }
    }

    public function getOrder(Request $request) {
        if (isset($request->orderid)) {
            $order = Order::where('id', $request->orderid)
                    ->with('avatar')
                    ->with('orderdetail')
                    ->get();
            if (count($order) > 0) {
                $order = array(
                    'id' => (string) $order[0]->id,
                    'user_id' => (string) $order[0]->user_id,
                    'makername' => $order[0]->orderdetail->name,
                    //'image' => $order[0]->img_path,
                    'description' => $order[0]->description,
                    'status' => $order[0]->status
                );
                return $this->_res(true, $order);
            } else {
                return $this->_res(false, ['message' => 'Order not found.']);
            }
        } else {
            return $this->_res(false, ["message" => "Order ID is required."]);
        }
    }

    public function orderStatus(Request $request) {
        $order = Order::find($request->orderid);
        if (count($order) > 0) {
            $ord_status = array(
                'status' => $order->status
            );
            return $this->_res(true, $ord_status);
        } else {
            return $this->_res(false, ['message' => 'Order not found.']);
        }
    }

    public function updateStatus(Request $request) {
        $order = Order::find($request->id);
        if ($order) {
            $order->status = $request->status;
            $order->save();
            return $this->_res(true, ['message' => 'Order status has been updated successfully.']);
        } else {
            return $this->_res(false, ['message' => 'Order not found.']);
        }
    }

    public function deleteOrder(Request $request) {
        $order = Order::find($request->id);
        if ($order) {
            $order->delete();
            return $this->_res(true, ['message' => 'Order status has been deleted successfully.']);
        } else {
            return $this->_res(false, ['message' => 'Order not found.']);
        }
    }

}
