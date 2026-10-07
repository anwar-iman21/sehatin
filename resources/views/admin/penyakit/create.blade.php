@extends('admin.layouts.app')
@section('title', 'Tambah Penyakit')
@section('page-title', 'Tambah Penyakit')
@section('content')
@include('admin.penyakit._form', ['isEdit' => false, 'disease' => null])
@endsection
