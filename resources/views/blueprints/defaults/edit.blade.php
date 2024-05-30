@extends('statamic::layout')
@section('title', $title)

@section('content')
  <div class="flex">
    <a href="{{ cp_route('metatags.blueprints') }}" class="flex-initial flex p-2 -m-2 items-center text-xs text-gray-700 dark:text-dark-175 hover:text-gray-900 dark:hover:text-dark-100">
      <div class="h-6 svg-icon using-svg">
        <svg-icon name="micro/chevron-right" class="h-6 w-4 rotate-180" />
      </div>
      <span>{{ __('Blueprints') }}</span>
    </a>
  </div>
  <publish-form
    title="{{ $title }}"
    action="{{ $action }}"
    :blueprint='@json($blueprint)'
    :meta='@json($meta)'
    :values='@json($values)'
  ></publish-form>
@endsection
