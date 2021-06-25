<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $orders = Order::with(['product', 'user'])->latest();
            return DataTables::eloquent($orders)
                ->addIndexColumn()
                ->editColumn('created_at', function ($order) {
                    return $order->created_at->format('Y-m-d h:i:s A');
                })
                ->addColumn('status_text', function ($order) {
                    $text = '';
                    switch ($order->status) {
                        case 1:
                            $text = 'Order Placed';
                            break;
                        case 2:
                            $text = 'Processing';
                            break;
                        case 3:
                            $text = 'On Route';
                            break;
                        case 4:
                            $text = 'Delivered';
                            break;
                    }
                    return $text;
                })
                ->addColumn('action', function ($order) {
                    return '<a class="btn btn-info btn-sm" href="' . route('orders.edit', $order->id) . '"><i class="fas fa-pencil-alt"></i> Edit</a>';
                })
                ->rawColumns(['status_text', 'action'])
                ->toJson();
        }

        return view('orders.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status has been updated successfully.');
    }
}
