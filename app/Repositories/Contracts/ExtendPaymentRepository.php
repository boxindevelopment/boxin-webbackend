<?php

namespace App\Repositories\Contracts;

use App\Model\ExtendOrderPayment;

interface ExtendPaymentRepository
{
    public function create(array $data);

    public function update(ExtendOrderPayment $pay, $data);

    public function delete(ExtendOrderPayment $pay);
}
