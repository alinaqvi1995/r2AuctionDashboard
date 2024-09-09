@extends('admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Live Bids</h2>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Filters -->
                            {{-- <div class="row mb-3">
                                <div class="col-md-3">
                                    <select id="filter-role" class="form-control">
                                        <option value="">Filter by Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="buyer">Buyer</option>
                                        <option value="seller">Seller</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="filter-business_type" class="form-control">
                                        <option value="">Filter by Business Type</option>
                                        <option value="Company">Company</option>
                                        <option value="Individual">Individual</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select id="filter-status" class="form-control">
                                        <option value="">Filter by Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div> --}}
                            <!-- table -->
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Seller</th>
                                        <th>Product</th>
                                        <th>Bidder</th>
                                        <th>Bid Amount</th>
                                        <th>Bid Date</th>
                                        {{-- <th>Price</th>
                                        <th>Seller</th>
                                        <th>Start Date/Time</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1 @endphp
                                    @foreach ($bids as $bid->product)
                                        {{-- @if ($bid->product->role != 'admin') --}}
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    {{ $bid->product->user->full_name }}
                                                </td>
                                                <td>{{ $bid->product->title }}</td>
                                                <td>{{ $bid->user->name }}</td>
                                                <td>
                                                    <b>Minimum bid price:</b> {{ $bid->product->minimum_bid_price }} <br>
                                                    <b>Buy now price:</b> {{ $bid->product->buy_now_price }} <br>
                                                    <b>Reserve price: </b>{{ $bid->product->reserve_price }}
                                                </td>
                                                {{-- <td>
                                                    @if ($bid->product->status == 1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td> --}}
                                                <td>{{ $bid->product->auctionSlot->auction_date . ' ' . $bid->product->auctionSlot->auction_date_end }}</td>
                                                {{-- <td>
                                                    <button
                                                        class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted"
                                                        type="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right shadow">
                                                        <a class="dropdown-item"
                                                            href="{{ route('users.edit', $bid->product->id) }}"><i
                                                                class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                                                        <form action="{{ route('users.destroy', $bid->product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item"><i
                                                                class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                                                    </form>
                                                    </div>
                                                </td> --}}
                                            </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- data table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div>
@endsection

@section('bottom_script')
    <script>
        // $(document).ready(function() {
        //     var table = $('#dataTable-1').DataTable();

        //     $('#filter-role').on('change', function() {
        //         var selectedRole = $(this).val();
        //         table.column(4).search(selectedRole).draw();
        //     });

        //     $('#filter-business_type').on('change', function() {
        //         var selectedRole = $(this).val();
        //         table.column(5).search(selectedRole).draw();
        //     });

        //     $('#filter-status').on('change', function() {
        //         var selectedStatus = $(this).val();
        //         var statusText = selectedStatus == '1' ? '^Active$' : selectedStatus == '0' ? '^Inactive$' :
        //             '';
        //         table.column(6).search(statusText, true, false).draw();
        //     });
        // });
    </script>
@endsection
