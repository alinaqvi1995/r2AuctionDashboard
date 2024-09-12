@extends('emails.partials.layouts.app')

@section('content')
    <h1>Hello, {{ $name }}</h1>
    <p>Your password has been successfully changed.</p>
@endsection
