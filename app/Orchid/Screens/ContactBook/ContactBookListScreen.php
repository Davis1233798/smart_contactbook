<?

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;

class ContactBookListScreen extends Screen
{
    public function query(): array
    {
        return [
            'contactBooks' => ContactBook::paginate(),
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('新增聯絡簿')
                ->icon('plus')
                ->route('platform.contactbook.create'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('contactBooks', [
                TD::make('id', 'ID')
                    ->sort()
                    ->cantHide(),

                TD::make('created_at', '聯絡簿')
                    ->sort()
                    ->render(function (ContactBook $contactBook) {
                        return $contactBook->created_at ? $contactBook->created_at->toDateString() . ' 聯絡簿' : '';
                    }),

                TD::make('remark', '備註')
                    ->sort()
                    ->cantHide(),

                TD::make('action', '操作')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (ContactBook $contactBook) {
                        return Link::make('檢視')
                            ->icon('eye')
                            ->route('platform.contactbook.show', $contactBook->id)
                            ->class('btn btn-sm btn-warning');
                    }),
                TD::make('action', '操作')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (ContactBook $contactBook) {
                        return Link::make('編輯')
                            ->icon('pencil')
                            ->route('platform.contactbook.edit', $contactBook->id)
                            ->class('btn btn-sm btn-info');
                    }),
            ]),
        ];
    }

    public function name(): string
    {
        return '聯絡簿列表';
    }

    public function description(): string
    {
        return '聯絡簿列表紀錄';
    }

    public function sendContactBook(ContactBook $contactBook)
    {
        $contactBook->sendContactBook();
        Toast::info('聯絡簿已發送');
    }
}
