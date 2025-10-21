@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Stock Take Details</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    <a class="add-new" href="{{ route('stock-take.index') }}">All Stock Takes</a>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="">
                        <div class="c">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Date:</strong> {{ $stockTake->stock_take_date->format('Y-m-d') }}</p>
                                    <p><strong>Conducted By:</strong> {{ $stockTake->conductor->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Status:</strong> 
                                        <span class="badge badge-{{ $stockTake->status === 'completed' ? 'success' : ($stockTake->status === 'in_progress' ? 'warning' : 'info') }}">
                                            {{ ucfirst(str_replace('_', ' ', $stockTake->status)) }}
                                        </span>
                                    </p>
                                    <p><strong>Notes:</strong> {{ $stockTake->notes ?: 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>Book ID</th>
                                <th>Book Name</th>
                                <th>System Quantity</th>
                                <th>Counted Quantity</th>
                                <th>Difference</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr class="{{ $item->difference != 0 && $item->difference !== null ? 'table-warning' : '' }}">
                                    <td>{{ $item->book->id }}</td>
                                    <td>{{ $item->book->name }}</td>
                                    <td>{{ $item->system_quantity }}</td>
                                    <td>{{ $item->counted_quantity ?? 'Not counted' }}</td>
                                    <td>
                                        @if($item->difference !== null)
                                            <span class="badge {{ $item->difference < 0 ? 'badge-danger' : ($item->difference > 0 ? 'badge-warning' : 'badge-success') }}">
                                                {{ $item->difference }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->remarks ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $items->links() }}
                </div>
            </div>

            @if($stockTake->status !== 'completed')
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('stock-take.count', $stockTake) }}" class="btn btn-primary">
                            Continue Counting
                        </a>
                        <form action="{{ route('stock-take.complete', $stockTake) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to complete this stock take? This will update the actual stock levels.')">
                                Complete Stock Take
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection