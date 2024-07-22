<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->where('show_notifications', true)->get();

        // Create 10 Notifications
        for ($i = 0; $i < 10; $i++) {
            $notification = Notification::create([
                'title' => "Notification " . ($i + 1),
                'type' => 'marketing',
                'expires_at' => now()->addDays(7),
            ]);

            // Assign notification to all non-admin users
            foreach ($users as $user) {
                $user->notifications()->create(['notification_id' => $notification->id]);
            }
        }
    }
}
