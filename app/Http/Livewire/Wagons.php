<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\WagonService;

class Wagons extends Component
{
    public $van_id;
    public $wagon_number;
    public $capacity;
    public $status = 'active';

    private WagonService $wagonService;

    protected $messages = [
        'van_id.required' => 'A van_id is required',
        'wagon_number.required' => 'The wagon_number is required',
        'capacity.required' =>'The capacity is required',
        'status.required' =>'A status is required',
    ];

    public function boot(WagonService $wagonService)
    {
        $this->wagonService = $wagonService;
    }

    public function delete($id)
    {
        $this->wagonService->deleteWagon($id);
        $this->reset();
        $this->dispatchBrowserEvent('notify-deleted', ['van' => $id]);
        $this->emitSelf('notify-deleted');
    }

    public function update($id)
    {
    $data = [];
        if(isset($this->van_id)){
            $data = [
                'van_id' => $this->van_id,
            ];
        }if(isset($this->wagon_number)){
            $data = [
                'wagon_number' => $this->wagon_number,
            ];
        }if(isset($this->capacity)){
            $data = [
                'capacity' => $this->capacity,
            ];
        }if(isset($this->status)){
            $data = [
                'status' => $this->status,
            ];
        }

        $this->wagonService->updateWagon($id, $data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-updated', ['van' => $id]);
        $this->emitSelf('notify-updated');
    }

    public function addWagon()
    {
        $this->validate([
            'van_id' => 'required',
            'wagon_number' => 'required',
            'capacity' =>'required',
            'status' =>'required',
        ]);

        $data = [
            'van_id' => $this->van_id,
            'wagon_number' => $this->wagon_number,
            'capacity' => $this->capacity,
            'status' => $this->status,
        ];

        $this->wagonService->addWagon($data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-created');
        $this->emitSelf('notify-created');

    }

    public function render()
    {
        return view('livewire.wagons', [
            'wagons' => $this->wagonService->getAll(),
        ]);
    }
}
