<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrderMail;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    public $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $orders = $this->orderRepository->getAll();
//        return response()->json([
//            'success' => true,
//            'message' => 'Order List',
//            'data'    => $orders
//        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'userId' => 'required',
            'orderAmount' => 'required',
            'cart' => "required"
        ]);

        $userId = $request->userId;
        $orderAmount = $request->orderAmount;
        $cart = $request->cart;

        return $this->orderRepository->createOrder($userId, $orderAmount, $cart);
    }

    public function getByCondition(Request $request){

        return $this->orderRepository->getByCondition($request);
    }
    public function getById($id){

        $order = $this->orderRepository->getById($id);
        return $order;
    }

    public function update(Request $request, $id)
    {
        return $this->orderRepository->updateOrder($request, $id);
    }

    public function destroy($id){
        return $this->orderRepository->delete($id);
    }

    public function sendmail(Request $request){
        $user = $request->user();

        $data=[
            'product1'=> 'Iphone 13 promax 256gb'
        ];
        Mail::to($user->email)->send(new ConfirmOrderMail($data));
    }
}
