<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class StudentNotification extends Model
{
    use HasFactory;
    use AsSource;
    protected $table = 'student_notifications';

    protected $fillable = [
        'student_id',
        'contact_book_id',
        'sign_time',
        'content',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
