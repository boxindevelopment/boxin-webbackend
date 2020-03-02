<?php

namespace App\Repositories\Contracts;

use App\Model\OrderBackWarehouse;

interface OrderBackWarehouseRepository
{
    public function create(array $data);

    public function update(OrderBackWarehouse $backWarehouse, $data);

    public function delete(OrderBackWarehouse $backWarehouse);
}
