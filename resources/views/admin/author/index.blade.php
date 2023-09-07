@extends('layouts.admin')
@section('header', 'Author')
@push('styles')
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assest/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-header bg-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Author</h3>
                    <a href="#"
                        @click="addData()"
                        class="btn btn-sm btn-primary pull-right">Tambah Author</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-author"
                        class="table table-bordered table-striped w-full">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Alamat</th>
                            <th style="width: 130px;">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade"
            id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post"
                        :action="actionUrl"
                        autocomplete="off"
                        @submit="submitForm($event, data.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Author</h4>
                            <button type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf

                            <input type="hidden"
                                name="_method"
                                value="PUT"
                                v-if="editStatus">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text"
                                    class="form-control"
                                    name="name"
                                    :value="data.name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email"
                                    class="form-control"
                                    name="email"
                                    :value="data.email"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Phone Number</label>
                                <input type="text"
                                    class="form-control"
                                    name="phone_number"
                                    :value="data.phone_number"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Address</label>
                                <input type="text"
                                    class="form-control"
                                    name="address"
                                    :value="data.address"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button"
                                class="btn btn-default"
                                data-dismiss="modal">Close</button>
                            <button type="submit"
                                class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script>
            var actionUrl = '{{ url('/authors') }}';
            var apiUrl = '{{ url('/api/authors') }}';

            var columns = [{
                    data: 'DT_RowIndex',
                    class: 'text-center',
                    orderable: true
                }, {
                    data: 'name',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'email',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'phone_number',
                    class: 'text-center',
                    orderable: true
                },
                {
                    data: 'address',
                    class: 'text-center',
                    orderable: true
                },
                {
                    render: function(index, row, data, meta) {
                        return `
                    <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a>
                    `;
                    },
                    orderable: false,
                    width: '200px',
                    class: 'text-center'
                },
            ];

            var controller = new Vue({
                el: '#controller',
                data: {
                    datas: [],
                    data: {},
                    actionUrl,
                    apiUrl,
                    editStatus: false,
                },
                mounted: function() {
                    this.datatable();
                },
                methods: {
                    datatable() {
                        const _this = this;
                        _this.table = $('#table-author').DataTable({
                            ajax: {
                                url: _this.apiUrl,
                                type: 'GET',
                            },
                            columns: columns
                        }).on('xhr', function() {
                            _this.datas = _this.table.ajax.json().data;
                        });
                    },
                    addData() {
                        this.data = {};
                        this.actionUrl = '{{ url('authors') }}';
                        this.editStatus = false;
                        $('#modal-default').modal();
                    },
                    editData(event, row) {
                        this.data = this.datas[row];
                        this.editStatus = true;
                        $('#modal-default').modal();
                    },
                    deleteData(event, id) {
                        if (confirm('Are you sure')) {
                            $(event.target).parents('tr').remove();
                            axios.post(this.actionUrl + '/' + id, {
                                _method: 'DELETE'
                            }).then(response => {
                                _this.table.ajax.reload();
                            });
                        }
                    },
                    submitForm(event, id) {
                        event.preventDefault();
                        const _this = this;
                        var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                        axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                            $('#modal-default').modal('hide');
                            _this.table.ajax.reload();
                        });
                    },
                }
            });
        </script>
        {{-- <script>
            var controller = new Vue({
                el: '#controller',
                data: {
                    data: {},
                    actionUrl: '{{ url('authors') }}',
                    editStatus: false
                },
                mounted: function() {

                },
                methods: {
                    addData() {
                        this.data = {};
                        this.actionUrl = '{{ url('authors') }}';
                        this.editStatus = false;
                        $('#modal-default').modal();
                    },
                    editData(data) {
                        this.data = data;
                        this.actionUrl = '{{ url('authors') }}' + '/' + data.id;
                        this.editStatus = true;
                        $('#modal-default').modal();
                    },
                    deleteData(id) {
                        this.actionUrl = '{{ url('authors') }}' + '/' + id;
                        if (confirm('Are you sure')) {
                            axios.post(this.actionUrl, {
                                _method: 'DELETE'
                            }).then(response => {
                                location.reload();
                            });
                        }
                    }
                },
            });

            $(document).ready(function() {
                $('#table-author').DataTable();
            });
        </script> --}}
    @endpush
@endsection
