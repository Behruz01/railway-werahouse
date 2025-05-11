<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Wagon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // If user is admin or manager, show all orders
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')) {
            $orders = Order::with(['user', 'wagon.train'])->get();
        } else {
            // Otherwise, show only the user's orders
            $orders = Order::with(['wagon.train'])
                ->where('user_id', Auth::id())
                ->get();
        }
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wagons = Wagon::with('train')->get();
        return view('orders.create', compact('wagons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wagon_id' => 'nullable|exists:wagons,id',
            'order_number' => 'required|string|max:255|unique:orders',
            'description' => 'required|string',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create order with current user ID
        $order = new Order($request->all());
        $order->user_id = Auth::id();
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Check if user is authorized to view this order
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('manager') && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['user', 'wagon.train']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Check if user is authorized to edit this order
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('manager') && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $wagons = Wagon::with('train')->get();
        return view('orders.edit', compact('order', 'wagons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Check if user is authorized to update this order
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('manager') && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'wagon_id' => 'nullable|exists:wagons,id',
            'order_number' => 'required|string|max:255|unique:orders,order_number,' . $order->id,
            'description' => 'required|string',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $order->update($request->all());

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Check if user is authorized to delete this order
        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('manager') && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Display the user's orders.
     */
    public function userOrders()
    {
        $orders = Order::with(['wagon.train'])
            ->where('user_id', Auth::id())
            ->get();
        
        return view('orders.user', compact('orders'));
    }
}
