@if (array_key_exists('role', $item))
    @if ($item['role'] === Auth::user()->roles[0]->slug)
        <li @isset($item['id']) id="{{ $item['id'] }}" @endisset
            class="nav-header {{ $item['class'] ?? '' }}">

            {{ is_string($item) ? $item : $item['header'] }}

        </li>
    @endif
@else
    <li @isset($item['id']) id="{{ $item['id'] }}" @endisset
        class="nav-header {{ $item['class'] ?? '' }}">

        {{ is_string($item) ? $item : $item['header'] }}

    </li>
@endif
