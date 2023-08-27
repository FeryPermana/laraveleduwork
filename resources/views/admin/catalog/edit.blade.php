@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Ubah Catalog</h3>
                <a href="{{ route('catalogs.index') }}"
                    class="btn btn-primary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('catalogs.update', $catalog->id) }}"
                method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name"
                        class="form-label">Nama</label>
                    <input type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        id="name"
                        value="{{ old('name', $catalog->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit"
                    class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
