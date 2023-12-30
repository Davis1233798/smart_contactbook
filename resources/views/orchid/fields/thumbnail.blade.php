@component($typeForm, get_defined_vars())
    <div data-controller="thumbnail"
         data-thumbnail-value="{{ $attributes['value'] }}"
         data-thumbnail-storage="{{ $storage ?? config('platform.attachment.disk', 'public') }}"
         data-thumbnail-target="{{ $target }}"
         data-thumbnail-url="{{ $url }}"
         data-thumbnail-groups="{{$attributes['groups'] ?? ''}}"
         data-thumbnail-path="{{ $attributes['path'] ?? '' }}"
         data-thumbnail-width="{{ $width }}"
         data-thumbnail-height="{{ $height }}"
         data-thumbnail-type="{{ $type }}"
         data-thumbnail-rounded="{{ $rounded }}"
         data-thumbnail-alt="{{ $alt }}"
         data-thumbnail-float="{{ $float }}"
         data-thumbnail-is-empty="{{ $isEmpty }}"
         data-thumbnail-gallery="{{ $gallery }}"
    >

        @php
            $url = empty($attributes['value']) ? $url : $attributes['value'];

            $ext = "";
            $isImage = "N";
            $allowed = array('jpg', 'jpeg', 'bmp', 'png');
            $pathInfo = pathinfo($url);
            // debug($pathInfo);

            if (array_key_exists('extension', $pathInfo)) {
                $ext = $pathInfo['extension'];

                if (in_array($ext, $allowed)) {
                    $isImage = "Y";
                }
            } else if ($isEmpty=="yes") {
                $isImage = "Y";
            }

        @endphp

        @if ( $isImage == "N" )
        <a href="{{ $url }}"  target='_blank'>
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEkAAABFCAYAAAAGscunAAAACXBIWXMAABJ0AAASdAHeZh94AAAF92lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDggNzkuMTY0MDM2LCAyMDE5LzA4LzEzLTAxOjA2OjU3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoTWFjaW50b3NoKSIgeG1wOkNyZWF0ZURhdGU9IjIwMjMtMDEtMTNUMDU6MTE6MTErMDg6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIzLTAxLTEzVDA1OjIwOjI2KzA4OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIzLTAxLTEzVDA1OjIwOjI2KzA4OjAwIiBkYzpmb3JtYXQ9ImltYWdlL3BuZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgcGhvdG9zaG9wOklDQ1Byb2ZpbGU9InNSR0IgSUVDNjE5NjYtMi4xIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjhlNGFjMTY3LTIxNTctNDc1Yy1iODBlLTQ1OGViNDM5MWFmNCIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmM4MGYwOTU2LWRhOGEtNTU0ZC1iYzZlLWI2MDk0YTJlYzU4ZiIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjRkMjBiZTBmLWZkOTYtNDhhZS05MmVkLTk5NGRkZDBmMWFlZCI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NGQyMGJlMGYtZmQ5Ni00OGFlLTkyZWQtOTk0ZGRkMGYxYWVkIiBzdEV2dDp3aGVuPSIyMDIzLTAxLTEzVDA1OjExOjExKzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoTWFjaW50b3NoKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6OGU0YWMxNjctMjE1Ny00NzVjLWI4MGUtNDU4ZWI0MzkxYWY0IiBzdEV2dDp3aGVuPSIyMDIzLTAxLTEzVDA1OjIwOjI2KzA4OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgMjEuMCAoTWFjaW50b3NoKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4/3rELAAAHjUlEQVR4nO2cT2wU1x3HP29mZ9f22sY2xoBIsBGtKVQKlZDNARucFGRMaSL1RpUQJKQ6CA5tRWmKxAVE2+QCpBJ/1H+quPQCAYVKPZW/l4ZISOVQlVSyVUys2F4b7LXXO7M7vx52195dZta79oyJrf1IozXvvXnvzZc3v9/7O0pEKFMY7VVXYClQFqkIyiIVQVmkIgg4BSqlXG8Qkc3AXqAhHRQGgsBzQAcmgDFgBBhO/74AYoAJJAAbkPQ1U2ymiPSvDdhKKbu0R5o/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" style="width:60px;"    
                alt='{{ $alt }}'
                class='mw-100 d-block small preview'>
        </a>
        @else
        <a style="cursor: {{ $isEmpty == 'yes' ? 'default': 'zoom-in' }}" data-action="thumbnail#showImage" href="#">
            @if($type === 'fluid')
                <img class="thumbnail img-fluid {{ $rounded ? 'rounded': '' }} {{ $float ? "float-{$float}" : '' }}"
                     style="max-width:100%;height:auto;"
                     alt="{{ $alt }}"
                     src="{{ $url }}">
            @elseif($wsrv)
                <img class="thumbnail img-thumbnail {{ $rounded ? 'rounded': '' }} {{ $float ? "float-{$float}" : '' }}"
                     style="width:{{ $width }};height:{{$height}};"
                     alt="{{ $alt }}"
                     src="//wsrv.nl/?url={{ $url }}&w={{ $width }}&h={{ $height }}&fit=cover">
            @else
                <img class="thumbnail img-thumbnail {{ $rounded ? 'rounded': '' }} {{ $float ? "float-{$float}" : '' }}"
                     style="width:{{ $width }};height:{{$height}};"
                     alt="{{ $alt }}"
                     src="{{ $url }}">
            @endif
        </a>
        @endif
    </div>
@endcomponent
