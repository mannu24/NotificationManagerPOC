<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User_Notifications extends Model
{
    use HasFactory;
    protected $table = 'user_notifications';
    protected $fillable = [
        'user_id', 'notification_id', 'read_at'
    ];

    public function details()
    {
        return $this->hasOne(Notification::class, 'id', 'notification_id');
    }
}
