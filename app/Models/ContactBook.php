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
    public function delete()
    {
        // 首先刪除所有關聯的 ClassNotification 實例
        $this->classNotifications()->delete();

        // 接著刪除所有關聯的 StudentNotification 實例
        $this->studentNotifications()->delete();

        // 最後刪除所有關聯的 SchoolNotificationContent 實例
        $this->schoolNotificationContents()->delete();

        // 最後刪除 ContactBook 本身
        return parent::delete();
    }
}
