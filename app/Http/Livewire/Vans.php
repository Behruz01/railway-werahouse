<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\VanService;

class Vans extends Component
{
    public $name;
    public $capacity;
    public $status = 'maintenance';
    public $year;
    public $reg;

    private VanService $vanService;

    protected $messages = [
        'name.required' => 'A name name is required',
        'capacity.required' => 'The train capacity is required',
        'year.required' =>'The brand year is required',
        'reg.required' =>'A van reg number is required',
    ];

    public function boot(VanService $vanService)
    {
        $this->vanService = $vanService;
    }

    public function delete($id)
    {
        $this->vanService->deleteVan($id);
        $this->reset();
        $this->dispatchBrowserEvent('notify-deleted', ['van' => $id]);
        $this->emitSelf('notify-deleted');
    }

    public function update($id)
    {
    $data = [];
        if(isset($this->name)){
            $data = [
                'name' => $this->name,
            ];
        }if(isset($this->capacity)){
            $data = [
                'capacity' => $this->capacity,
            ];
        }if(isset($this->status)){
            $data = [
                'status' => $this->status,
            ];
        }if(isset($this->year)){
            $data = [
                'year' => $this->year,
            ];
        }if(isset($this->reg)){
            $data = [
                'reg' => $this->reg,
            ];
        }

        $this->vanService->updateVan($id, $data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-updated', ['van' => $id]);
        $this->emitSelf('notify-updated');
    }

    public function addVan()
    {
        $this->validate([
            'name' => 'required',
            'capacity' => 'required',
            'year' =>'required',
            'reg' =>'required',
        ]);

        $data = [
            'name' => $this->name,
            'capacity' => $this->capacity,
            'year' => $this->year,
            'reg' => $this->reg,
        ];

        $this->vanService->addVan($data);
        $this->reset();
        $this->dispatchBrowserEvent('notify-created');
        $this->emitSelf('notify-created');

    }

    public function render()
    {
        return view('livewire.vans', [
            'vans' => $this->vanService->getAll(),
        ]);
    }
}
