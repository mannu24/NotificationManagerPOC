<?php

namespace App\Livewire\Admin;

use App\Models\Notification;
use App\Models\User;
use App\Models\User_Notifications;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationsList extends Component
{
    use WithPagination;

    public $showAddForm = false;
    public $users = [];

    public $selectedUser = 'all';
    public $title = '';
    public $type = '';
    public $expiresAt = '';

    
    protected $rules = [
        'title' => 'required|min:6|max:255',
        'type' => 'required|in:system,invoices,marketing',
        'expiresAt' => 'required|date_format:Y-m-d\TH:i'
    ];

    #[Session]
    public $filterType = 'all';
    #[Session]
    public $filterSearch = '';

    public function mount()
    {
        $this->users = User::where('role', 'user')->where('show_notifications', true)->select('id', 'name')->get();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedExpiresAt()
    {
        $this->validate([
            'expiresAt' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $inputDate = Carbon::createFromFormat('Y-m-d\TH:i', $value);
                    if ($inputDate->isPast()) {
                        $fail('Expiry date must be a future date.');
                    }
                },
            ],
        ]);
    }

    public function notificationLists()
    {
        $notifications = new Notification;
        if ($this->filterType != 'all') {
            $notifications = $notifications->where('type', $this->filterType);
        }
        if (strlen($this->filterSearch) > 0) {
            $notifications = $notifications->where('title', 'like', '%'.$this->filterSearch.'%');
        }
        return $notifications->paginate(10);
    }

    public function deleteNotification(Notification $notification)
    {
        $notification->delete();
        $this->redirect(route('notifications'));
    }

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;
    }

    public function save()
    {
        $this->validate($this->rules, [], ['title', 'type', 'expiresAt']);
        $this->updatedExpiresAt();
        $notification = Notification::create([
            'title' => $this->title,
            'type' => $this->type,
            'expires_at' => $this->expiresAt,
        ]);
        if ($this->selectedUser == 'all') {
            foreach ($this->users as $key => $user) {
                User_Notifications::create([
                    'user_id' => $user->id,
                    'notification_id' => $notification->id,
                ]);
            }
        } else {
            User_Notifications::create([
                'user_id' => $this->selectedUser,
                'notification_id' => $notification->id,
            ]);
        }

        $this->redirect(route('notifications'));

    }

    public function render()
    {
        
        return view('livewire.admin.notifications-list', [
            'notifications' => $this->notificationLists()
        ])->extends('layouts.app');
    }
}
