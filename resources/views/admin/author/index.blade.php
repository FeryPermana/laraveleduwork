@extends('layouts.admin')
@section('header', 'Author')
@section('content')
    <div id="controller">
        <div class="card">
            <div class="card-header bg-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Author</h3>
                    <a href="#"
                        @click="addData()"
                        data-target="#modal-default"
                        data-toggle="modal"
                        class="btn btn-sm btn-primary pull-right">Tambah Author</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Alamat</th>
                            <th>Total Buku</th>
                            <th>Created At</th>
                            <th style="width: 130px;">Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($authors as $key => $author)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $author->name }}</td>
                                    <td>{{ $author->email }}</td>
                                    <td>{{ $author->phone }}</td>
                                    <td>{{ $author->address }}</td>
                                    <td>{{ count($author->books) }}</td>
                                    <td class="text-center">{{ date('H:i:s - d M Y', strtotime($author->created_at)) }}
                                    </td>
                                    <td>
                                        <a href="#"
                                            class="btn btn-warning btn-sm"
                                            @click="editData({{ $author }})">Edit</a>
                                        <a href="#"
                                            class="btn btn-danger btn-sm"
                                            @click="deleteData({{ $author->id }})">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
                        autocomplete="off">
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
        <script>
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
        </script>
    @endpush
@endsection
