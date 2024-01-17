<?

namespace App\Orchid\Screens\ContactBook;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Models\ContactBook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Toast;
use App\Http\Traits\ModelEventsTrait;

class ContactBookListScreen extends Screen
{
    use ModelEventsTrait;
    public ?Request $request = null;
    public function name(): string
    {
        return '聯絡簿列表';
    }

    public function description(): string
    {
        return '聯絡簿列表紀錄';
    }

    public function query(Request $request): iterable
    {
        $this->request = $request;
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
                        ->route('platform.contact-book.show', $this->request->query() + ['contactBookId' => $contactBook->id]);
                }),

            TD::make(__('編輯'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->render(function (ContactBook $contactBook) {

                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.contact-book.edit',  $this->request->query() + ['contactBookId' => $contactBook->id]);
                }),
            TD::make(__('刪除'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->render(function (ContactBook $contactBook) {
                    return Button::make()
                        ->icon('trash')
                        ->confirm('確定要刪除此聯絡簿嗎？')
                        ->method('methodRemove', [
                            'id' => $contactBook->id,
                        ]);
                }),
        ];
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
        Log::info('into methodEdit');
        Log::info($contactBook->id);
        return redirect()->route('platform.contact-book.edit', ['id' => $contactBook->id]);
    }
    public function methodRemove(Request $request): RedirectResponse
    {
        $contactBookId = $request->input('id');
        $contactBook = ContactBook::find($contactBookId);

        if ($contactBook) {
            $contactBook->delete();
            Toast::info('聯絡簿已刪除');
        } else {
            Toast::error('找不到指定的聯絡簿');
        }

        return redirect()->route('platform.contactbook.list');
    }
}
