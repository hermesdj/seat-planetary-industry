@extends('seat-pi::account.layouts.projects', ['viewname' => 'projects'])

@section('page_header', trans('seat-pi::account.page.header'))

@section('seat-projects-right')
    @if(!isset($project))
        <div class="row">
            <div class="col-6 mx-auto text-center">
                No Project Selected !
            </div>
        </div>
    @else
        @include('seat-pi::includes.project.view')
    @endif
@endsection
