<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ContactBook extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'student_id',
        'contact_id',
        'content',
    ];
    public function classNotifications()
    {
        return $this->hasMany(ClassNotification::class);
    }
    public function studentNotifications()
    {
        return $this->hasMany(StudentNotification::class);
    }
  
    public function schoolNotificationContents()
    {
        return $this->hasMany(SchoolNotificationContent::class);
    }
}
