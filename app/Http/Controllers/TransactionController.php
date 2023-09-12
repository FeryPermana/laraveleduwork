<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderBy('date_start', 'asc')->get();

        return view('admin.transaction.index', compact('transactions'));
    }

    public function api(Request $request)
    {
        $transactions = Transaction::with('member', 'transaction_details.book')->withSum('transaction_details', 'qty')
            ->filter(request())
            ->get();

        $datatables = datatables()->of($transactions)
            ->addColumn('date_start', function ($transaction) {
                return format_tanggal($transaction->date_start);
            })
            ->addColumn('date_end', function ($transaction) {
                return format_tanggal($transaction->date_end);
            })
            ->addColumn('range_date', function ($transaction) {
                return hitungRangeTanggal($transaction->date_start, $transaction->date_end);
            })
            ->addColumn('member_name', function ($transaction) {
                return $transaction->member->name;
            })
            ->addColumn('price', function ($transaction) {
                $price = [];
                foreach ($transaction->transaction_details as $transactiondetail) {
                    $price[] = $transactiondetail->qty * $transactiondetail->book->price;
                }
                return array_sum($price);
            })
            ->addColumn('status', function ($transaction) {
                if ($transaction->status == "1") {
                    return "Kembali";
                } else if ($transaction->status == "2") {
                    return "Belum Kembali";
                } else {
                    return "Terlambat";
                }
            })
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        $books = Book::where('qty', '!=', 0)->get();
        $url = route('transactions.store');
        $method = "store";

        $data = [
            'members' => $members,
            'books' => $books,
            'url' => $url,
            'method' => $method
        ];

        return view('admin.transaction._form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'book_id' => 'required',
            'status' => 'required'
        ]);

        $book = Book::where('id', $request->book_id)->first();
        Book::where('id', $request->book_id)->update([
            'qty' => $book->qty - 1,
        ]);

        $transaction = new Transaction();
        $transaction->member_id = $request->member_id;
        $transaction->date_start = $request->date_start;
        $transaction->date_end = $request->date_end;
        $transaction->status = $request->status;
        $transaction->save();

        $transactionDetail = new TransactionDetail();
        $transactionDetail->transaction_id = $transaction->id;
        $transactionDetail->book_id = $request->book_id;
        $transactionDetail->qty = 1;
        $transactionDetail->save();

        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction = Transaction::find($transaction->id);
        return view('admin.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $transaction = Transaction::find($transaction->id);
        $members = Member::all();
        $books = Book::where('qty', '!=', 0)->get();
        $url = route('transactions.update', $transaction->id);
        $method = "update";

        $data = [
            'members' => $members,
            'books' => $books,
            'url' => $url,
            'method' => $method,
            'transaction' => $transaction
        ];

        return view('admin.transaction._form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'member_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'book_id' => 'required',
            'status' => 'required'
        ]);

        $transaction = Transaction::find($transaction->id);
        $transaction->member_id = $request->member_id;
        $transaction->date_start = $request->date_start;
        $transaction->date_end = $request->date_end;
        $transaction->status = $request->status;
        $transaction->save();

        if ($request->status == '1') {
            foreach ($transaction->transaction_details as $transaction_details) {
                $book = Book::where('id', $transaction_details->book_id)->first();
                Book::where('id', $transaction_details->book_id)->update([
                    'qty' => $book->qty + 1,
                ]);
            }
        } else {
            foreach ($transaction->transaction_details as $transaction_details) {
                $book = Book::where('id', $transaction_details->book_id)->first();
                Book::where('id', $transaction_details->book_id)->update([
                    'qty' => $book->qty - 1,
                ]);
            }
        }

        $transaction->transaction_details[0]->update([
            'transaction_id' => $transaction->id,
            'book_id' => $request->book_id,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        foreach ($transaction->transaction_details as $transaction_details) {
            if ($transaction->status == "1") {
                $book = Book::where('id', $transaction_details->book_id)->first();
                Book::where('id', $transaction_details->book_id)->update([
                    'qty' => $book->qty,
                ]);
            } else {
                $book = Book::where('id', $transaction_details->book_id)->first();
                Book::where('id', $transaction_details->book_id)->update([
                    'qty' => $book->qty + 1,
                ]);
            }
        }
        $transaction->transaction_details()->delete();
        $transaction->delete();
    }
}
