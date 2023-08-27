@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="my-5">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Catalog</h3>
                    </div>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-2 pr-md-0 mb-3 mb-md-0">
                        @php
                            $rows = [10, 50, 100, 500];
                        @endphp
                        <select name="row"
                            class="form-control custom-select"
                            onchange="this.form.submit()">
                            @foreach ($rows as $row)
                                <option value="{{ $row }}"
                                    {{ @$_GET['row'] == $row ? 'selected' : '' }}>
                                    {{ $row }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5 mb-3 ml-auto">
                        <div class="custom-search">
                            <input type="text"
                                class="form-control"
                                name="search"
                                placeholder="Cari nama..."
                                value="{{ @$_GET['search'] }}">
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Veritatis doloremque.</td>
                            <td>
                                <a href=""
                                    class="btn btn-warning">Edit</a>
                                <button type="button"
                                    class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
