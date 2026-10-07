@extends('admin.layouts.app')
@section('title', 'Tambah Obat')
@section('page-title', 'Tambah Obat')
@section('content')
@include('admin.obat._form', ['isEdit' => false, 'drug' => null])
@endsection
