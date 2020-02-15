<?php

use Illuminate\Database\Seeder;
use \App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\Notification', 20)->create();
    }
}
