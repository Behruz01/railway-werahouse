<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
    public function __construct(private Order $order)
    {
        #code
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->order->latest()->paginate(config('app.paginate'));
    }

    public function getByUuId($uuid): order
    {
        return $this->order->whereUuid($uuid)->firstOrFail();
    }

    public function getById($id): order
    {
        return $this->order->whereId($id)->firstOrFail();
    }

    public function destroy(int $id)
    {
        $order = $this->getById($id);
        return $order->delete();
    }

    public function update(int $id, array $data)
    {
        $order = $this->getById($id);
        $order->update($data);
        return $order->save();
    }

    public function save(array $data)
    {
        return $this->order->create($data);
    }

}
