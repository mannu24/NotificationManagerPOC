<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\User_Notifications;

class UserNotifications extends Component
{
    public $user;
    public $unreadCount;
    public $notificationsList;
    public $showNotifications = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->unreadCount = User_Notifications::where('user_id', $user->id)->whereNull('read_at')
        ->whereHas('details', function($q){
            $q->where('expires_at', '>', now());
        })->count();
        
        $this->notificationsList = $user->notifications()->with('details')->whereHas('details', function($q){
            $q->where('expires_at', '>', now());
        })->latest()->get();
    }

    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
    }

    public function markRead(User_Notifications $notification)
    {
        $notification->read_at = now();
        $notification->save();
        $this->unreadCount-- ;
        $this->notificationsList = $this->user->notifications()->with('details')->latest()->get();
    }

    public function render()
    {
        return view('livewire.user.user-notifications');
    }
}
