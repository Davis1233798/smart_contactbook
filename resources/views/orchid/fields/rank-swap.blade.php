@component($typeForm, get_defined_vars())
    <div class="rank-swap"
         data-controller="rank-swap"
         data-rank-swap-field-name="{{ is_string($name) ? $name : '' }}"
         data-rank-swap-old-rank="{{ $rank }}"
         data-rank-swap-new-rank="{{ $rank }}"
         data-rank-swap-model-id="{{ $modelId }}"
         data-rank-swap-form-method="{{ $formMethod }}"
         data-rank-swap-form-action="{{ $formAction }}"
         data-rank-swap-auto-submit="{{ $autoSubmit }}"
    >
        <a href="#" class="rank-btn" data-action="rank-swap#swapUp">
            <sup>↑</sup>
        </a>

        <span class="rank-no"></span>
        <input class="col-model-id" type="hidden" value="{{ $modelId }}">
        <input class="col-rank-no" type="hidden" value="{{ $rank }}">

        <a href="#" class="rank-btn" data-action="rank-swap#swapDown">
            <sub>↓</sub>
        </a>
    </div>
@endcomponent
