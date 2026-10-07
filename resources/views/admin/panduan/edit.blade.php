@extends('admin.layouts.app')
@section('title', 'Edit Panduan')
@section('page-title', 'Edit Panduan')
@section('content')
@include('admin.panduan._form', ['isEdit' => true, 'guide' => $guide])
@endsection
