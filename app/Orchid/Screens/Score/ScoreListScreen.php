<?php

namespace App\Orchid\Screens\Score;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\Score;
use Orchid\Screen\TD;

class ScoreListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'scores' => Score::paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('新增成績')
                ->icon('plus')
                ->route('platform.scores.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::table('scores', [
                TD::make('id', 'ID')
                    ->sort()
                    ->cantHide(),
                TD::make('student_id', '學生ID')
                    ->sort(),
                TD::make('subject_id', '科目ID')
                    ->sort(),
                TD::make('score', '成績')
                    ->sort(),
                TD::make('actions', '操作')
                    ->render(function (Score $score) {
                        return Link::make('編輯')
                            ->route('platform.scores.edit', $score);
                    }),
            ]),
        ];
    }
}
