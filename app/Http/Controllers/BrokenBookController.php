<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BrokenBook;
use App\Models\DamageType;
use Illuminate\Http\Request;

class BrokenBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.brokenBooks', [
            'damagedCollections' => BrokenBook::latest()->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('book.brokenBook_add', [
            'books' => book::orderBy('name')->get(),
            'damageTypes' => DamageType::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrokenBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'book_id' => 'required',
            'damage_type_id' => 'required',
            'description' => 'nullable|string',
            'damaged_quantity' => 'required|integer',
            'repair_cost' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'deduct_status' => 'nullable|string', // deduct 
        ]);

        BrokenBook::create($fields + [
            'reported_by' => auth()->id(),
            'damage_date' => now(),
        ]);

        if (isset($fields['deduct_status']) && $fields['deduct_status'] === 'deducted') {
            // deduct the damaged quantity from the book stock
            $book = book::find($fields['book_id']);
            if ($book) {
                $book->current_stock =  $book->current_stock - $fields['damaged_quantity'];
                $book->save();
            }
        }

        return redirect()->route('broken-book');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // calculate the total fine  (total days * fine per day)
        $brokenBook = BrokenBook::where('id', $id)->first();
        return view('book.brokenBook_edit', [
            'damage' => $brokenBook,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrokenBookRequest  $request
     * @param  \App\Models\BrokenBook  $brokenBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brokenBook = BrokenBook::find($id);
        if ($brokenBook->status === 'repaired') {
            return redirect()->route('broken-book')->with('error', 'This broken book record has already been marked as repaired and cannot be updated.');
        }

        if ($brokenBook->status === 'descarded') {
            return redirect()->route('broken-book')->with('error', 'This broken book record has been marked as discarded and cannot be updated.');
        }

        $fields = $request->validate([
            'status' => 'required',
        ]);

        $brokenBook->update([
            'status' => $fields['status'],
        ]);

        if ($brokenBook->status === 'repaired') {
            $book = $brokenBook->book;
            if ($book) {
                $book->current_stock =  $book->current_stock + $brokenBook->damaged_quantity;
                $book->save();
            }
        }

        if ($brokenBook->status === 'descarded' && $brokenBook->deduct_status === 'deducted') {
            $book = $brokenBook->book;
            if ($book) {
                $book->current_stock =  $book->current_stock + $brokenBook->damaged_quantity;
                $book->save();
            }
        }

        return redirect()->route('broken-book');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrokenBook  $brokenBook
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BrokenBook::find($id)->delete();
        return redirect()->route('broken-book');
    }
}
