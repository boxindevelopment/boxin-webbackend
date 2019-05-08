<?php

namespace App\Repositories\Contracts;

use App\Model\AddItemBoxPayment;

interface AddItemBoxPaymentRepository
{
    public function create(array $data);

    public function update(AddItemBoxPayment $pay, $data);

    public function delete(AddItemBoxPayment $pay);
}
