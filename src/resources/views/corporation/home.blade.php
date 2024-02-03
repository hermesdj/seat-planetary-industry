@extends('seat-pi::corporation.layouts.projects', ['viewname' => 'corporation-home'])
@section('title', trans('seat-pi::corporation.page.title', ['name' => $corporation->name]))