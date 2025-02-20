@extends('layouts-admin')

@section('content')
@if (Auth::check())
    <p>Halo, {{ Auth::user()->name }}! Anda sedang login.</p>
@else
    <p>Silakan login terlebih dahulu.</p>
@endif
@endsection

