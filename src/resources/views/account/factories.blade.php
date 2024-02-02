@extends('seat-pi::account.layouts.view', ['viewname' => 'factories'])

@section('page_header', trans('seat-pi::account.page.header'))

@section('seat-pi-content')
    @include('seat-pi::includes.factories')
@endsection

