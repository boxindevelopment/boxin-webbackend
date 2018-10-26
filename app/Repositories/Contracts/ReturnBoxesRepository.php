<?php

namespace App\Repositories\Contracts;

use App\Model\ReturnBoxes;

interface ReturnBoxesRepository
{
    public function create(array $data);

    public function update(ReturnBoxes $box, $data);

    public function delete(ReturnBoxes $box);
}
