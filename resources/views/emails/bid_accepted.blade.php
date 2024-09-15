@extends('emails.partials.layouts.app')

@section('content')
    <h1>Hello, {{ $user->full_name ?: $user->name . ' ' . $user->last_name }}</h1>
    <p>Congratulations! Your bid has been accepted.</p>
    <p>Thank you for participating in the auction.</p>
@endsection
