@component($typeForm, get_defined_vars())
    <div data-controller="qrcode"
         data-meta="{{ $data }}">
        {!! $qrcode !!}
    </div>
@endcomponent
