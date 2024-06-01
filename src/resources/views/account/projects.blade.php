@extends('seat-pi::account.layouts.projects', ['viewname' => 'projects'])

@section('page_header', trans('seat-pi::account.page.header'))

@section('seat-projects-right')
    @if(!isset($project))
        @include('seat-pi::account.overview')
    @else
        @include('seat-pi::includes.project.view')
    @endif
@endsection
