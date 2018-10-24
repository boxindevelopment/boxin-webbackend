<?php

namespace App\Repositories\Contracts;

use App\Model\OrderDetail;

interface OrderDetailRepository
{
    public function create(array $data);

    public function update(OrderDetail $order, $data);

    public function delete(OrderDetail $order);
}
