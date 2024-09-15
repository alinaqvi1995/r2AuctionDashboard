@extends('emails.partials.layouts.app')

@section('content')
    <h1>Hello, {{ $user->full_name ?: $user->name . ' ' . $user->last_name }}</h1>
    <p>Your New Product is Now Live! Start Selling and Boost Your Sales Today!.</p>
@endsection
