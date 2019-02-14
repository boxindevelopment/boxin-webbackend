<?php

namespace App\Repositories\Contracts;

use App\Model\Voucher;

interface VoucherRepository
{
    public function create(array $data);

    public function update(Voucher $voucher, $data);

    public function delete(Voucher $voucher);
}
