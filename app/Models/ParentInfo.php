<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ParentInfo extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'student_id',
        'name',
        'phone',
        'email',
        'address',
        'relationship',
        'alias',
        'contact',
        'job',
        'contact_time',
        'main_guardian',
        'line_id',
        'line_token',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
