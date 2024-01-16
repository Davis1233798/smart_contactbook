<?

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Layouts\Row;
use Orchid\Screen\Fields\Label;

class ContactBookShowScreen extends Screen
{
    private $contactBook;

    public function query(ContactBook $contactBook): array
    {
        Log::info('ContactBookShowScreen query');
        Log::info($contactBook);
        $contactBook->load('classNotifications', 'studentNotifications', 'schoolNotificationContents');
        $this->contactBook = $contactBook;
        return [
            'contactBook' => $contactBook
        ];
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Label::make('contactBook.date')
                    ->title('日期'),
                Label::make('contactBook.content')
                    ->title('聯絡事項'),
                Label::make('contactBook.remark')
                    ->title('備註'),
                // 如果需要顯示其他關聯數據，可以在這裡添加
            ]),
        ];
    }

    public function name(): string
    {
        return '檢視聯絡簿';
    }
    public function description(): string
    {
        return '檢視聯絡簿的詳細資訊';
    }
}
