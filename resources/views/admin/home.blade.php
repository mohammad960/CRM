@extends('admin.home.app')

@section('topnav')
<header class="dash-toolbar">


    <div class="main-label">
       Home Page
    </div>
    <div class="tools">
         @include('notification')
         @include('admin.home.header')
    </div>
</header>
@endsection

@section('main')

                <p class="p1">Overview</p>

                <div class="hotlinks">
                    @include('hotlink', ['title'=>"Clients",  'key'=>"Total Clients",       'value'=>$client,   'link'=>"/admin/client", 'color'=>""])
                    @include('hotlink', ['title'=>"Projects", 'key'=>"Current Projects",    'value'=>$project,    'link'=>"/admin/project", 'color'=>""])
                    @include('hotlink', ['title'=>"Won",      'key'=>"Winning Projects",    'value'=>$win,    'link'=>"/admin/project", 'color'=>"success"])
                    @include('hotlink', ['title'=>"Lost",     'key'=>"Lost Projects",       'value'=>$lost,     'link'=>"/admin/project", 'color'=>"danger"])
                </div>

                <p class="p1" style="margin-top: 24px">Win or Lost Projects</p>
                <div class="project-diagram">

                </div>
@endsection
