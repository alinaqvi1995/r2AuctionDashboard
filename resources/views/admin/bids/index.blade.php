@extends('admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Live Bids</h2>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1 @endphp
                                    @foreach ($bids as $bid)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>
                                                {{ trim(($bid->product->user->full_name ?: $bid->product->user->name . ' ' . $bid->product->user->last_name) ?? '') }}
                                            </td>
                                            <td>{{ $bid->product->name }}</td>
                                            <td>{{ $bid->user->name }}</td>
                                            <td>
                                                <b>Minimum bid price:</b> {{ $bid->product->minimum_bid_price }} <br>
                                                <b>Buy now price:</b> {{ $bid->product->buy_now_price }} <br>
                                                <b>Reserve price: </b>{{ $bid->product->reserve_price }}
                                            </td>
                                            <td>{{ $bid->product->auctionSlot->auction_date . ' ' . $bid->product->auctionSlot->auction_date_end }}
                                            </td>
                                            <td>
                                                @if ($bid->status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($bid->status == 1)
                                                    <span class="badge badge-success">Accepted</span>
                                                @elseif ($bid->status == 2)
                                                    <span class="badge badge-danger">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
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
    <script></script>
@endsection
