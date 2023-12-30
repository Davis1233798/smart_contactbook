<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class SubjectTable extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'name',
        'code',
        'school_class_id',
        'teacher',
        'classroom',
        'class_time',
        'subject_id',
        'description',
    ];
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
