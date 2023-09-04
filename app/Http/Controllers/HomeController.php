<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Catalog;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $members = Member::with('user)->get();
        // $books = Book::with('publisher')->get();
        // $publishers = Publisher::all();
        // no 1
        $data = Member::select('*')
            ->join('users', 'users.member_id', '=', 'members.id')
            ->get();

        $data2 = Member::select('*')
            ->leftJoin('users', 'users.member_id', '=', 'members.id')
            ->where('users.id', NULL)
            ->get();

        $data3 = Transaction::select('members.id', 'members.name')
            ->rightJoin('members', 'members.id', '=', 'transactions.member_id')
            ->where('transactions.member_id', NULL)
            ->get();

        $data4 = Member::select('members.id', 'members.name', 'members.phone_number')
            ->join('transactions', 'transactions.member_id', '=', 'members.id')
            ->orderBy('members.id', 'asc')
            ->get();

        $data5 = Member::select('members.id', 'members.name', 'members.phone_number')
            ->join('transactions', 'members.id', '=', 'transactions.member_id')
            ->groupBy('members.id', 'members.name', 'members.phone_number')
            ->havingRaw('COUNT(transactions.id) > 2')
            ->get();

        $data6 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->get();

        $data7 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->whereMonth('transactions.date_end', 6)
            ->get();

        $data7 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->whereMonth('transactions.date_end', 6)
            ->get();

        $data8 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->whereMonth('transactions.date_start', 5)
            ->get();

        $data9 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->whereMonth('transactions.date_start', 6)
            ->whereMonth('transactions.date_end', 6)
            ->get();

        $data10 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->where('members.address', 'LIKE', '%bandung%')
            ->get();

        $data11 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'members.gender', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->where('members.address', 'LIKE', '%bandung%')
            ->where('members.gender', '1')
            ->get();

        $data12 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'books.isbn', 'transaction_details.qty', 'members.gender', 'members.address', 'transactions.date_start', 'transactions.date_end')
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('books', 'books.id', '=', 'transaction_details.book_id')
            ->where('transaction_details.qty', '>', 1)
            ->get();

        $data13 = Transaction::select('members.id', 'members.name', 'members.phone_number', 'books.isbn', 'books.title', 'books.price', 'transaction_details.qty', 'members.gender', 'members.address', 'transactions.date_start', 'transactions.date_end', DB::raw('transaction_details.qty * books.price as total_harga'))
            ->join('members', 'members.id', '=', 'transactions.member_id')
            ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('books', 'books.id', '=', 'transaction_details.book_id')
            ->get();

        $data14 = Transaction::select(
            'members.name as member_name',
            'members.phone_number',
            'members.address',
            'transactions.date_start',
            'transactions.date_end',
            'books.isbn',
            'transaction_details.qty',
            'books.title',
            'publishers.name as publisher_name',
            'authors.name as author_name',
            'catalogs.name as catalog_name'
        )->join('members', 'members.id', '=', 'transactions.member_id')
            ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('books', 'transaction_details.book_id', '=', 'books.id')
            ->join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('catalogs', 'books.catalog_id', '=', 'catalogs.id')
            ->get();


        $data15 = Catalog::select('catalogs.name as catalog_name', 'books.title as book_title')
            ->join('books', 'catalogs.id', '=', 'books.catalog_id')
            ->get();

        $data16 = Book::leftJoin('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->select('books.*', 'publishers.name as publisher_name')
            ->get();

        $data17 = Author::join('books', 'authors.id', '=', 'books.author_id')
            ->where('authors.name', 'PG05')
            ->count();

        $data18 = Book::where('price', '>', '10000')
            ->get();

        $data19 = Book::join('publishers', 'books.publisher_id', '=', 'publishers.id')
            ->where('publishers.name', 'Penerbit 01')
            ->where('books.qty', '>', 10)
            ->get();

        $data20 = Member::whereMonth('created_at', 6)
            ->whereYear('created_at', date('Y'))
            ->get();
        return view('home');
    }
}
