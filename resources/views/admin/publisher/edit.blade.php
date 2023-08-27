@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Ubah Publisher</h3>
                <a href="{{ route('publishers.index') }}"
                    class="btn btn-primary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('publishers.update', $publisher->id) }}"
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
                        value="{{ old('name', $publisher->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email"
                        class="form-label">Email</label>
                    <input type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        value="{{ old('email', $publisher->email) }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number"
                        class="form-label">Phone</label>
                    <input type="text"
                        name="phone_number"
                        class="form-control @error('phone_number') is-invalid @enderror"
                        id="phone_number"
                        value="{{ old('phone_number', $publisher->phone_number) }}">
                    @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address"
                        class="form-label">Alamat</label>
                    <input type="text"
                        name="address"
                        class="form-control @error('address') is-invalid @enderror"
                        id="address"
                        value="{{ old('address', $publisher->address) }}">
                    @error('address')
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
