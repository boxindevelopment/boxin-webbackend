<?php

namespace App\Repositories\Contracts;

use App\Model\Box;

interface BoxRepository
{
    public function create(array $data);

    public function update(Box $box, $data);

    public function delete(Box $box);
}
