@extends('seat-pi::account.layouts.view', ['viewname' => $viewname])

@section('page_header', trans('seat-pi::account.page.header'))

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
