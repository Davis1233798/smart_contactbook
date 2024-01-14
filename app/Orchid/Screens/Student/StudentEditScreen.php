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
        $student
        ->load('schoolClass')
        ->load('parentInfos')
        ->load('studentParentSignContactBooks');
        $this->student = $student;
        return [
            'student' => $student,
            'parentInfos' => $student->parentInfos,
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
            Button::make('新增聯絡簿')
                ->icon('plus')
                ->method('createContactBook'),
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
                         '主要監護人' => 'main_guardian',])
                        ->value($parentInfos->values())
                        ->enableAdd(true),
                ]),

            ])->title(__('家長資訊')),
            //昨日家長聯絡簿回覆事項
            Layout::rows([
                Group::make([
                    Matrix::make('studentParentSignContactBooks')
                        ->columns([
                         '回覆' => 'reply',
                         '回覆時間' => 'created_at',
                         '回覆內容'=>'content',
                         
                        ])
                        ->value($this->student->studentParentSignContactBooks->values())
                        ->enableAdd(false),
                ]),

            ])->title(__('昨日家長聯絡簿回覆事項')),
        ];
    }


    public function save(Student $student)
    {

        try {
            // 學生資料儲存邏輯
            if (!$student->id) {
                $student = new Student();
            }
            $student->fill(request()->all()['student'])->save();

            // 獲取parentInfos數據
            $parentInfosData = request()->get('parentInfos', []);

            foreach ($parentInfosData as $parentInfoData) {
                // 判斷是新增還是更新
                if (isset($parentInfoData['id']) && !empty($parentInfoData['id'])) {
                    // 更新現有parentInfo
                    $parentInfo = ParentInfo::find($parentInfoData['id']);
                    if ($parentInfo) {
                        $parentInfo->update($parentInfoData);
                    }
                } else {
                    // 新增parentInfo
                    $newParentInfo = new ParentInfo($parentInfoData);
                    $student->parentInfos()->save($newParentInfo);
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            // 可以選擇添加錯誤處理邏輯，例如回傳錯誤訊息
            return back()->withErrors(['msg' => '儲存失敗']);
        }

        return redirect()->route('platform.students.list');
    }

    public function methodCreateContactBook()
    {
        return redirect()->route('platform.contactbooks.contactbook.edit', ['student_id' => $this->student->id]);
    }
}
