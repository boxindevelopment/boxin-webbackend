<?php

namespace App\Repositories\Contracts;

use App\Model\Space;

interface SpaceRepository
{
    public function create(array $data);

    public function update(Space $space, $data);

    public function delete(Space $space);
}
