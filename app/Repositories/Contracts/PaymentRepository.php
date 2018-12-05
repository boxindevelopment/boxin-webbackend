<?php

namespace App\Repositories\Contracts;

use App\Model\Payment;

interface PaymentRepository
{
    public function create(array $data);

    public function update(Payment $pay, $data);

    public function delete(Payment $pay);
}
