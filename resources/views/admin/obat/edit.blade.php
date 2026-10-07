@extends('admin.layouts.app')
@section('title', 'Edit Obat')
@section('page-title', 'Edit Obat')
@section('content')
@include('admin.obat._form', ['isEdit' => true, 'drug' => $drug])
@endsection
