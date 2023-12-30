@component($typeForm, get_defined_vars())
    <div data-controller="select-ex" data-action="select-ex:changed@window->select-ex#filterOptions"
        data-select-ex-choices="{{ $filterableOptions ? json_encode($filterableOptions, true) : '[]' }}"
        data-select-ex-placeholder="{{ $attributes['placeholder'] ?? '' }}"
        data-select-ex-allow-empty="{{ var_export($allowEmpty, true) }}"
        data-select-ex-message-notfound="{{ __('No results found') }}"
        data-select-ex-allow-add="{{ var_export($allowAdd, true) }}" data-select-ex-message-add="{{ __('Add') }}"
        data-select-ex-readonly="{{ var_export($readonly, true) }}"
        data-select-ex-disabled-clear="{{ var_export($disabledClear, true) }}"
        data-select-ex-values="{{ $value ? json_encode($value, true) : '[]' }}"
        data-select-ex-locked="{{ $lockedOptions ? json_encode($lockedOptions, true) : '[]' }}"
        data-select-ex-locked-message="{{ $lockedMessage }}"
        data-select-ex-disabled="{{ $disabledOptions ? json_encode($disabledOptions, true) : '[]' }}">
        <select {{ $attributes }}>
            @foreach ($options as $key => $option)
                @if (is_array($value) && in_array($key, $value))
                    {{--
                        $key = 'b';
                        $value = ['a','b','c'];
                    --}}
                    <option value="{{ $key }}"
                        {{ in_array($key, array_values($disabledOptions)) ? 'disabled' : '' }} selected>
                        {{ $option }}</option>
                @elseif(isset($value[$key]) && $value[$key] == $option)
                    {{--
                        $key = 'b';
                        $value = ['a' => '甲','b' => '乙','c' => '丙'];
                    --}}
                    <option value="{{ $key }}"
                        {{ in_array($key, array_keys($disabledOptions)) ? 'disabled' : '' }} selected>{{ $option }}
                    </option>
                @elseif($key == $value)
                    {{--
                        $key = 'b';
                        $value = 'b';
                    --}}
                    <option value="{{ $key }}" selected>{{ $option }}</option>
                @else
                    <option value="{{ $key }}"
                        {{ in_array($key, array_values($disabledOptions)) ? 'disabled' : '' }}>{{ $option }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
@endcomponent
