<?php
declare(strict_types = 1);

namespace App\Services;

use App\Models\Wagon;
use App\Repositories\WagonRepository;

class WagonService
{
    public function __construct(private WagonRepository $wagonRepository)
    {
        #code
    }

    public function getAll()
    {
        return $this->wagonRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->wagonRepository->getById($id);
    }

    public function deleteWagon(int $id)
    {
        return $this->wagonRepository->destroy($id);
    }

    public function updateWagon(int $id, array $data)
    {
        return $this->wagonRepository->update($id, $data);
    }

    public function addWagon(array $data)
    {
        return $this->wagonRepository->save($data);
    }
}
