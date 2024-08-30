@extends('emails.partials.layouts.app')

@section('content')
    <p>Dear {{ $userName }},</p>
    <p>Welcome to {{ env('APP_NAME') }}! 🎉 Your journey starts here. We’re excited to have you on board, let's set things up so you
        can hit the ground running!</p>
@endsection
