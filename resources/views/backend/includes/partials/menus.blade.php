<?php

use App\Http\Controllers\Backend\MenusController;

$this->menuController = new MenusController;
$menus = $this->menuController->getMenus(App::getLocale());
//dd(count($menus));
?>
@if(count($menus)>0)
    <li class="nav-title">
        @lang('menus.backend.sidebar.menu')
    </li>
    @foreach ($menus['lv1'] as $menu)
        <li class="nav-item nav-dropdown">
            <a class="nav-link  {{($menu->route)? "": "nav-dropdown-toggle" }} "
               href="{{($menu->route)? route($menu->route): "#" }}">
                <i class="{{$menu->icon}}"></i>
                {{ $menu->title }}
            </a>
            @foreach ($menu->lv2 as $menulv2)
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="padding: 0 0 0 32px;">
                        <a href="{{($menulv2->route)? route($menulv2->route): "#" }}" class="nav-link">
                            <i class="{{$menulv2->icon}}">
                            </i>
                            {{ $menulv2->title }}
                        </a>
                    </li>
                </ul>
            @endforeach
        </li>
    @endforeach
@endif
