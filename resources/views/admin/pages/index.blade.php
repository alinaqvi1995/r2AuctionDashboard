@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                @include('admin.layouts.includes.toolbar')

                <div class="row">
                    <div class="col-md-12 col-lg-4 mb-4">
                        <div class="card shadow-lg h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{ $productsCount }} Products</h3>
                                </div>
                                <div>
                                    <span class="fe fe-box fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 mb-4">
                        <div class="card shadow-lg h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{ $bidsCount }} Bids</h3>
                                </div>
                                <div>
                                    <span class="fe fe-dollar-sign fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4 mb-4">
                        <div class="card shadow-lg h-100">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="mb-0">{{ $usersCount }} Users</h3>
                                </div>
                                <div>
                                    <span class="fe fe-user fe-32"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="card shadow">
                            <div class="card-header d-flex justify-content-between">
                                <strong class="card-title">Recent Bids</strong>
                                <a class="small text-muted" href="#!">View all</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Name</th>
                                            <th>Lot #</th>
                                            <th>Listing Type</th>
                                            <th>Price</th>
                                            <th>Seller</th>
                                            <th>Start Date/Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1 @endphp
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->lot_no }}</td>
                                                <td>{{ $product->listing_type }}</td>
                                                <td>
                                                    <b>Minimum bid price:</b> {{ $product->minimum_bid_price }}<br>
                                                    <b>Buy now price:</b> {{ $product->buy_now_price }}<br>
                                                    <b>Reserve price:</b> {{ $product->reserve_price }}
                                                </td>
                                                <td>{{ $product->user->name . ' ' . $product->user->last_name }}</td>
                                                <td>{{ $product->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
