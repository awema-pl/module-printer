@extends('indigo-layout::installation')

@section('meta_title', _p('printer::pages.installation.meta_title', 'Installation module Printer') . ' - ' . config('app.name'))
@section('meta_description', _p('printer::pages.installation.meta_description', 'Installation module Printer in application'))

@push('head')

@endpush

@section('title')
    <h2>{{ _p('printer::pages.installation.headline', 'Installation module Printer') }}</h2>
@endsection

@section('content')
    <form-builder disabled-dialog="" url="{{ route('printer.installation.index') }}" send-text="{{ _p('printer::pages.installation.send_text', 'Install') }}"
    edited>
        <div class="section">
            <div class="section">
                {{ _p('printer::pages.installation.will_be_execute_migrations', 'Will be execute package migrations') }}
            </div>
        </div>
    </form-builder>
@endsection
