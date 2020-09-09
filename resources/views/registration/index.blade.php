@extends('layouts.app')
@section('title', 'Anmeldung')

@section('content')
    <livewire:register-component :events="$events" :hasCookie="$hasCookie" :user="$user"/>
@endsection
