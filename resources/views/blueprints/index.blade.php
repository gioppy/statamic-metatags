@extends('statamic::layout')
@section('title', 'Blueprints')

@section('content')
    <ui-header icon='blueprints' title="Blueprints"></ui-header>

    <ui-heading size="lg">{{ __('Collections') }}</ui-heading>
    <ui-listing :items='@json($collectionItems)' :columns='@json($collectionColumns)'>
        <template #cell-entity="{ row, value }">
            <div class="flex items-center gap-4">
                <ui-status-indicator :status="row.empty ? draft : published" :private="row.empty" />
                <ui-badge :text="value" pill />
            </div>
        </template>
        <template #prepended-row-actions="{ row: entry }">
            <ui-dropdown-item text="Settings" icon="setting-cog-gear" :href="cp_url('metatags/blueprints/'+entry.type+'/'+entry.entity+'/'+entry.name+'/settings')"></ui-dropdown-item>
            <ui-dropdown-item text="Defaults" icon="forms" :href="cp_url('metatags/blueprints/'+entry.type+'/'+entry.entity+'/'+entry.name+'/defaults')"></ui-dropdown-item>
        </template>
    </ui-listing>

    <ui-heading size="lg">{{ __('Taxonomies') }}</ui-heading>
    <ui-listing :items='@json($taxonomiesItems)' :columns='@json($taxonomiesColumns)'>
        <template #cell-entity="{ row, value }">
            <div class="flex items-center gap-4">
                <ui-status-indicator :status="row.empty ? draft : published" :private="row.empty" />
                <ui-badge :text="value" pill />
            </div>
        </template>
        <template #prepended-row-actions="{ row: entry }">
            <ui-dropdown-item text="Settings" icon="setting-cog-gear" :href="cp_url('metatags/blueprints/'+entry.type+'/'+entry.entity+'/'+entry.name+'/settings')"></ui-dropdown-item>
            <ui-dropdown-item text="Defaults" icon="forms" :href="cp_url('metatags/blueprints/'+entry.type+'/'+entry.entity+'/'+entry.name+'/defaults')"></ui-dropdown-item>
        </template>
    </ui-listing>
@endsection
