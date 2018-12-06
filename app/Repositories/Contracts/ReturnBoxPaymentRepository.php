<?php

namespace App\Repositories\Contracts;

use App\Model\ReturnBoxPayment;

interface ReturnBoxPaymentRepository
{
    public function create(array $data);

    public function update(ReturnBoxPayment $pay, $data);

    public function delete(ReturnBoxPayment $pay);
}
