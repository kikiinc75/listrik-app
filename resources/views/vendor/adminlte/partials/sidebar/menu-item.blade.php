@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@if ($sidebarItemHelper->isHeader($item))
    {{-- Header --}}
    @include('adminlte::partials.sidebar.menu-item-header')
@elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))
    {{-- Search form --}}
    @include('adminlte::partials.sidebar.menu-item-search-form')
@elseif ($sidebarItemHelper->isMenuSearch($item))
    {{-- Search menu --}}
    @include('adminlte::partials.sidebar.menu-item-search-menu')
@elseif ($sidebarItemHelper->isSubmenu($item))
    {{-- Treeview menu --}}
    @include('adminlte::partials.sidebar.menu-item-treeview-menu')
@elseif ($sidebarItemHelper->isLink($item))
    @if (array_key_exists('role', $item))
        @if ($item['role'] === Auth::user()->roles[0]->slug)
            {{-- Link --}}
            @include('adminlte::partials.sidebar.menu-item-link')
        @endif
    @else
        {{-- Link --}}
        @include('adminlte::partials.sidebar.menu-item-link')
    @endif
@endif
