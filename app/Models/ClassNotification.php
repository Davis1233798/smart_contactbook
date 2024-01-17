<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ClassNotification extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'class_id',
        'contact_book_id',
        'title',
        'content',
        'file',
    ];
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function contactBook()
    {
        return $this->belongsTo(ContactBook::class);
    }
}
