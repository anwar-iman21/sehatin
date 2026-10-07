@extends('admin.layouts.app')
@section('title', 'Tambah Panduan')
@section('page-title', 'Tambah Panduan')
@section('content')
@include('admin.panduan._form', ['isEdit' => false, 'guide' => null])
@endsection
