@extends('emails.partials.layouts.app')

@section('content')
    <p>Dear {{ $userName }},</p>
    <p>Your password has been successfully updated! 🔐 For your security, please remember to use your new password the next time you log in.</p>
@endsection