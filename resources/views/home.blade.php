@extends('layouts.app')

@section('content')
    @include('sections.hero')
    @include('sections.inicio')
    @include('sections.servicios', ['services' => $services])
    @include('sections.proyectos', ['galleries' => $galleries])
    @include('sections.contacto')
@endsection
