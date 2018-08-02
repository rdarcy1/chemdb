@extends('layouts.master')

@section('content')
    @forelse($chemicals as $chemical)
        <img src="{{ asset('molfiles/svg/'. $chemical->structure->id .'.svg') }}">
        {{ $chemical->name }}
        {{ $chemical->quantity }}
    @empty
    no results
    @endforelse

@endsection