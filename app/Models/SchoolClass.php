<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class SchoolClass extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'name',
        'grade',
        'student_male_count',
        'student_female_count',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

}
