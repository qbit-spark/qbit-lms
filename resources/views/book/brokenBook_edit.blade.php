@extends('layouts.app')
@section('content')
    <div id="admin-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="admin-heading">View Damaged Book</h2>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="yourform">
                        <table cellpadding="10px" width="90%" style="margin: 0 0 20px;">
                            <tr>
                                <td>Book Name:</td>
                                <td><b>{{ $damage->book->name }}</b></td>
                            </tr>
                            <tr>
                                <td>Reported By:</td>
                                <td><b>{{ $damage->reportedBy?->name ?? 'N/A' }}</b></td>
                            </tr>
                            <tr>
                                <td>Damage Type:</td>
                                <td><b>{{ $damage->damageType?->name ?? 'N/A' }}</b></td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td><b>{{ $damage->description ?? 'No description provided' }}</b></td>
                            </tr>
                            <tr>
                                <td>Damage Date:</td>
                                <td><b>{{ \Carbon\Carbon::parse($damage->damage_date)->format('d M, Y') }}</b></td>
                            </tr>
                            <tr>
                                <td>Damaged Quantity:</td>
                                <td><b>{{ $damage->damaged_quantity }}</b></td>
                            </tr>
                            <tr>
                                <td>Repair Cost:</td>
                                <td><b>Tsh. {{ number_format($damage->repair_cost, 2) }}</b></td>
                            </tr>
                            <tr>
                                <td>Deduct Status:</td>
                                <td><b>{{ ucfirst(str_replace('_', ' ', $damage->deduct_status)) }}</b></td>
                            </tr>
                            <tr>
                                <td>Remarks:</td>
                                <td><b>{{ $damage->remarks ?? '—' }}</b></td>
                            </tr>
                        </table>

                        <form action="{{ route('broken-book.update', $damage->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PATCH')

                            <table cellpadding="10px" width="90%">
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        <select name="status" class="form-control" required>
                                            <option value="pending" {{ $damage->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="under_repair"
                                                {{ $damage->status == 'under_repair' ? 'selected' : '' }}>Under Repair
                                            </option>
                                            <option value="repaired" {{ $damage->status == 'repaired' ? 'selected' : '' }}>
                                                Repaired</option>
                                            <option value="discarded"
                                                {{ $damage->status == 'discarded' ? 'selected' : '' }}>Discarded</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <input type="submit" class="btn btn-primary" value="Update Status">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
