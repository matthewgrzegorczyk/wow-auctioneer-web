<form
    class="filtersForm"
    action=""
    method="GET"
>
    {{-- {{ @csrf_field() }} --}}
    {{-- <input type="hidden" name="page" value="{{ $page }}" /> --}}
    <input type="text" name="search" placeholder="Silver Bar" value="{{ old('search', Request::get('search', '')) }}" />
    <input type="text" name="owner" placeholder="CharacterName" value="{{ old('owner', Request::get('owner', '')) }}" />
    <label for="minCount">Min Count</label>
    <input type="range" min="1" max="20" list="count" step="1" name="minCount" id="minCount" placeholder="Min Count" value="{{ old('minCount', Request::get('minCount', 1)) }}" />
    <label for="maxCount">Max Count</label>
    <input type="range" min="1" max="20" list="count" step="1" name="maxCount" id="maxCount" placeholder="Max Count" value="{{ old('maxCount', Request::get('maxCount', 20)) }}" />
    <datalist id="count">
        <option value="1" label="1">1</option>
        <option value="5" label="5">5</option>
        <option value="10">10</option>
        <option value="20">20</option>
    </datalist>
    <input type="submit" value="Search">
</form>
