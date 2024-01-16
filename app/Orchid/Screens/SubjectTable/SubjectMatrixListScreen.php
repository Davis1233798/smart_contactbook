<?php

namespace App\Orchid\Screens\SubjectTable;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\SubjectTable;
use Orchid\Screen\TD;

class SubjectMatrixListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'subjectTables' => SubjectTable::paginate(),
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
            Link::make('新增課表')
                ->icon('plus')
                ->route('platform.subject-table.create'),
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
            Layout::table('subjectTables', [
                TD::make('code', '課表代碼'),
                TD::make('school_class_id', '班級識別碼'),
                TD::make('subject_id', '科目識別碼'),
                TD::make('class_time', '上課時間'),
                TD::make('classroom', '上課教室'),
                TD::make('teacher', '授課老師'),
                TD::make('description', '課表描述'),
                // 其他欄位和操作按需添加
            ]),
        ];
    }
}
