@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">All Damaged Book</h2>
                </div>
                <div class="offset-md-6 col-md-3">
                    <a class="add-new" href="{{ route('broken-book.create') }}">Add Damaged Book</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="content-table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Book Name</th>
                                <th>Damage Type</th>
                                <th>QTY</th>
                                <th>Damage At</th>
                                <th>Status</th>
                                <th>Repair Cost</th>
                                <th>Remarks</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($damagedCollections as $index => $damage)
                                <tr
                                    @if ($damage->status === 'discarded') style="background: rgba(255, 0, 0, 0.1);" 
                @elseif ($damage->status === 'under_repair') 
                    style="background: rgba(255, 165, 0, 0.1);" 
                @elseif ($damage->status === 'repaired') 
                    style="background: rgba(0, 128, 0, 0.1);" @endif>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $damage->book->name ?? 'Unknown Book' }}</td>
                                    <td>{{ $damage->damageType->name ?? 'N/A' }}</td>
                                    <td>{{ $damage->damaged_quantity }}</td>
                                    <td>{{ \Carbon\Carbon::parse($damage->damage_date)->format('d M, Y') }}</td>
                                    <td>
                                        @if ($damage->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($damage->status === 'under_repair')
                                            <span class="badge bg-info text-dark">Under Repair</span>
                                        @elseif ($damage->status === 'repaired')
                                            <span class="badge bg-success">Repaired</span>
                                        @elseif ($damage->status === 'discarded')
                                            <span class="badge bg-danger">Discarded</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($damage->repair_cost, 2) }}</td>
                                    <td>{{ Str::limit($damage->remarks, 30) ?? '—' }}</td>
                                    <!-- Edit -->
                                    <td class="edit">
                                        <a href="{{ route('broken-book.edit', $damage->id) }}"
                                            class="btn btn-success btn-sm">
                                            <x-tool-icon />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No Damaged Books Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    {{ $damagedCollections->links('vendor/pagination/bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
