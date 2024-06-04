@extends('statamic::layout')
@section('title', 'Defaults Meta tags')

@section('content')
  @if($blueprint['empty'])
    <h1>{{ __('Defaults') }}</h1>
    <p>No default fields found!</p>
  @else
    <publish-form
      title="{{ $title }}"
      action="{{ $action }}"
      :blueprint='@json($blueprint)'
      :meta='@json($meta)'
      :values='@json($values)'
    ></publish-form>
  @endif
@endsection
