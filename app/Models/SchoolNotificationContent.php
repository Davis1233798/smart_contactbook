<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolNotificationContent extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'school_notification_id',
        'content',
        'created_by',
        'updated_by',
    ];

    public function contactbook()
    {
        return $this->belongsTo(ContactBook::class);
    }

}
