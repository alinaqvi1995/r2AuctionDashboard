<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Auction Days</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="slotTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($auctionSlots as $slot)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="description{{ $slot->id }}">{{ $slot->auction_date }} - {{ $slot->auction_date_end }}</td>
                <td id="btn{{ $slot->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editSlotBtn"
                        type="button" data-id="{{ $slot->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteSlotBtn" type="button"
                        data-id="{{ $slot->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
