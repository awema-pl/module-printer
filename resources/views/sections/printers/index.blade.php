@extends('indigo-layout::main')

@section('meta_title', _p('printer::pages.printer.meta_title', 'All printers') . ' - ' . config('app.name'))
@section('meta_description', _p('printer::pages.printer.meta_description', 'All printers in application'))

@push('head')

@endpush

@section('title')
    {{ _p('printer::pages.printer.headline', 'All printers') }}
@endsection

@section('create_button')

@endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('printer::pages.printer.all_printers', 'All printers') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('printer.printer.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="printers_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="provider" label="{{ _p('printer::pages.printer.provider', 'Provider') }}">
                                    <template slot-scope="col">
                                        <span class="badge badge_grass">@{{ col.data.provider }}</span>
                                    </template>
                                </tb-column>
                                <tb-column name="printable" label="{{ _p('printer::pages.printer.name', 'Name') }}">
                                    <template slot-scope="col">
                                        @{{ col.data.printable.name }}
                                    </template>
                                </tb-column>
                                <tb-column name="created_at" label="{{ _p('printer::pages.printer.created_at', 'Created at') }}"></tb-column>
                            </table-builder>

                            <paginate-builder v-if="table.data"
                                :meta="table.meta"
                            ></paginate-builder>
                        </template>
                        @include('indigo-layout::components.base.loading')
                        @include('indigo-layout::components.base.empty')
                        @include('indigo-layout::components.base.error')
                    </content-wrapper>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

@endsection
