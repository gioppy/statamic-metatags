@extends('statamic::layout')
@section('title', 'Meta tags')

@section('content')
    <ui-header icon='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="1.5"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M20 12V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H11M8 10h8M8 6h4m-4 8h3m9.5 6.5L22 22"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M15 18a3 3 0 1 0 6 0 3 3 0 0 0-6 0"/><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M16 5.4V2.354a.354.354 0 0 1 .604-.25l3.292 3.292a.353.353 0 0 1-.25.604H16.6a.6.6 0 0 1-.6-.6"/></svg>' title="Meta tags"></ui-header>

    <ui-empty-state-menu heading="Manage and customize all meta tags">
        <ui-empty-state-item icon="setting-cog-gear" heading="Common settings" description="Enable global meta tags you really need." href="{{ cp_route('metatags.settings') }}"></ui-empty-state-item>
        <ui-empty-state-item icon="forms" heading="Default values" description="Set the default values for the meta tags you have activated." href="{{ cp_route('metatags.defaults') }}"></ui-empty-state-item>
        <ui-empty-state-item icon="blueprints" heading="Blueprints" description="Configure meta tags for each content blueprint." href="{{ cp_route('metatags.blueprints') }}"></ui-empty-state-item>
    </ui-empty-state-menu>
@endsection
