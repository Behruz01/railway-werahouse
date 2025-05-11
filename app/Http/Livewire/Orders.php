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
            'user_id' => 'required|exists:users,id',
            'order_number' => 'required|unique:orders,order_number',
            'description' => 'required',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'delivery_date' => 'required|date',
        ]);

        $data = [
            'user_id' => $this->user_id,
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

        if (isset($this->wagon_id)) {
            $data['wagon_id'] = $this->wagon_id;
        }

        if (isset($this->status)) {
            $data['status'] = $this->status;
        }

        if (isset($this->delivery_date)) {
            $data['delivery_date'] = $this->delivery_date;
        }

        $this->orderService->updateOrder($id, $data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-updated', ['order' => $id]);
        $this->emitSelf('notify-updated');
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
