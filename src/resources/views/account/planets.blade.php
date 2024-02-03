@extends('seat-pi::account.layouts.view', ['viewname' => 'planets'])

@section('page_header', trans('seat-pi::account.page.header'))

@section('seat-pi-content')
    @include('seat-pi::account.includes.planets')
@endsection
