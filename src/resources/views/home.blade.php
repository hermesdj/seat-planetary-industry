@extends('seat-pi::account.layouts.view')

@section('page_header', trans('seat-pi::account.page.header'))

@section('seat-pi-content')
    @include('seat-pi::account.includes.extractors')
@endsection