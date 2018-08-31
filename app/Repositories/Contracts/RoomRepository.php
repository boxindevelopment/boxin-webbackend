<?php

namespace App\Repositories\Contracts;

use App\Model\Room;

interface RoomRepository
{
    public function create(array $data);

    public function update(Room $room, $data);

    public function delete(Room $room);
}
