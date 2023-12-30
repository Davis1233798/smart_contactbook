<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ClassNotificationContent extends Model
{
    use HasFactory;
    use AsSource;
    protected $fillable = [
        'class_notification_id',
        'title',
        'content',
        'file',
    ];
    public function classNotification()
    {
        return $this->belongsTo(ClassNotification::class);
    }

}
