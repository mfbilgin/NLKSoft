@extends('layouts.app')
@section('title','Home Page')
@section('content')
    <h1>Anasayfa</h1>
    @if(session('user'))
    <?php $user = session('user');?>
        <h2>Hoşgeldin {{ $user->name }}</h2>
    @endif
@endsection
