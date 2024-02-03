@extends('seat-pi::corporation.layouts.view', ['viewname' => $viewname])

@section('page_header', trans('seat-pi::corporation.page.title', ['name' => $corporation->name]))

@section('seat-pi-content')
    <div class="row">
        <div class="col col-md-3">
            @include('seat-pi::includes.project.project-list', ['displayedProject' => $project ?? null])
        </div>
        <div class="col col-md-9">
            @yield('seat-projects-right')
        </div>
    </div>
@endsection
