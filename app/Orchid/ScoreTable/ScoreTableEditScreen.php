<?php

namespace App\Orchid\Screens\SubjectTable;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use App\Models\SubjectTable;
use Orchid\Screen\Actions\Button;
use App\Models\SchoolClass;
use App\Models\Subject;

class SubjectTableEditScreen extends Screen
{
    /**
     * @var SubjectTable
     */
    public $subjectTable;

    /**
     * Query data.
     *
     * @param SubjectTable $subjectTable
     * @return array
     */
    public function query(SubjectTable $subjectTable): array
    {
        return [
            'subjectTable' => $subjectTable,
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
                Input::make('subjectTable.code')
                    ->title('課表代碼'),
                Relation::make('subjectTable.school_class_id')
                    ->title('班級')
                    ->fromModel(SchoolClass::class, 'name'),
                Relation::make('subjectTable.subject_id')
                    ->title('科目')
                    // 假設有一個科目模型 Subject
                    ->fromModel(Subject::class, 'name'),
                Input::make('subjectTable.class_time')
                    ->title('上課時間'),
                Input::make('subjectTable.classroom')
                    ->title('上課教室'),
                Input::make('subjectTable.teacher')
                    ->title('授課老師'),
                Input::make('subjectTable.description')
                    ->title('課表描述'),
                // 其他欄位按需添加
            ]),
        ];
    }

    /**
     * @param SubjectTable $subjectTable
     * @param array        $data
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SubjectTable $subjectTable, array $data)
    {
        $subjectTable->fill($data['subjectTable'])->save();

        return redirect()->route('platform.subject-table.list');
    }
}
