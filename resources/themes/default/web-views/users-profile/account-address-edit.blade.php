@extends('layouts.front-end.app')

@section('title', translate('my_Address'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/vendor/nouislider/distribute/nouislider.min.css')}}"/>
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/css/address.css') }}">
    <link rel="stylesheet" href="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
<div class="container py-4 rtl __account-address text-align-direction">
<style>
        #map {
            height: 500px;
            width: 100%;
        }
        #search-box {
            margin-top: 10px;
            width: 100%;
            height: 40px;
            padding: 5px;
            font-size: 16px;
        }
    </style>
    <div class="row g-3">
        @include('web-views.partials._profile-aside')
        <section class="col-lg-9 col-md-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="font-bold m-0 fs-16">{{translate('Update_Addresses')}}</h5>
                    <form action="{{route('address-update')}}" method="post">
                        @csrf
                        <div class="row pb-1">
                            <div class="col-md-6">
                                <input type="hidden" name="id" value="{{$shippingAddress->id}}">
                                <ul class="donate-now d-flex gap-2">
                                    <li class="address_type_li">
                                        <input type="radio" class="address_type" id="a25" name="addressAs" value="permanent"  {{ $shippingAddress->address_type == 'permanent' ? 'checked' : ''}} />
                                        <label for="a25" class="component">{{translate('permanent')}}</label>
                                    </li>
                                    <li class="address_type_li">
                                        <input type="radio" class="address_type" id="a50" name="addressAs" value="home" {{ $shippingAddress->address_type == 'home' ? 'checked' : ''}} />
                                        <label for="a50" class="component">{{translate('home')}}</label>
                                    </li>
                                    <li class="address_type_li">
                                        <input type="radio" class="address_type" id="a75" name="addressAs" value="office" {{ $shippingAddress->address_type == 'office' ? 'checked' : ''}}/>
                                        <label for="a75" class="component">{{translate('office')}}</label>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="is_billing" value="{{$shippingAddress->is_billing}}">
                                <ul class="donate-now d-flex gap-2">
                                    <li class="address_type_bl">
                                        <input type="radio" class="bill_type" id="b25" name="is_billing" value="0"  {{ $shippingAddress->is_billing == '0' ? 'checked' : ''}} />
                                        <label for="b25" class="component">{{translate('shipping')}}</label>
                                    </li>
                                    <li class="address_type_bl">
                                        <input type="radio" class="bill_type" id="b50" name="is_billing" value="1" {{ $shippingAddress->is_billing == '1' ? 'checked' : ''}} />
                                        <label for="b50" class="component">{{translate('billing')}}</label>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="person_name">{{translate('contact_person_name')}}</label>
                                <input class="form-control" type="text" id="person_name"
                                    name="name"
                                    value="{{$shippingAddress->contact_person_name}}"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="own_phone">{{translate('phone')}}</label>
                                <input class="form-control phone-input-with-country-picker" type="text" id="own_phone" value="+{{$shippingAddress->phone}}" required="required">
                                <input type="hidden" class="country-picker-phone-number w-50" name="phone" value="{{ $shippingAddress->phone }}" readonly>
                            </div>
                        </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">{{ translate('city') }}</label>
                        <input 
                            class="form-control" 
                            type="text" 
                            id="city" 
                            name="city" 
                            value="{{ $shippingAddress->city }}" 
                            required
                        >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zip_code">{{ translate('pin_code') }}</label>
                        <input 
                            class="form-control" 
                            type="text" 
                            id="zip_code" 
                            name="zip" 
                            value="{{ $shippingAddress->zip }}" 
                            required
                        >
                    </div>
                </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="city">{{translate('country')}}</label>
                                <select name="country" class="form-control selectpicker" data-live-search="true" id="" required>
                                    @if($country_restrict_status)
                                        @foreach($delivery_countries as $country)
                                            <option value="{{$country['name']}}" {{ $country['name'] == $shippingAddress->country? 'selected' : ''}}>{{$country['name']}}</option>
                                        @endforeach
                                    @else
                                        @foreach(COUNTRIES as $country)
                                            <option value="{{ $country['name'] }}" {{ $shippingAddress->country == $country['name']? 'selected' : '' }}>{{ $country['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class=" col-md-12">
                                <div class="form-group mb-1">
                                    <label for="own_address">{{translate('address')}}</label>
                                    <textarea class="form-control" id="address"
                                              type="text"  name="address" required>{{$shippingAddress->address}}</textarea>
                                    <span class="fs-14 text-danger font-semi-bold opacity-0 map-address-alert">
                                        {{ translate('note') }}: {{ translate('you_need_to_select_address_from_your_selected_country') }}
                                    </span>
                                </div>
                            </div>
                            @if(getWebConfig('map_api_status') ==1 )
                                <div class="col-md-12">
                                    <div class="form-group map-area-alert-border location-map-address-canvas-area">
                                        <!-- <input id="pac-input" class="controls rounded __inline-46 location-search-input-field" title="{{translate('search_your_location_here')}}" type="text" placeholder="{{translate('search_here')}}"/> -->
                                        <input id="search-box" type="text" placeholder="Search for a location">

                                        <div class="__h-400px" id="map"></div>

                                    </div>
                                </div>
                            @endif
                        </div>
                        @php($shipping_latitude=$shippingAddress->latitude)
                        @php($shipping_longitude=$shippingAddress->longitude)
                        <input type="hidden" id="latitude"
                            name="latitude" class="form-control d-inline"
                            placeholder="{{ translate('ex')}} : -94.22213" value="{{$shipping_latitude??0}}" required readonly>
                        <input type="hidden"
                            name="longitude" class="form-control"
                            placeholder="{{ translate('ex')}} : 103.344322" id="longitude" value="{{$shipping_longitude??0}}" required readonly>
                        <div class="modal-footer">
                            <a href="{{ route('account-address') }}" class="closeB btn btn-secondary fs-14 font-semi-bold py-2 px-4">{{translate('close')}}</a>
                            <button type="submit" class="btn btn--primary fs-14 font-semi-bold py-2 px-4">{{translate('update')}}  </button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>
</div>
<span id="system-country-restrict-status" data-value="{{ $country_restrict_status }}"></span>
@endsection

@push('script')
<script>
    'use strict'
    const deliveryRestrictedCountries = @json($countriesName);
    function deliveryRestrictedCountriesCheck(countryOrCode, elementSelector, inputElement) {
        const foundIndex = deliveryRestrictedCountries.findIndex(country => country.toLowerCase() === countryOrCode.toLowerCase());
        if (foundIndex !== -1) {
            $(elementSelector).removeClass('map-area-alert-danger');
            $(inputElement).parent().find('.map-address-alert').removeClass('opacity-100').addClass('opacity-0')
        } else {
            $(elementSelector).addClass('map-area-alert-danger');
            $(inputElement).val('')
            $(inputElement).parent().find('.map-address-alert').removeClass('opacity-0').addClass('opacity-100')
        }
    }
</script>
<script src="{{ theme_asset(path: 'public/assets/front-end/js/bootstrap-select.min.js') }}"></script>
<script src="{{ theme_asset(path: 'public/assets/front-end/plugin/intl-tel-input/js/intlTelInput.js') }}"></script>
<script src="{{ theme_asset(path: 'public/assets/front-end/js/country-picker-init.js') }}"></script>
@if(getWebConfig('map_api_status') ==1 )
    <!-- <script
        src="https://maps.googleapis.com/maps/api/js?key={{getWebConfig('map_api_key')}}&callback=initMap&libraries=places&v=3.56" defer>
    </script> -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{getWebConfig('map_api_key')}}&libraries=places&callback=initMap">
    </script>
    <script>
         let map, marker, geocoder;

function initMap() {
    // const defaultLocation = { lat: -33.8688, lng: 151.2195 }; // Default location (Sydney)
    var defaultLocation = { lat: {{$shipping_latitude??'-33.8688'}}, lng: {{$shipping_longitude??'151.2195'}} };


    // Initialize the map
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLocation,
        zoom: 13,
        mapTypeId: 'roadmap',
    });

    // Initialize the geocoder
    geocoder = new google.maps.Geocoder();

    // Create a marker
    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: true, // Marker is draggable
    });

    // Update latitude and longitude variables when clicking on the map
    map.addListener('click', (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setMarkerPosition(lat, lng);
    });

    // Search functionality using Places API
    const input = document.getElementById("search-box");
    const searchBox = new google.maps.places.SearchBox(input);

    // Bias the SearchBox results towards the map's viewport
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    // Listen for the event when a user selects a place
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length === 0) {
            return;
        }

        const place = places[0];
        if (!place.geometry || !place.geometry.location) {
            console.error("Returned place has no geometry.");
            return;
        }

        const lat = place.geometry.location.lat();
        const lng = place.geometry.location.lng();
        setMarkerPosition(lat, lng);

        // Center the map on the selected place
        map.setCenter(place.geometry.location);
        map.setZoom(15);
    });
}

// Update marker position and log latitude & longitude
function setMarkerPosition(lat, lng) {
    const position = { lat, lng };
    marker.setPosition(position);
    map.panTo(position);

    // Log the latitude and longitude
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    console.log("Latitude:", lat, "Longitude:", lng);
}

        $(document).on("keydown", "input", function(e) {
            if (e.which==13) e.preventDefault();
        });
    </script>
@endif
@endpush
