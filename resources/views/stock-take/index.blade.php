@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">Stock Takes</h2>
                </div>
                <div class="offset-md-7 col-md-2">
                    <a class="add-new" href="{{ route('stock-take.create') }}">New Stock Take</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="message"></div>
                    <table class="content-table">
                        <thead>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Conducted By</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @forelse ($stockTakes as $stockTake)
                                <tr>
                                    <td>{{ $stockTake->id }}</td>
                                    <td>{{ $stockTake->stock_take_date->format('Y-m-d') }}</td>
                                    <td>{{ $stockTake->conductor->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $stockTake->status === 'completed' ? 'success' : ($stockTake->status === 'in_progress' ? 'warning' : 'info') }}">
                                            {{ ucfirst(str_replace('_', ' ', $stockTake->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('stock-take.show', $stockTake) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        @if($stockTake->status !== 'completed')
                                            <a href="{{ route('stock-take.count', $stockTake) }}" class="btn btn-success btn-sm">
                                                <i class="fa fa-calculator"></i> Count
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No stock takes found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $stockTakes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection