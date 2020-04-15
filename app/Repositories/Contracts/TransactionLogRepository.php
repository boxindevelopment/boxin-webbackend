<?php

namespace App\Repositories\Contracts;

use App\Model\TransactionLog;

interface TransactionLogRepository
{
    public function create(array $data);

    public function update(TransactionLog $log, $data);

    public function delete(TransactionLog $log);
}
