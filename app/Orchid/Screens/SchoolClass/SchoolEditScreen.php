<?php

namespace App\Orchid\Screens\SchoolClass;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use App\Models\SchoolClass;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Illuminate\Http\Request;

class SchoolEditScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(SchoolClass $schoolClass): array
    {
        return [
            'schoolClass' => $schoolClass,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
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
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('schoolClass.name')
                    ->title('班級名稱'),
                Input::make('schoolClass.grade')
                    ->title('年級'),
                Input::make('schoolClass.student_male_count')
                    ->title('男學生人數')
                    ->type('number'),
                Input::make('schoolClass.student_female_count')
                    ->title('女學生人數')
                    ->type('number'),
            ]),
        ];
    }

    /**
     * @param SchoolClass $schoolClass
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function save(SchoolClass $schoolClass, Request $request)
    {
        debug($schoolClass);
        $schoolClass->fill($request->get('schoolClass'))->save();

        return redirect()->route('platform.schools.school.list');
    }
}
