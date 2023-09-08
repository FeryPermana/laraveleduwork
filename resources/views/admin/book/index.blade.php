@extends('layouts.admin')
@section('header', 'Book')
@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-5 offset-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text"
                        class="form-control"
                        autocomplete="off"
                        placeholder="Search from title"
                        v-model="search">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary"
                    @click="addData()">Create New Book</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12"
                v-for="book in filteredList">
                <div class="info-box"
                    v-on:click="editData(book)">
                    <div class="info-box-content">
                        <span class="info-box-text">@{{ book.title }} ( @{{ book.qty }} )</span>
                        <span class="info-box-number">Rp.@{{ numberWithSpace(book.price) }},-<small></small></span>
                    </div>
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
                        @submit="submitForm($event, book.id)">
                        <div class="modal-header">
                            <h4 class="modal-title">Book</h4>
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
                                <label for="">ISBN</label>
                                <input type="number"
                                    class="form-control"
                                    name="isbn"
                                    :value="book.isbn"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text"
                                    class="form-control"
                                    name="title"
                                    :value="book.title"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Year</label>
                                <input type="number"
                                    class="form-control"
                                    name="year"
                                    :value="book.year"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Publisher</label>
                                <select name="publisher_id"
                                    class="form-control">
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}"
                                            :selected="book.publisher_id == {{ $publisher->id }}">{{ $publisher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pengarang</label>
                                <select name="author_id"
                                    class="form-control">
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Katalog</label>
                                <select name="catalog_id"
                                    class="form-control">
                                    @foreach ($catalogs as $catalog)
                                        <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Qty Stock</label>
                                <input type="number"
                                    class="form-control"
                                    name="qty"
                                    :value="book.qty"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Pinjam</label>
                                <input type="number"
                                    class="form-control"
                                    name="price"
                                    :value="book.price"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button"
                                class="btn btn-danger"
                                v-if="editStatus"
                                v-on:click="deleteData(book.id)">Delete</button>
                            <button type="submit"
                                class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var actionUrl = '{{ url('/books') }}';
        var apiUrl = '{{ url('/api/books') }}';

        var controller = new Vue({
            el: '#controller',
            data: {
                books: [],
                search: '',
                book: {},
                actionUrl,
                editStatus: false
            },
            mounted: function() {
                this.get_books();
            },
            methods: {
                get_books() {
                    const _this = this;
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        success: function(data) {
                            _this.books = JSON.parse(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                addData() {
                    this.book = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(book) {
                    this.book = book;
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                numberWithSpace(number) {
                    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                },
                deleteData(id) {
                    if (confirm('Are you sure')) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            location.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        location.reload();
                    });
                },
            },
            computed: {
                filteredList() {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                }
            }
        });
    </script>
@endpush
