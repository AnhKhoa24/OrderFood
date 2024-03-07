@extends('layouts.admin')

@section('content')
   CHÀO {{ Auth()->user()->name }}
    <br>
    {{ Auth()->user()->avt }}
@endsection

