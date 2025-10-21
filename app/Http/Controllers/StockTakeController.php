<?php

namespace App\Http\Controllers;

use App\Models\StockTake;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTakeController extends Controller
{
    public function index()
    {
        $stockTakes = StockTake::with('conductor')->latest()->paginate(15);
        return view('stock-take.index', compact('stockTakes'));
    }

    public function create()
    {
        return view('stock-take.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_take_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $stockTake = StockTake::create([
            'stock_take_date' => $request->stock_take_date,
            'notes' => $request->notes,
            'conducted_by' => Auth::id(),
            'status' => 'draft'
        ]);

        $stockTake->initializeItems();

        return redirect()->route('stock-take.count', $stockTake)
            ->with('success', 'Stock take initialized successfully.');
    }

    public function count(StockTake $stockTake)
    {
        if ($stockTake->status === 'completed') {
            return redirect()->route('stock-take.show', $stockTake)
                ->with('error', 'This stock take has already been completed.');
        }

        $stockTake->status = 'in_progress';
        $stockTake->save();

        $items = $stockTake->items()->with('book')->paginate(20);
        return view('stock-take.count', compact('stockTake', 'items'));
    }

    public function updateCount(Request $request, StockTake $stockTake)
    {
        $request->validate([
            'items.*.id' => 'required|exists:stock_take_items,id',
            'items.*.counted_quantity' => 'nullable|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            $model  =  $stockTake->items()->where('id', $item['id'])->first();
            $model->update([
                'counted_quantity' => $item['counted_quantity'],
                'remarks' => $item['remarks'] ?? null,
            ]);
            $model->save();
        }

        return redirect()->back()->with('success', 'Counts updated successfully.');
    }

    public function complete(StockTake $stockTake)
    {
        if ($stockTake->status === 'completed') {
            return redirect()->back()->with('error', 'This stock take has already been completed.');
        }

        $stockTake->status = 'completed';
        $stockTake->save();

        $stockTake->updateStock();

        return redirect()->route('stock-take.show', $stockTake)
            ->with('success', 'Stock take completed successfully.');
    }

    public function show(StockTake $stockTake)
    {
        $items = $stockTake->items()->with('book')->paginate(20);
        return view('stock-take.show', compact('stockTake', 'items'));
    }
}
