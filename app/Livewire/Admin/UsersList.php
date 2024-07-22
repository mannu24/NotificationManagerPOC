<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class UsersList extends Component
{
    use WithPagination;

    public $showAddForm = false;
    public $editId = false;

    public $name;
    public $email;
    public $mobile;
    public $showNotification = true;

    public $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|max:255|unique:users,email',
        'mobile' => 'phone:IN|unique:users,mobile',
    ];

    protected $messages = [
        'phone' => 'Required a valid phone number'
    ];

    #[Session]
    public $filterSearch = '';

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function userLists()
    {
        $users = User::where('role', 'user')->withCount(['notifications as unread_notifications' => function ($q) {
            $q->whereNull('read_at');
        }]);
        if (strlen($this->filterSearch) > 0) {
            $users = $users->where(function ($query) {
                $query->where('name', 'like', '%' . $this->filterSearch . '%')
                    ->orWhere('mobile', 'like', '%' . $this->filterSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->filterSearch . '%');
            });
        }
        return $users->paginate(10);
    }


    public function deleteUser(User $user)
    {
        $user->delete();
        $this->redirect(route('users'));
    }

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;
    }

    public function editUser(User $user)
    {
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->mobile = $user->mobile;
        $this->showNotification = $user->show_notifications;
        $this->showAddForm = true;

        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $this->editId;
        $this->rules['mobile'] = 'phone:IN|unique:users,mobile,' . $this->editId;
    }

    public function toggleShowNotification()
    {
        $this->showNotification = !$this->showNotification;
    }

    public function save()
    {
        $this->validate($this->rules, $this->messages, ['name', 'email', 'mobile']);
        if (!$this->editId) {
            $password = Str::random(10);
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'password' => Hash::make($password),
                'role' => 'user',
                'show_notifications' => $this->showNotification
            ]);
            // send mail to user for passowrd
        } else {
            $user = User::find($this->editId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'show_notifications' => $this->showNotification
            ]);
        }
        $this->redirect(route('users'));
    }

    public function render()
    {
        $users = User::where('role', 'user')->withCount(['notifications as unread_notifications' => function ($q) {
            $q->whereNull('read_at');
        }])->paginate(10);
        return view('livewire.admin.users-list', [
            'users' => $this->userLists()
        ])->extends('layouts.app');
    }
}
