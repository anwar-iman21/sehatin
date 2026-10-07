@extends('admin.layouts.app')
@section('title', 'Edit Penyakit')
@section('page-title', 'Edit Penyakit')
@section('content')
@include('admin.penyakit._form', ['isEdit' => true, 'disease' => $disease])
@endsection
