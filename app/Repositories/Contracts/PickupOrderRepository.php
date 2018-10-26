<?php

namespace App\Repositories\Contracts;

use App\Model\PickupOrder;

interface PickupOrderRepository
{
    public function create(array $data);

    public function update(PickupOrder $order, $data);

    public function delete(PickupOrder $order);
}
