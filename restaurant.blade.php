@extends('layouts.apps')
@section('content')
    <div class="container">
        <div class="aside maxheight">
            <!-- box begin -->
            <div class="box maxheight">
                <div class="inner">
                    <h3>Menu</h3>
                    <ul class="list3">
                        @foreach($menus as $menu)
                        <li class="menu-list {{ (($loop->first) ? 'selected': '') }}"><a href="javascript:void(0)" id="{{$menu->id}}">{{ $menu->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- box end -->
        </div>
        <div class="content">
            <div class="indent">
                <h2>Today’s featured menu item</h2>
                @foreach($restaurants as $restaurant)
                <div class="restaurant-menu" data-id="{{ $restaurant->menu_id}}">
                    <img class="img-indent png alt" alt="" src="{{ asset('images/'.$restaurant->image)}}" />
                    <div class="extra-wrap">
                        <h5>{{ $restaurant->title }}</h5>
                        <p>{{ $restaurant->description }}</p>
                        <div class="aligncenter"><strong class="txt2">AS LOW AS ${{ $restaurant->price }}!</strong></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <style>
        .restaurant-menu {
            display:none;
        }
        li.selected > a {
            color: #c30000 !important
        }
    </style>
    <script>
        $(document).ready(function() {
            var selectedVal = $(".menu-list.selected > a").attr('id');
            $(".restaurant-menu").hide();
            $(".restaurant-menu[data-id='" + selectedVal + "']").show();
            
            $(".menu-list").click(function() {
                $(".menu-list").removeClass('selected');
                $(this).addClass('selected');
                var element = $(this).children('a').attr('id');
                $(".restaurant-menu").hide();
                $(".restaurant-menu[data-id='" + element + "']").show();
            });
        });
    </script>
@endsection
