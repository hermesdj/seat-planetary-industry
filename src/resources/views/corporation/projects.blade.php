@extends('seat-pi::corporation.layouts.projects', ['viewname' => 'projects'])

@section('page_header', trans('seat-pi::corporation.page.title', ['name' => $corporation->name]))

@section('seat-projects-right')
    @include('seat-pi::includes.project.view')
@endsection

