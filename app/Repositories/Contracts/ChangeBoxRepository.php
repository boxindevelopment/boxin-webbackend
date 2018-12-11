<?php

namespace App\Repositories\Contracts;

use App\Model\ChangeBox;

interface ChangeBoxRepository
{
    public function create(array $data);

    public function update(ChangeBox $box, $data);

    public function delete(ChangeBox $box);
}
