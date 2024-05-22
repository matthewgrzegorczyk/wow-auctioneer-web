@extends('layout')

@section('head_data')
    <link rel="stylesheet" href="https://wowclassicdb.com/tbc/tooltip.min.css">
    <script>const wowdbTooltipConfig = { colorLinks: true, renameLinks: true };</script>
    <script src="https://wowclassicdb.com/tbc/tooltip.js"></script>
@endsection

@section('content')
    @include('components.filters')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Count</th>
                    <th scope="col">Buyout Price</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Time Left</th>
                    <th scope="col">Last Seen</th>
                    <th>Expiration</th>
                </tr>
            </thead>
            @foreach ($auctionsByAH as $ah => $ahAuctions)
                @foreach ($ahAuctions as $auction)
                    <tr class="item">
                        <td scope="row">
                            <a
                                href="https://wowclassicdb.com/tbc/item/{{ $auction->itemId }}"
                                data-wowdb-rename-link="true"
                                data-wowdb-icon-size="large"
                            >{{ $auction->itemId }}</a>
                        </td>
                        <td>{{ $auction->count }}</td>
                        <td>
                            @include(
                                'components.price',
                                [
                                    'price' => $auction->getFormattedBuyoutPrice(),
                                ]
                            )
                        </td>
                        <td>{{ $auction->owner }}</td>
                        <td>{{ $auction->timeLeft }}</td>
                        <td>{{ $auction->getLastSeen() }}</td>
                        <td>{{ $auction->getExpiration() }}</td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
    @if (!empty($pages) && count($pages) > 1)
        <nav aria-label="page navigation">
            <ul class="pagination">
                @foreach($pages as $page => $isCurrent)
                    <li
                        @class([
                            "page-item",
                            "active" => $isCurrent
                        ])
                    >
                        <a class="page-link" href="{{ route('auctioneer', ['page' => $page]) }}">{{ $page }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    @endif
@endsection
