@extends('layouts.app')


@section('content')
<div class="card mt-5 h-100">

    <div class="card-body row justify-content-start">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold fs-4"> {{ $user->name }} </span>
                <span class="text-black-50"> <i class="fas fa-phone"></i> {{ $user->contact }} </span>
                <span class="text-black-50"> <i class="fas fa-heart"></i> {{ Str::upper($user->blood_group) }}</span>
            </div>
        </div>
        <div class="col-md-5 border">
            <div class="p-3 py-5">
                {!! Form::model($user, ['method' => 'POST', 'route' => ['profile']]) !!}

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <strong class="labels">Name</strong>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong class="labels">Contact No.</strong>
                        {!! Form::text('contact', null, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong class="labels">Email</strong>
                        {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong class="labels">Institution</strong>
                        {!! Form::text('institute', null, ['placeholder' => 'Institution', 'class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-12 mt-3">
                        <strong class="labels">Location</strong>
                        <div class="d-flex mb-4">
                            {!! Form::text('address', null, ['placeholder' => 'Location', 'class' => 'form-control ']) !!}
                            {{-- <button onclick="getLocation()" type="button" class="btn btn-sm btn-success ms-1"> Detect
                                    Location
                                </button> --}}
                        </div>
                        {{-- {!! Form::text('lat_lng', null, ['class' => 'lat_lng form-control w-75 d-none']) !!} --}}
                        {{-- <div id="googleMap" style="width:100%;"></div> --}}
                    </div>

                    <div class="form-group mb-3">
                        <strong>Blood Group:</strong>
                        {!! Form::select(
                        'blood_group',
                        [
                        '' => 'Please select',
                        'a+' => 'A+ (A positive)',
                        'a-' => 'A- (A negative)',
                        'b+' => 'B+ (B positive)',
                        'b-' => 'B- (B negative)',

                        'o+' => 'O+ (O positive)',
                        'o-' => 'O- (O negative)',
                        'ab+' => 'AB+ (AB positive)',
                        'ab-' => 'AB- (AB negative)',
                        ],
                        null,
                        ['class' => 'form-control'],
                        ) !!}
                    </div>

                    <div class="form-group mb-3">
                        <strong>Last Donated:</strong>
                        @if ($user->last_donated)
                        {{ date('d-M-Y', strtotime($user->last_donated)) }}
                        @else
                        Never
                        @endif
                        {!! Form::date('last_donated', '', ['placeholder' => 'dd/mm/yyyy', 'class' => 'form-control']) !!}
                    </div>

                    <div class="">
                        <div class="">
                            <strong class="form-check-label" for="available"> Available to donation </strong>
                            {!! Form::select(
                            'available',
                            [
                            'available' => 'Available',
                            'not available' => 'Not Available',
                            ],
                            null,
                            [
                            'placeholder' => 'Please Select',
                            'class' => 'form-control',
                            'disabled' => $user->last_donated && Carbon\Carbon::parse($user->last_donated)->diffInMonths() <= 3, ], ) !!} @if( $user->last_donated && Carbon\Carbon::parse($user->last_donated)->diffInMonths() <= 3) <span class="invalid-feedback d-block" role="alert">
                                    <strong> You cannot donate before 3 months since you last donated </strong>
                                    </span>
                                    @endif
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">
                            Save Profile
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        let map = null;
        let geocoder = null;
        let infowindow = null;
        let zoom = 5;
        const user = @json($user);
        const userLatLng = JSON.parse(user.lat_lng);
        const myLatLng = {
            lat: 23.6850,
            lng: 90.3563
        };
        if (userLatLng) {
            myLatLng.lat = userLatLng.lat;
            myLatLng.lng = userLatLng.lng;
            zoom = 15;
        }
        markers = [];
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVtg1Pr02TgeFFUCwoMYMgw3qsmAs8mck&callback=loadMap';
        script.async = true;
        script.defer = true;

        function loadMap() {
            document.getElementById("googleMap").style.height = "400px";
            var mapProp = {
                center: myLatLng,
                zoom: zoom,
            };
            map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            geocoder = new google.maps.Geocoder();
            infowindow = new google.maps.InfoWindow();

            const marker = new google.maps.Marker({
                position: myLatLng,
                map,
                title: "You location",
            });
            markers.push(marker);
        };

        document.head.appendChild(script);

        function getLocation() {
            console.log("geolocation");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            console.log("position");
            myLatLng.lat = position.coords.latitude;
            myLatLng.lng = position.coords.longitude;
            document.querySelector('.lat_lng').value = JSON.stringify(myLatLng);
            setMarker();
        }

        function setMarker() {
            console.log("marker", myLatLng);
            setMapOnAll(null);
            const marker = new google.maps.Marker({
                position: myLatLng,
                title: "You location",
            });
            markers.push(marker);
            marker.setMap(map);
            map.setZoom(15);
            map.setCenter(marker.getPosition());
            // geocodeLatLng();
        }

        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }


        window.onLoad = function() {
            loadMap();
        };

        function geocodeLatLng() {
            geocoder
                .geocode({
                    location: myLatLng
                })
                .then((response) => {
                    if (response.results[0]) {
                        const marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                        });

                        infowindow.setContent(response.results[0].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        window.alert("No results found");
                    }
                })
                .catch((e) => window.alert("Geocoder failed due to: " + e));
        }
    </script>
    @endsection