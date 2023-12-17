<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreBorrowRequest;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Borrow::with('car')->where('user_id', '=', auth()->user()->id)->get();
        return Inertia::render('Borrow/Index', [
            'borrows' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Borrow/Create', [
            'cars' => Car::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowRequest $request)
    {
        // check ketersediaan mobil
        $mobil = Car::find($request->car_id);
        if($mobil->ketersediaan > 0){

            // calculate total harga
            $sekarang = strtotime($request->tgl_mulai);
            $selesai = strtotime($request->tgl_selesai);
            $jarak = $selesai - $sekarang;
            $total = round($jarak/(60 * 60 * 24));

            Borrow::create([
                'user_id' => auth()->user()->id,
                'car_id' => $request->car_id,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'total_harga' => $mobil->harga_sewa * $total
            ]);

            $mobil->update([
                'ketersediaan' => $mobil->ketersediaan - 1
            ]);

        }

        return to_route('borrow.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $mobil = Car::find($borrow->car_id);
        if($mobil){

            // Update ketersediaan mobil
            $mobil->update([
                'ketersediaan' => $mobil->ketersediaan + 1
            ]);

            // menghapus data peminjaman
            $borrow->delete();
        }

        return to_route('borrow.index');
    }
}
