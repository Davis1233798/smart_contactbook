@component($typeForm, get_defined_vars())
<div data-controller="file-upload"       
    data-file-upload-index="{{ $index }}"
    data-file-upload-rows="{{ $maxRows }}"
    data-file-upload-init-rows="{{ $initRows }}"
    data-file-upload-key-value="{{ var_export($keyValue) }}">
    
    <table class="matrix table table-bordered border-right-0 uploadTable {{ $elementName }}">
        <thead>
        <tr>
            @if ($draggableRows)
                <th class="text-center p-0 w-30">
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
                <th class="text-center p-0 w-30">
                    <!-- move -->
                </th>
            @endif
        </tr>
        </thead>
        <tbody>

        @foreach($value as $key => $row)
            @include('orchid.partials.fields.file-upload-row',['row' => $row, 'key' => $key])
        @endforeach

        <!-- <template class="matrix-template">
            @include('orchid.partials.fields.file-upload-row',['row' => [], 'key' => '{index}'])
        </template> -->
        </tbody>
        <tfoot>
        @if ($enabledAdd)
            <tr class="add-file">
                <th colspan="{{ count($columns) + 1 + $draggableRows }}" class="text-center p-0">
                    <button data-action="file-upload#addFile" class="btn btn-block text-muted" 
                        data-formmethod="{{ $formMethod }}"
                        data-formaction="{{ $formAction }}"
                        data-urlparameters="{{ $urlParameters }}"
                        data-elementname="{{ $elementName }}"
                        data-filecount="{{ $fileCount }}"
                        data-acceptedfiles="{{ $acceptedFiles }}"
                        data-maxfilesize="{{ $maxFileSize }}"
                        data-maxfiles="{{ $maxFiles }}"
                        data-thisid="{{ $thisId }}">
                        <x-orchid-icon path="plus-alt"/>
                        <span>上傳檔案</span>
                    </button>
                </th>
            </tr>
        @endif
        </tfoot>
    </table>


    <!-- Modal -->
    <div class="modal fade uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-modal="true"
        role="dialog" 
        data-controller="file-upload-modal" 
        data-file-upload-target="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">上傳檔案</h4>
                    <button type="button" aria-label="Close" data-action="click->file-upload-modal#close">
                        <span class="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="files-block">
                        <input class="form-control" type="file" name="files" multiple>
                    </div>


                    <span class="formMethod hidden"></span>
                    <span class="formAction hidden"></span>
                    <span class="urlParameters hidden"></span>
                    <span class="elementName hidden"></span>
                    <span class="fileCount hidden"></span>
                    <span class="acceptedFiles hidden"></span>
                    <span class="maxFileSize hidden"></span>
                    <span class="maxFiles hidden"></span>
                    <span class="thisId hidden"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-action="click->file-upload-modal#close">關閉</button>
                    <button type="button" class="btn btn-default" data-action="click->file-upload-modal#saveFile">確認</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="display: none;"></div>

</div>
@endcomponent
