<?php

namespace App\Orchid\Layouts\ContactBook;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactBookQuizScoreLayout extends Table
{
    protected $target = 'quizScores';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide(),

            TD::make('student_id', '學生ID')
                ->sort(),

            TD::make('subject_id', '科目ID')
                ->sort(),

            TD::make('score', '分數')
                ->sort(),

            TD::make('created_at', '測驗時間')
                ->sort()
                ->render(function ($score) {
                    return $score->created_at->toDateTimeString();
                }),
        ];
    }
}
