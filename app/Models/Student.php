<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Model implements JWTSubject
{
    use HasFactory;
    use AsSource;
    protected $fillable = [
        'name',
        'school_class_id',
        'seat_number',
        'school_number'
    ]; // 假設學生有名字和班級ID

    // 關聯到班級
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // 學生的成績關聯
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function parentInfos()
    {
        return $this->hasMany(ParentInfo::class);
    }
    public function contactBooks()
    {
        return $this->hasMany(ContactBook::class);
    }
    public function classNotifications()
    {
        return $this->hasMany(ClassNotification::class);
    }
    public function studentNotifications()
    {
        return $this->hasMany(StudentNotification::class);
    }
    public function studentParentSignContactBooks()
    {
        return $this->hasMany(StudentParentSignContactBook::class);
    }
    /**
     * 獲取將存儲在 JWT 負載中的識別符。
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 返回一個 key-value 數組，其中包含要添加到 JWT 的任何自定義聲明。
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
