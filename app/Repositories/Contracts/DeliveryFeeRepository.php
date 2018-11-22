<?php

namespace App\Repositories\Contracts;

use App\Model\DeliveryFee;

interface DeliveryFeeeRepository
{
    public function create(array $data);

    public function update(DeliveryFee $deliveryFee, $data);

    public function delete(DeliveryFee $deliveryFee);
}
