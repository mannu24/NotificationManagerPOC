<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Component
{
    public $user;
    public $unreadCount;
    public $showNotifications = false;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->unreadCount = 4;
    }

    public function toggleShowNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
    }

    public function render()
    {
        return view('livewire.user.user-dashboard')->extends('layouts.user', ['user' => $this->user, 'unreadCount' => $this->unreadCount]);
    }
    
}
