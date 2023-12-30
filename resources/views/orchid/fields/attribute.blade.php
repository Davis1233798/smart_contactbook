@component($typeForm, get_defined_vars())
<!-- 預設範本 -->
<div data-controller="attribute"
    data-attribute-form-method="{{ $formMethod }}"
    data-attribute-form-action="{{ $formAction }}">
<div class="row attribute-default-template">
    <div class="col-12 col-md-2 left">
        <button class="btn btn-block fs-5 add-row" data-action="attribute#addRow">
            <x-orchid-icon path="plus-alt"/>
            新增參數
        </button>
    </div>
    <div class="col-12 col-md-10 right">
        <div class="form-group mb-0">
            <button class="btn btn-secondary" data-action="attribute#callTemplate1">
                範本 1
            </button>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-secondary" data-action="attribute#callTemplate2">
                範本 2
            </button>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-secondary" data-action="attribute#callTemplate3">
                範本 3
            </button>
        </div>
    </div>
</div>

<!-- 機器參數 -->
<div class="row mt-4">
    <div class="col-12">
        <table class="table attribute-list">
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- 回寫範本 -->
<div class="row mt-4 attribute-restore-template">
    <div class="col-12 col-md-8 left">
        <div class="form-group mb-0">
            <button class="btn btn-default" data-action="attribute#saveTemplate1">
                <x-orchid-icon path="plus-alt"/>    
                儲存為範本 1
            </button>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-default" data-action="attribute#saveTemplate2">
                <x-orchid-icon path="plus-alt"/>    
                儲存為範本 2
            </button>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-default" data-action="attribute#saveTemplate3">
                <x-orchid-icon path="plus-alt"/>    
                儲存為範本 3
            </button>
        </div>
    </div>
    <div class="col-6 col-md-4"></div>
</div>
</div>
@endcomponent
