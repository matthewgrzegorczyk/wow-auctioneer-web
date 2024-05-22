<div class="price">
    @if (!empty($price['gold']))
        <span class="price__gold">{{ $price['gold'] }}g</span>
    @endif
    @if (!empty($price['silver']))
        <span class="price__silver">{{ $price['silver'] }}s</span>
    @endif
    @if (!empty($price['copper']))
        <span class="price__copper">{{ $price['copper'] }}c</span>
    @endif
</div>
