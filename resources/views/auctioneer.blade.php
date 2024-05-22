@extends('layout')

@section('head_data')
    <link rel="stylesheet" href="https://wowclassicdb.com/tbc/tooltip.min.css">
    <script>const wowdbTooltipConfig = { colorLinks: true, renameLinks: true }</script>
    <script src="https://wowclassicdb.com/tbc/tooltip.js"></script>
@endsection

@section('content')
    @include('components.filters')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Item</th>
                <th scope="col">Quality</th>
                <th scope="col">Use Level</th>
                <th scope="col">Category</th>
                <th scope="col">Sub Category</th>
                <th scope="col">Stack Count</th>
                <th scope="col">Equip Loc</th>
                <th scope="col">Texture</th>
                <th scope="col">Auctions</th>
            </tr>
        </thead>
        @foreach ($items as $item)
            <tr class="item">
                <td class="item" scope="row">
                    <a
                        href="https://wowclassicdb.com/tbc/item/{{ $item->itemId }}"
                        data-wowdb-rename-link="false"
                        data-wowdb-icon-size="large"
                    >{{ $item->name }}</a>
                </td>
                <td>{{ $item->quality }}</td>
                <td>{{ $item->useLevel }}</td>
                <td>{{ $item->categoryName }}</td>
                <td>{{ $item->subCategoryName }}</td>
                <td>{{ $item->stackCount }}</td>
                <td>{{ $item->equipLocName }}</td>
                <td>{{ $item->textureName }}</td>
                <td><a href="{{ route('auctionsByItemKey', ['itemKey' => $item->itemKey]) }}">auctions</a></td>
            </tr>
        @endforeach
    </table>
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
    {{-- @var AuctioneerSnapshotDB $snapshotDB --}}
    {{-- dd($snapshotDB) --}}
@endsection
