<div class="col-sm-12 spinner-container" style="padding-top: 10px;">
    <h3 class="font-bunny" style="color: #0e0e0e">「Japan Tourist Info」</h3>
</div>
<div class="col-sm-12 spinner-container sticky-top" style="padding-top: 15px;">
    <label for="query" class="text-primary" style="font-size: 16px;"><i class="bi bi-buildings-fill" style="vertical-align: 0;"></i> Explore a City or Place</label>
    <select id="query" type="text" class="tewi-grand-input text-center">
        <option hidden value="">City</option>
        @foreach($cities as $value => $label)
            <option value="{{ $value }}" {{ isset($city) && $city === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>