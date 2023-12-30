<?php

namespace App\Orchid\Screens\SchoolClass;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\SchoolClass;
use Orchid\Screen\TD;

class SchoolListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'schoolClasses' => SchoolClass::select(['id', 'name', 'grade', 'student_male_count', 'student_female_count'])
                ->get(),
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
            Link::make('新增班級')
                ->icon('plus')
                ->route('platform.schools.school.create'),
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
            Layout::table('schoolClasses', [
                TD::make('id', 'ID')
                    ->sort()
                    ->cantHide(),
                TD::make('name', '班級名稱')
                    ->sort()
                    ->filter(TD::FILTER_TEXT),
                TD::make('grade', '年級')
                    ->sort(),
                TD::make('student_male_count', '男學生人數')
                    ->sort(),
                TD::make('student_female_count', '女學生人數')
                    ->sort(),
                TD::make('actions', '操作')
                    ->render(function (SchoolClass $schoolClass) {
                        return Link::make('編輯')
                            ->route('platform.schools.school.edit', $schoolClass);
                    }),
            ]),
        ];
    }
}
