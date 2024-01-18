<?php

namespace App\Orchid\Screens\Student;

use App\Models\ParentInfo;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use App\Models\Student;
use Orchid\Screen\Actions\Button;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Matrix;
use Illuminate\Support\Str;

class StudentEditScreen extends Screen
{
    /**
     * @var Student
     */
    public $student;

    /**
     * Query data.
     *
     * @param Student $student
     * @return array
     */
    public function query(Student $student): array
    {
        $student->load('schoolClass', 'parentInfos');

        $studentParentSignContactBooks = $student->studentParentSignContactBooks->map(function ($item) {
            $item->created_at_formatted = $item->created_at->timezone('Asia/Taipei')->format('Y-m-d H:i');
            return $item;
        });

        $this->student = $student;

        return [
            'student' => $student,
            'parentInfos' => $student->parentInfos,
            'studentParentSignContactBooks' => $studentParentSignContactBooks
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
            //回上一頁
            Button::make(__('回上一頁'))
                ->icon('arrow-left')
                ->method('methodGoBack'),

            Button::make('保存')
                ->icon('check')
                ->method('methodSave'),


        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): array
    {
        $parentInfos = $this->student->parentInfos;
        return [
            Layout::rows([
                Group::make([
                    Input::make('student.seat_number')
                        ->title('座號'),
                    Input::make('student.school_number')
                        ->title('學號'),
                ]),
                Group::make([
                    Input::make('student.name')
                        ->title('姓名'),
                    Relation::make('student.school_class_id')
                        ->title('班級')
                        ->fromModel(SchoolClass::class, 'name'),
                ])


            ]),
            Layout::rows([
                Group::make([
                    Matrix::make('parentInfos')
                        ->columns([
                            '姓名' => 'name',
                            '電話' => 'phone',
                            '職業' => 'job',
                            '聯絡時間' => 'contact_time',
                            '主要監護人' => 'main_guardian',
                        ])
                        ->value($parentInfos->values())
                        ->enableAdd(true),
                ]),

            ])->title(__('家長資訊')),
            //昨日家長聯絡簿回覆事項
            Layout::rows([
                Group::make([
                    Matrix::make('studentParentSignContactBooks')
                        ->columns([
                            '回覆內容' => 'reply',
                            '回覆時間' => 'created_at_formatted',
                        ])
                        ->value($this->student->studentParentSignContactBooks->values())
                        ->enableAdd(false),
                ]),

            ])->title(__('家長聯絡簿回覆事項')),
        ];
    }


    public function methodSave(Student $student)
    {
        try {
            // 學生資料儲存邏輯
            if (!$student->id) {
                $student = new Student();
            }
            $student->fill(request()->all()['student'])->save();

            // 獲取 parentInfos 數據
            $parentInfosData = collect(request()->get('parentInfos', []));

            // 獲取現有的 ParentInfo
            $existingParentInfos = $student->parentInfos->keyBy('id');

            // 處理新增和更新
            foreach ($parentInfosData as $parentInfoData) {
                $parentInfoData['line_id'] = Str::random(50);

                if (isset($parentInfoData['id']) && !empty($parentInfoData['id'])) {
                    // 更新現有 parentInfo
                    $parentInfo = ParentInfo::find($parentInfoData['id']);
                    if ($parentInfo) {
                        $parentInfo->update($parentInfoData);
                    }
                    // 從現有集合中移除已處理的 parentInfo
                    $existingParentInfos->forget($parentInfoData['id']);
                } else {
                    // 新增 parentInfo
                    $newParentInfo = new ParentInfo($parentInfoData);
                    $student->parentInfos()->save($newParentInfo);
                }
            }

            // 處理删除的 parentInfos
            foreach ($existingParentInfos as $parentInfo) {
                $parentInfo->delete();
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return back()->withErrors(['msg' => '儲存失敗']);
        }

        return redirect()->route('platform.students.list');
    }



    public function methodGoBack()
    {
        return redirect()->route('platform.students.list');
    }
}
