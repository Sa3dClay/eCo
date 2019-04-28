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

    public function markedAsSeen($id, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Your report updates";
        $alert->message = "Our team currently working on your issue and we will keep you in touch with any updates.";
        $alert->user_role = $role;
        $alert->save();
    }

    public function userOrder($id, $ord_num, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Confirmation of order number " . $ord_num;
        $alert->message = "Thank you for using eCo, we will ship your items as fast as possible.";
        $alert->user_role = $role;
        $alert->save();
    }

    public function newProduct($id, $pro_name, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "You updated your store";
        $alert->message = "Added a new product " . $pro_name;
        $alert->user_role = $role;
        $alert->save();
    }

    public function sellerProduct($id, $name , $pro_name, $role) {
        $alert = new Notification;
        $alert->user_id = $id;
        $alert->title = "Seller " . $name . " updated his store";
        $alert->message = "Added a new product " . $pro_name;
        $alert->user_role = $role;
        $alert->save();
    }
}