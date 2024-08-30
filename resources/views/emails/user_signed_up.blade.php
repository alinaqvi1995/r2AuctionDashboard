@extends('emails.partials.layouts.app')

@section('content')
    <p>Dear {{ $userName }},</p>
    <p>Welcome to {{ config('app.name') }}! 🎉 Your journey starts here. We’re excited to have you on board, let's set things up so you
        can hit the ground running!</p>
@endsection