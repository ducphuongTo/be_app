<?php

namespace App\Repositories\Order;

use App\Models\OrderItem;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderRepository.
 */
class OrderRepository
{
    public function findById($id)
    {
        $orders = Order::find($id);
        return $orders;
    }
    public function getAll()
    {
        $orders = Order::all();
        return $orders;
    }
    public function create(Request $request)
    {
    }

    public function createOrder($userId, $orderAmount, $cart): \Illuminate\Http\JsonResponse
    {

        DB::beginTransaction();
        $unavailableItems = [];

        try {
            $idOrder = DB::table("orders")->insertGetId(
                [
                    'user_id' => $userId,
                    'order_date' => date_format(date_create(), 'Y-m-d H:i:s'),
                    'order_amount' => $orderAmount
                ]
            );

            $cartMapped = collect($cart)->map(function ($value) use ($idOrder) {
                return [
                    "order_id" => $idOrder,
                    "product_id" => $value["productId"],
                    "quantity" => $value["quantity"],
                    "price" => $value["price"],
                ];
            })->all();
            foreach ($cartMapped as  $item) {
                if (!Product::where("id", "=", $item['product_id'])->exists()) {
                    $unavailableItems[] = $item['product_id'];
                }
            }
            DB::table("order_items")->insert($cartMapped);
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Order successfully"
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "success" => false,
                "message" => "Order failed",
                "data" => $unavailableItems
            ], 400);
        }
    }

    public function updateOrder(Request $request, $id){
        $user = Order::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Order Not Found'], 404);
        }
        $user->update($request->all());
        return response($user, 200);
    }

    public function getById($id)
    {
         $order = Order::where("orders.id", '=', $id)
         ->with('orderItems')
             ->with('orderItems.product')
            ->get();
        return response()->json($order);

//        if (!$order) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Sorry, order not found.'
//            ], 400);
//        }else{
//            return response()->json($order);
//        }

    }
    public function getByCondition(Request $request){
        $size = $request->query("size");
        $result = Order::select("orders.*")
            ->filter($request)
            ->sort($request)
//            ->search($request)
            ->paginate($size);
        return $result;
    }

    public function delete( $id){
        try{
            $order = Order::find($id);
            $order_items = OrderItem::where("order_items.order_id",  "=", $order['id']);
            $order->update(['status' => 'canceled']);
            $order->delete();
            $order_items->delete();
            return response()->json([
                'success' => true,
                'message' => 'Order canceled successfully'
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                "success" => false,
                "message" => "Cancel order failed"
            ], 400);
        }


    }

}
