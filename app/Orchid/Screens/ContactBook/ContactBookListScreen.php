<?

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
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
                ->route('platform.contact-book.create'),
        ];
    }

    public function layout(): array
    {
        return [
            Layout::table('contactBooks', array_merge(
                [
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
                ],
                $this->actionButtons()
            )),
        ];
    }

    public function actionButtons(): array
    {
        return [
            TD::make(__('檢視'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->render(function (ContactBook $contactBook) {
                    return Link::make()
                        ->icon('eye')
                        ->route('platform.contact-book.show', $contactBook->id);
                }),

            TD::make(__('編輯'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->render(function (ContactBook $contactBook) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.contact-book.edit', $contactBook->id);
                }),
            // 其他操作按鈕（如刪除等）可以在這裡添加
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
    public function redirectToCreate()
    {
        return redirect()->route('platform.contactbook.create');
    }

    public function methodView(ContactBook $contactBook): RedirectResponse
    {
        return redirect()->route('platform.contact-book.show', $contactBook);
    }
    public function methodEdit(ContactBook $contactBook): RedirectResponse
    {
        return redirect()->route('platform.contact-book.edit', $contactBook);
    }
}
