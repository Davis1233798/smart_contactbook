<?php

namespace Database\Factories;

use App\Models\ContactBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactBookFactory extends Factory
{
    protected $model = ContactBook::class;

    public function definition()
    {
        return [
            'student_id' => null, // 可以設定為實際學生ID或使用另一個Factory生成
            'communication' => $this->faker->text(200),
            'content' => $this->faker->text(200),
            'remark' => $this->faker->text(200)
        ];
    }
}
