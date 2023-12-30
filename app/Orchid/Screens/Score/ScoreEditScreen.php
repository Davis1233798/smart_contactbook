<?php

namespace App\Orchid\Screens\Score;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use App\Models\Score;
use App\Models\Student;
use App\Models\Subject;
use Orchid\Screen\Actions\Button;

class ScoreEditScreen extends Screen
{
    /**
     * @var Score
     */
    public $score;

    /**
     * Query data.
     *
     * @param Score $score
     * @return array
     */
    public function query(Score $score): array
    {
        return [
            'score' => $score,
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
            Button::make('保存')
                ->icon('check')
                ->method('save'),
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
            Layout::rows([
                Relation::make('score.student_id')
                    ->title('學生')
                    ->fromModel(Student::class, 'name'),
                Relation::make('score.subject_id')
                    ->title('科目')
                    // 假設有一個科目模型 Subject
                    ->fromModel(Subject::class, 'name'),
                Input::make('score.score')
                    ->title('成績')
                    ->type('number'),
            ]),
        ];
    }

    /**
     * @param Score $score
     * @param array   $data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Score $score, array $data)
    {
        $score->fill($data['score'])->save();

        return redirect()->route('platform.scores.list');
    }
}
