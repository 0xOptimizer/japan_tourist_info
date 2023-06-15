@extends('layouts.app')

@section('title', 'Weather and Venue Information')

@section('content')
<div class="tewi-overlay row">
    @include('layouts.navigation')
    <div class="col-sm-12 spinner-container">
        @isset($weather)
            <div class="row mt-4 mb-3" style="margin: 0px 10px 0px 10px; width: 100%;">
                <div style="border-bottom: 2px solid var(--color-muted); font-size: 28px; text-align: left;">
                    Weather <span style="font-size: 18px;">(<span class="local-time" data-timestamp="{{ $weather['dt'] ?? 0 }}"><i class="spinner-border spinner-border-sm" style="vertical-align: -0.1rem; font-size: 12px;"></i></span>)</span>
                </div>
            </div>
            <div class="row" style="margin: 0px 10px 0px 10px;">
                <div class="d-flex flex-wrap justify-content-start text-center">
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Weather</strong>
                        <div>
                            {{ $weather['weather'][0]['main'] ?? 'No data' }} <span style="font-size: 14px;">({{ $weather['weather'][0]['description'] ?? 'No data' }})</span>
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Temperature</strong>
                        <div>
                            {{ isset($weather['main']['temp']) ? ($weather['main']['temp'] - 273.15) . '°C' : 'No data' }}
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Pressure</strong> 
                        <div>
                            {{ isset($weather['main']['pressure']) ? $weather['main']['pressure'] . 'hPa' : 'No data' }}
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Humidity</strong> 
                        <div>
                            {{ isset($weather['main']['humidity']) ? $weather['main']['humidity'] . '%' : 'No data' }}
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Visibility</strong> 
                        <div>
                            {{ $weather['visibility'] ?? 'No data' }} meters
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Wind</strong>
                        <div>
                            {{ isset($weather['wind']['deg']) ? $weather['wind']['deg'] . '°' : 'No data' }} at {{ isset($weather['wind']['speed']) ? $weather['wind']['speed'] . 'm/s' : 'No data' }}
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Rain (Last hour)</strong> 
                        <div>
                            {{ $weather['rain']['1h'] ?? 'No rain data' }}mm
                        </div>
                    </div>
                    <div class="tewi-info-container mb-2" style="flex: 1 0 20%;">
                        <strong>Clouds</strong> 
                        <div>
                            {{ $weather['clouds']['all'] ?? 'No data' }}%
                        </div>
                    </div>
                    @isset($weather_analysis)
                        <div class="tewi-info-container mb-2" style="flex: 1 0 100%;">
                            <strong>AI Analysis</strong>
                            <div style="font-size: 14px; font-weight: bold;">
                                "{{ $weather_analysis['choices'][0]['message']['content'] ?? 'No analysis response.' }}"
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        @endisset
        @isset($venues)
            <div class="row mt-4 mb-3" style="margin: 0px 10px 0px 10px; width: 100%;">
                <div style="border-bottom: 2px solid var(--color-muted); font-size: 28px; text-align: left;">
                    Venues <span style="font-size: 18px;">({{ count($venues['results']) ?? 0 }})</span>
                </div>
            </div>
            <div class="row" style="margin: 0px 10px 0px 10px;">
                @foreach($venues['results'] as $venue)
                    <div class="col-lg-3 col-md-6 col-sm-12 mt-2">
                        <div class="tewi-card tewi-card-clickable" data-fsq_id="{{ $venue['fsq_id'] }}">
                            <div class="tewi-card-icon" style="top: -75px;">
                                <i class="bi bi-caret-down-fill"></i>
                            </div>
                            <div class="tewi-card-body">
                                <div class="venue">
                                    <div style="font-size: 22px; font-weight: bold; height: 33px; overflow-y: auto;">{{ $venue['name'] }}</div>
                                    <div style="font-size: 14px; height: 25px; overflow-y: auto; opacity: 0.95; margin-top: -2px;">{{ implode(", ", array_column($venue['categories'], 'name')) }} - {{ $venue['distance'] }} meters from {{ ucfirst($city) }}</div>
                                    <div style="height: 75px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 #f5f5f5;">
                                        <p>{{ $venue['location']['formatted_address'] }}</p>
                                    </div>
                                    <p><a href="https://www.google.com/maps/search/?api=1&query={{ $venue['geocodes']['main']['latitude'] }},{{ $venue['geocodes']['main']['longitude'] }}&query_place_id={{ urlencode($venue['location']['formatted_address']) }}" target="_blank" class="btn btn-primary"><i class="bi bi-geo-alt-fill" style="vertical-align: 0.1rem; font-size: 14px;"></i> View on Google Maps</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endisset
    </div>
    <ul class="circles" data-circles_group="blur">
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
        <li class="circles-animation-slow"></li>
    </ul>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/moment.js') }}"></script>
<script>
$(document).ready(function() {
    var timestamp = $('.local-time').data('timestamp');
    var date = moment.unix(timestamp);
    var formattedDate = date.format('ddd, h:mm A');
    $('.local-time').text(formattedDate);

    $('#query').on('change', function() {
        var selectedCity = $(this).val();
        if (selectedCity !== '') {
            window.location.href = '/location/' + selectedCity;
        } else {
            window.location.href = '/location';
        }
    });
});
</script>

@endsection