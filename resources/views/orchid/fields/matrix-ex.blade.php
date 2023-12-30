@component($typeForm, get_defined_vars())
    <table class="matrix table table-bordered border-right-0"
           data-controller="matrix-ex"
           data-matrix-ex-index="{{ $index }}"
           data-matrix-ex-rows="{{ $maxRows }}"
           data-matrix-ex-init-rows="{{ $initRows }}"
           data-matrix-ex-key-value="{{ var_export($keyValue) }}"
    >
        <thead>
        <tr>
            @if ($draggableRows)
                <th style="width:30px" class="text-center p-0">
                    <!-- move -->
                </th>
            @endif

            @foreach($columns as $key => $column)
                @if(!in_array($column, $invisible))
                    <th scope="col" class="text-capitalize">
                        {{ is_int($key) ?
                            Arr::get($labels,$column, $column) :
                            Arr::get($labels,$key, $key)
                        }}
                    </th>
                @endif
            @endforeach

            @if($removableRows)
                <th style="width:30px" class="text-center p-0">
                    <!-- move -->
                </th>
            @endif
        </tr>
        </thead>
        <tbody>

        @foreach($value as $key => $row)
            @include('orchid.partials.fields.matrix-ex-row',['row' => $row, 'key' => $key])
        @endforeach

        @if ($enabledAdd)
            <tr class="add-row">
                <th colspan="{{ count($columns) + 1 + $draggableRows }}" class="text-center p-0">
                    <a href="#" data-action="matrix-ex#addRow" class="btn btn-block small text-muted">
                        <x-orchid-icon path="plus-alt"/>
                        <span>{{ __('Add row') }}</span>
                    </a>
                </th>
            </tr>
        @endif

        <template class="matrix-template">
            @include('orchid.partials.fields.matrix-ex-row',['row' => [], 'key' => '{index}'])
        </template>
        </tbody>
    </table>
@endcomponent
