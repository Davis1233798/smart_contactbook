<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class StudentParentSignContactBook extends Model
{
    use HasFactory;
    use AsSource;
    protected $fillable = [
        'student_id',
        'communication',
        'parent_infos_id',
        'reply',
        'sign_time',
        'content',
        'remark'
    ];

}
