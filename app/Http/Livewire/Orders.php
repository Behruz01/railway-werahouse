<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\OrderService;

class Orders extends Component
{
    public $user_id;
    public $wagon_id;
    public $order_number;
    public $description;
    public $status = 'pending';
    public $delivery_date;

    private OrderService $orderService;

    protected $messages = [
        'user_id.required' => 'User ID is required',
        'order_number.required' => 'Order number is required',
        'order_number.unique' => 'Order number must be unique',
        'description.required' => 'Description is required',
        'status.required' => 'Status is required',
        'delivery_date.required' => 'Delivery date is required',
    ];

    public function boot(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function addOrder()
    {
        $this->validate([
            'order_number' => 'required|unique:orders,order_number',
            'description' => 'required',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_date' => 'required|date',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'wagon_id' => $this->wagon_id, // nullable
            'order_number' => $this->order_number,
            'description' => $this->description,
            'status' => $this->status,
            'delivery_date' => $this->delivery_date,
        ];

        $this->orderService->addOrder($data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-created');
        $this->emitSelf('notify-created');
    }

    public function update($id)
    {
        $data = [];

        if ($this->wagon_id !== null) {
            $data['wagon_id'] = $this->wagon_id;
        }

        if ($this->status !== null) {
            $data['status'] = $this->status;
        }

        if ($this->delivery_date !== null) {
            $data['delivery_date'] = $this->delivery_date;
        }

        if ($this->description !== null) {
            $data['description'] = $this->description;
        }

        if ($this->order_number !== null) {
            $data['order_number'] = $this->order_number;
        }

        $this->orderService->updateOrder($id, $data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-updated', ['order' => $id]);
        $this->emit('refreshOrders'); // jadvalni yangilash
    }

    public function delete($id)
    {
        $this->orderService->deleteOrder($id);
        $this->reset();
        $this->dispatchBrowserEvent('notify-deleted', ['order' => $id]);
        $this->emitSelf('notify-deleted');
    }

    public function render()
    {
        return view('livewire.orders', [
            'orders' => $this->orderService->getAll(),
        ]);
    }
}
