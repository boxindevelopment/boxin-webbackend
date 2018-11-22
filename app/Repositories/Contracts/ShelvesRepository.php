<?php

namespace App\Repositories\Contracts;

use App\Model\Shelves;

interface ShelvesRepository
{
    public function create(array $data);

    public function update(Shelves $shelves, $data);

    public function delete(Shelves $shelves);
}
