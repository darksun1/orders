<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zipcode;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=DB::table('orders AS o')->join('addresses AS a','o.id','=','a.order_id')->join('zip_codes AS zc','a.zip_code_id','=','zc.id')
            ->join('cities AS c','zc.city_id','=','c.id')->join('states AS s','c.state_id','=','s.id')
            ->select('o.id','o.number','o.status','o.created_at AS date','o.total','o.total_weight','o.size','o.refund','a.street','a.ext','a.int','zc.code','c.name AS city',
            's.name AS state')->orderBy('o.created_at','ASC')->get();
        foreach($orders as $order){
            $int='';
            if($order->int!=null)
                $int=' '.$order->int;
            $order->address=$order->street.' '.$order->ext.$int.', CP. '.$order->code.'. '.$order->city.', '.$order->state;
            $products=DB::table('products AS p')->join('order_product AS op','p.id','=','op.product_id')->where('op.order_id',$order->id)->select('p.name AS product','op.quantity')->get();
            $prods='';
            $order->products=$products;
            switch($order->status){
                case 0:
                    $desc_status='Creada';
                    break;
                case 1:
                    $desc_status='Recolectada';
                    break;
                case 2:
                    $desc_status='En estación';
                    break;
                case 3:
                    $desc_status='En ruta';
                    break;
                case 4:
                    $desc_status='Entregada';
                    break;
                case 5:
                    $desc_status='Cancelada';
                    break;
            }
            $order->desc_status=$desc_status;
        }
        return datatables()->of($orders)->make(true);
    }
    public function changeStatus(Request $request){
        $order=Order::find($request->id);
        if($request->status==5){
            $datetime1 = strtotime($order->created_at);
            $datetime2 = strtotime(date('Y-m-d H:i:s'));
            $interval  = abs($datetime2 - $datetime1);
            $minutes   = round($interval / 60);
            if($minutes<=2)
                $order->refund=1;
            else
                $order->refund=0;
        }
        $order->status=$request->status;
        $order->updated_at=date('Y-m-d H:i:s.0000');
        $order->updated_by=Auth::id();
        $order->save();
        return $order->id;
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
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        extract($input);
        DB::beginTransaction();
        try{
            $order=new Order;
            $order->status=0;
            $order->origin=$origin;
            $order->destiny=$destiny;
            $order->total=$total;
            $order->total_weight=$total_w;
            $order->size=$size;
            $order->created_at=date('Y-m-d H:i:s');
            $order->created_by=Auth::id();
            $order->save();
            $order->number=str_pad($order->id, 5, "0", STR_PAD_LEFT);
            $order->save();
            for($i=0;$i<$cont_i;$i++){
                $cb='cbprod_'.$i;
                if(isset($$cb)){
                    $qty='qty_'.$i;
                    $order->products()->attach($$cb,['quantity'=>$$qty]);
                }
            }
            $zip_c=DB::table('zip_codes')->where('code',$zip_code)->first();
            DB::table('addresses')->insert([
                'order_id'=>$order->id,
                'street'=>$street,
                'ext'=>$ext,
                'int'=>$int,
                'zip_code_id'=>$zip_c->id
            ]);
            DB::commit();
            return $order->id;
        }
        catch(\Exception $e){
            DB::rollback();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
