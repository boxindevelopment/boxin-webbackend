<?php

namespace App\Repositories\Contracts;

use App\Model\AddItemBox;

interface AddItemBoxRepository
{
    public function create(array $data);

    public function update(AddItemBox $box, $data);

    public function delete(AddItemBox $box);
}
