<?php

namespace App\Repositories\Contracts;

use App\Model\Notification;

interface NotificationRepository
{
    public function create(array $data);

    public function update(Notification $notification, $data);

    public function delete(Notification $notification);
}
