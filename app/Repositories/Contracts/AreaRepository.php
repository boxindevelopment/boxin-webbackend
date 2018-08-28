<?php

namespace App\Repositories\Contracts;

use App\Model\Area;

interface AreaRepository
{
    public function create(array $data);

    public function update(Area $area, $data);

    public function delete(Area $area);
}
