@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Stock Take Count</h2>
                </div>
                <div class="offset-md-5 col-md-4">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('stock-take.show', $stockTake) }}" class="btn btn-primary mx-2">View Details</a>
                        @if($stockTake->status !== 'completed')
                            <form action="{{ route('stock-take.complete', $stockTake) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to complete this stock take? This will update the actual stock levels.')">
                                    Complete Stock Take
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('stock-take.update-count', $stockTake) }}" method="POST">
                        @csrf
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
                                    <tr>
                                        <td>{{ $item->book->id }}</td>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->system_quantity }}</td>
                                        <td>
                                            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                            <input type="number" 
                                                class="form-control @error('items.'.$loop->index.'.counted_quantity') is-invalid @enderror" 
                                                name="items[{{ $loop->index }}][counted_quantity]"
                                                value="{{ old('items.'.$loop->index.'.counted_quantity', $item->counted_quantity) }}"
                                                min="0">
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->difference < 0 ? 'badge-danger' : ($item->difference > 0 ? 'badge-warning' : 'badge-success') }}">
                                                {{ $item->difference ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                class="form-control" 
                                                name="items[{{ $loop->index }}][remarks]"
                                                value="{{ old('items.'.$loop->index.'.remarks', $item->remarks) }}"
                                                placeholder="Add remarks">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Save Counts</button>
                        </div>
                    </form>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection