@extends('statamic::layout')
@section('title', 'Defaults Meta tags')

@section('content')
  <publish-form
    title="{{ $title }}"
    action="{{ $action }}"
    :blueprint='@json($blueprint)'
    :meta='@json($meta)'
    :values='@json($values)'
  ></publish-form>
@endsection
