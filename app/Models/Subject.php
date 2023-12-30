<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Subject extends Model
{
    use HasFactory;
    use AsSource;
    protected $fillable = [
        'name',
        'code',
        'description',
    ];
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

}
