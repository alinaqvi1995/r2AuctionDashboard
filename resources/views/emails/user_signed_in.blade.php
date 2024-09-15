@extends('emails.partials.layouts.app')

@section('content')
    <p>Dear {{ $user->full_name ?: $user->name . ' ' . $user->last_name }},</p>
    <p>You just signed In!</p>
@endsection
