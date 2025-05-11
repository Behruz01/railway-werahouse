<?php
declare(strict_types = 1);

namespace App\Services;

use App\Models\Wagon;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository)
    {
        #code
    }

    public function getAll()
    {
        return $this->orderRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->orderRepository->getById($id);
    }

    public function deleteOrder(int $id)
    {
        return $this->orderRepository->destroy($id);
    }

    public function updateOrder(int $id, array $data)
    {
        return $this->orderRepository->update($id, $data);
    }

    public function addOrder(array $data)
    {
        return $this->orderRepository->save($data);
    }
}
