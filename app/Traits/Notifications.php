<?php

namespace App\Traits;

use App\Notification;

trait Notifications {

    public function userToBlock($id, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Account Suspended";
        $alert->message = "You're blocked due to some prohibited actions. if you think this is wrong, please contact us";
        $alert->user_role = $role;
        $alert->save();
    }

    public function userToUnblock($id, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Account Unsuspended";
        $alert->message = "You're unblocked and you can use our website now";
        $alert->user_role = $role;
        $alert->save();
    }

    public function createSeller($id, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Add new seller";
        $alert->message = "You've just added a new seller successfully";
        $alert->user_role = $role;
        $alert->save();
    }
}