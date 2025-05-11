<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Wagon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class WagonRepository
{
    public function __construct(private Wagon $wagon)
    {
        #code
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->wagon->latest()->paginate(config('app.paginate'));
    }

    public function getByUuId($uuid): wagon
    {
        return $this->wagon->whereUuid($uuid)->firstOrFail();
    }

    public function getById($id): wagon
    {
        return $this->wagon->whereId($id)->firstOrFail();
    }

    public function destroy(int $id)
    {
        $wagon = $this->getById($id);
        return $wagon->delete();
    }

    public function update(int $id, array $data)
    {
        $wagon = $this->getById($id);
        $wagon->update($data);
        return $wagon->save();
    }

    public function save(array $data)
    {
     Log::debug('Saving wagon data:', $data);
        return $this->wagon->create($data);
    }

}
