@extends('indigo-layout::main')

@section('meta_title', _p('printer::pages.printer.meta_title', 'Printers') . ' - ' . config('app.name'))
@section('meta_description', _p('printer::pages.printer.meta_description', 'Printers in application'))

@push('head')

@endpush

@section('title')
    {{ _p('printer::pages.printer.headline', 'Printers') }}
@endsection

@section('create_button')
    <button class="frame__header-add" title="{{ _p('printer::pages.nodeprinter.add_printer', 'Add printer') }}" @click="AWEMA.emit('modal::add_printer:open')"><i class="icon icon-plus"></i></button>
@endsection

@section('content')
    <div class="grid">
        <div class="cell-1-1 cell--dsm">
            <h4>{{ _p('printer::pages.nodeprinter.printers', 'PrintNode printers') }}</h4>
            <div class="card">
                <div class="card-body">
                    <content-wrapper :url="$url.urlFromOnlyQuery('{{ route('printer.nodeprinter.scope')}}', ['page', 'limit'], $route.query)"
                        :check-empty="function(test) { return !(test && (test.data && test.data.length || test.length)) }"
                        name="printers_table">
                        <template slot-scope="table">
                            <table-builder :default="table.data">
                                <tb-column name="email" label="{{ _p('printer::pages.nodeprinter.email', 'E-mail') }}"></tb-column>
                                <tb-column name="name" label="{{ _p('printer::pages.nodeprinter.name', 'Name') }}"></tb-column>
                                <tb-column name="location" label="{{ _p('printer::pages.nodeprinter.location', 'Location') }}"></tb-column>
                                <tb-column name="created_at" label="{{ _p('printer::pages.nodeprinter.created_at', 'Created at') }}"></tb-column>
                                <tb-column name="manage" label="{{ _p('printer::pages.nodeprinter.options', 'Options')  }}">
                                    <template slot-scope="col">
                                        <context-menu right boundary="table">
                                            <button type="submit" slot="toggler" class="btn">
                                                {{_p('printer::pages.nodeprinter.options', 'Options')}}
                                            </button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'editPrinter', data: col.data}); AWEMA.emit('modal::edit_printer:open')">
                                                {{_p('printer::pages.nodeprinter.edit', 'Edit')}}
                                            </cm-button>
                                            <cm-button @click="AWEMA._store.commit('setData', {param: 'deletePrinter', data: col.data}); AWEMA.emit('modal::delete_printer:open')">
                                                {{_p('printer::pages.nodeprinter.delete', 'Delete')}}
                                            </cm-button>
                                        </context-menu>
                                    </template>
                                </tb-column>
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

    <modal-window name="add_printer" class="modal_formbuilder" title="{{ _p('printer::pages.nodeprinter.add_printer', 'Add printer') }}">
        <form-builder name="add_printer" url="{{ route('printer.nodeprinter.store') }}"
                      @sended="AWEMA.emit('content::printers_table:update')"
                      send-text="{{ _p('printer::pages.nodeprinter.add', 'Add') }}" disabled-dialog>
            <fb-input name="name" label="{{ _p('printer::pages.nodeprinter.name', 'Name') }}"></fb-input>
            <fb-input name="api_key" label="{{ _p('printer::pages.nodeprinter.api_key', 'API key') }}"></fb-input>

           <div class="mt-10" v-if="AWEMA._store.state.forms['add_printer']">
               <fb-select name="printer_id" :multiple="false" open-fetch options-value="id" options-name="name"
                          :url="'{{ route('printer.nodeprinter.select') }}?api_key=' + AWEMA._store.state.forms['add_printer'].fields.api_key"
                          placeholder-text=" " label="{{ _p('printer::pages.nodeprinter.search_printer', 'Search printer') }}">
               </fb-select>
           </div>
        </form-builder>
    </modal-window>

    <modal-window name="edit_printer" class="modal_formbuilder" title="{{ _p('printer::pages.nodeprinter.edit_printer', 'Edit printer') }}">
        <form-builder name="edit_printer" url="{{ route('printer.nodeprinter.update') }}/{id}" method="patch"
                      @sended="AWEMA.emit('content::printers_table:update')"
                      send-text="{{ _p('printer::pages.nodeprinter.save', 'Save') }}" store-data="editPrinter">
            <div v-if="AWEMA._store.state.editPrinter">
                <fb-input name="name" label="{{ _p('printer::pages.nodeprinter.name', 'Name') }}"></fb-input>
                <fb-input name="api_key" label="{{ _p('printer::pages.nodeprinter.api_key', 'API key') }}"></fb-input>
                <div class="mt-10" v-if="AWEMA._store.state.forms['edit_printer']">
                    <fb-select name="printer_id" :multiple="false" auto-fetch options-value="id" options-name="name"
                               :url="'{{ route('printer.nodeprinter.select') }}?api_key=' + AWEMA._store.state.forms['edit_printer'].fields.api_key"
                               placeholder-text=" " label="{{ _p('printer::pages.nodeprinter.search_printer', 'Search printer') }}"
                               :auto-fetch-name="AWEMA._store.state.editPrinter.location" :auto-fetch-value="AWEMA._store.state.editPrinter.printer.id">
                    </fb-select>
                </div>


            </div>
        </form-builder>
    </modal-window>

    <modal-window name="delete_printer" class="modal_formbuilder" title="{{  _p('printer::pages.nodeprinter.are_you_sure_delete', 'Are you sure delete?') }}">
        <form-builder :edited="true" url="{{route('printer.nodeprinter.destroy') }}/{id}" method="delete"
                      @sended="AWEMA.emit('content::printers_table:update')"
                      send-text="{{ _p('printer::pages.nodeprinter.confirm', 'Confirm') }}" store-data="deletePrinter"
                      disabled-dialog>

        </form-builder>
    </modal-window>
@endsection
