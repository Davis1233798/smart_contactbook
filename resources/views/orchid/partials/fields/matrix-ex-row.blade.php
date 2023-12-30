<tr class="draggable">
    @if ($draggableRows)
        <th style="width:5px" class="no-border text-center align-middle">
            <a href="#" data-action="matrix-ex#dragUpRow" class="dragBtn dragUp">
                ↑
            </a>

            <a href="#" data-action="matrix-ex#dragDownRow" class="dragBtn dragDown">
                ↓
            </a>

            @foreach($columns as $column)
                @if(in_array($column, $invisible))
                    {!!
                        $fields[$column]
                             ->value($row[$column] ?? '')
                             ->prefix($name)
                             ->id("$idPrefix-$key-$column")
                             ->name($keyValue ? $column : "[$key][$column]")
                     !!}
                @endif
            @endforeach
        </th>
    @endif

    @foreach($columns as $column)
        @if(!in_array($column, $invisible))
        <th class="p-0 align-middle">
            {!!
               $fields[$column]
                    ->value($row[$column] ?? '')
                    ->prefix($name)
                    ->id("$idPrefix-$key-$column")
                    ->name($keyValue ? $column : "[$key][$column]")
            !!}
        </th>
        @endif

        @if ($loop->last && $removableRows)
            <th style="width:5px" class="no-border text-center align-middle">
                <a href="#"
                   data-action="matrix-ex#deleteRow"
                   class="small text-muted"
                   title="Remove row">
                    <x-orchid-icon path="trash"/>
                </a>
            </th>
        @endif
    @endforeach
</tr>
