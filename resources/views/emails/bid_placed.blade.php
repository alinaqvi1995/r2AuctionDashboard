@extends('emails.partials.layouts.app')

@section('content')
    <h1>Hello, {{ $user->full_name ?: $user->name . ' ' . $user->last_name }}</h1>
    <p>Your bid has been successfully placed!</p>
    <p>Thank you for your participation in the auction.</p>
@endsection
