@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Publisher</h3>
                <a href="{{ route('publishers.create') }}"
                    class="btn btn-primary">Tambah</a>
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
                        @foreach ($publishers as $key => $publisher)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $publisher->name }}</td>
                                <td>{{ $publisher->email }}</td>
                                <td>{{ $publisher->phone }}</td>
                                <td>{{ $publisher->address }}</td>
                                <td>{{ count($publisher->books) }}</td>
                                <td class="text-center">{{ date('H:i:s - d M Y', strtotime($publisher->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('publishers.edit', $publisher->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('publishers.destroy', $publisher->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        <input type="submit"
                                            class="btn btn-danger btn-sm"
                                            value="Delete"
                                            onclick="return confirm('Apakah kamu yakin ??')">
                                        @method('delete')
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
