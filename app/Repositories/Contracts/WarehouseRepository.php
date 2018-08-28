<?php

namespace App\Repositories\Contracts;

use App\Model\Warehouse;

interface WarehouseRepository
{
    public function create(array $data);

    public function update(Warehouse $warehouse, $data);

    public function delete(Warehouse $warehouse);
}
