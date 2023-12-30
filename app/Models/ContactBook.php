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
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function score()
    {
        return $this->hasMany(Score::class);
    }
    public function Communication()
    {
        return $this->hasMany(Communication::class);
    }
}
