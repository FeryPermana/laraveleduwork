<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\select;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_anggota = Member::count();
        $total_buku = Book::count();
        $total_peminjaman = Transaction::whereMonth('date_start', date('m'))->count();
        $total_penerbit = Publisher::count();

        $data_donut = Book::select(DB::raw("COUNT(publisher_id) as total"))->groupBy('publisher_id')->orderBy('publisher_id', 'asc')->pluck('total');
        $label_donut = Publisher::orderBy('publishers.id', 'asc')->join('books', 'books.publisher_id', '=', 'publishers.id')->groupBy('publishers.name')->pluck('publishers.name');

        $data_donut2 = Book::select(DB::raw("COUNT(author_id) as total"))->groupBy('author_id')->orderBy('author_id', 'asc')->pluck('total');
        $label_donut2 = Author::orderBy('authors.id', 'asc')->join('books', 'books.author_id', '=', 'authors.id')->groupBy('authors.name')->pluck('authors.name');

        $label_bar = ['Peminjaman', 'Pengembalian'];
        $data_bar = [];

        foreach ($label_bar as $key => $value) {
            $data_bar[$key]['label'] = $label_bar[$key];
            $data_bar[$key]['backgroundColor'] = $key == 0 ? 'rgba(60,141,188,0.9)' : 'rgba(210,214,222,1)';
            $data_month = [];

            foreach (range(1, 12) as $month) {
                if ($key == 0) {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_start', $month)->first()->total;
                } else {
                    $data_month[] = Transaction::select(DB::raw("COUNT(*) as total"))->whereMonth('date_end', $month)->first()->total;
                }
            }

            $data_bar[$key]['data'] = $data_month;
        }

        return view('admin.dashboard', compact(
            'total_buku',
            'total_anggota',
            'total_peminjaman',
            'total_penerbit',
            'label_donut',
            'data_donut',
            'label_donut2',
            'data_donut2',
            'data_bar'
        ));
    }

    public function test_spatie()
    {
        // $role = Role::create(['name' => 'petugas']);
        // $permission = Permission::create(['name' => 'index peminjaman']);

        // $role->givePermissionTo($permission);
        // $permission->assignRole($role);

        // $user = auth()->user();
        // $user->assignRole('petugas');
        // return $user;

        // $user = User::where('id', 2)->first();
        // $user->assignRole('petugas');
        // return $user;

        // $user = User::with('roles')->get();
        // return $user;

        // $user = auth()->user();
        // $user->removeRole('petugas');
        // return $user;
    }
}
