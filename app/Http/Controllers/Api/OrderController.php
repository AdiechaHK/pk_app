<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Image;
use Hash;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Response;
//use Illuminate\Support\Facades\Storage;
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
            return $this->_res(false, [$response->all()]);
        }
    }

    public function getAllOrder(Request $request) {
        $ordersData = array();

        $orders = Order::where('user_id', $request->user_id)
                ->with('avatar')
                ->with('orderdetail')
                ->get();
        /* $orders = DB::table('order')
          ->join('users', 'users.id', '=', 'order.id')
          ->join('images', 'users.image', '=', 'images.id')
          ->select('images.type as img_type', 'images.name as img_name', 'images.path as img_path', 'users.name', 'users.image', 'users.type', 'order.id as order_id', 'order.description', 'order.user_id as user_id', 'order.status as ord_status')
          ->get(); */
        if (count($orders) > 0) {
            foreach ($orders as $order) {
                echo "<pre>";
                print_r($order->avatar[0]);
                echo "</pre>";
                $ordersData[] = array(
                    'id' => (string) $order->id,
                    'user_id' => (string) $order->user_id,
                    'makername' => $order->orderdetail->name,
                    'image' => $order->avatar->path,
                    'description' => $order->description,
                    'status' => $order->status
                );
            }
            exit;
            //return response()->json(['castkingResponse' => $ordersData]);
            return $this->_res(true, [$ordersData]);
        } else {
            //return response()->json(['castkingResponse' => [['success' => false]]]);
            return $this->_res(false);
        }
    }

    public function getOrder(Request $request) {
        $validator = Validator::make(Input::all(), Order::$rules_order_maker);
        if ($validator->passes()) {
            $order = DB::table('order')
                    ->where('order.id', $request->id)
                    ->join('users', 'users.id', '=', 'order.id')
                    ->join('images', 'users.image', '=', 'images.id')
                    ->select('images.type as img_type', 'images.name as img_name', 'images.path as img_path', 'users.name', 'users.image', 'users.type', 'order.id as order_id', 'order.description', 'order.user_id as user_id', 'order.status as ord_status')
                    ->get();
            if (count($order) > 0) {
                $order = array(
                    'id' => (string) $order[0]->order_id,
                    'user_id' => (string) $order[0]->user_id,
                    'makername' => $order[0]->name,
                    'image' => $order[0]->img_path,
                    'description' => $order[0]->description,
                    'status' => $order[0]->ord_status
                );
                return response()->json(['castkingResponse' => [$order]]);
            } else {
                return response()->json(['castkingResponse' => [['success' => false]]]);
            }
        } else {
            $response = $validator->messages();
            return response()->json(['castkingResponse' => [['response' => $response->all()]]]);
        }
    }

    public function orderStatus(Request $request) {
        $order = Order::find($request->orderid);
        if (count($order) > 0) {
            $ord_status = array(
                'status' => $order->status
            );
            return $this->_res(true, [$ord_status]);
        } else {
            return $this->_res(false, ['message' => 'Order not found.']);
        }
    }

    public function updateStatus(Request $request) {
        $order = Order::find($request->id);
        if ($order) {
            $order->status = $request->status;
            $order->save();
            //return response()->json(['castkingResponse' => [["success" => true]]]);
            return $this->_res(true, ['message' => 'Order status has been updated successfully.']);
        } else {
            //return response()->json(['castkingResponse' => [["success" => 'Order not found.']]]);
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
