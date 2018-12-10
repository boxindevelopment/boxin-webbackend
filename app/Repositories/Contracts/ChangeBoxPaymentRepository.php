<?php

namespace App\Repositories\Contracts;

use App\Model\ChangeBoxPayment;

interface ChangeBoxPaymentRepository
{
    public function create(array $data);

    public function update(ChangeBoxPayment $pay, $data);

    public function delete(ChangeBoxPayment $pay);
}
