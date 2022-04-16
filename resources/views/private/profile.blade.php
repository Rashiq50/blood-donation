@extends('layouts.app')


@section('content')
    <div class="card">

        <div class="card-body row justify-content-start">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px"
                        src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <span class="font-weight-bold fs-4"> {{ $user->name }} </span>
                    <span class="text-black-50"> <i class="fas fa-phone"></i> {{ $user->phone }} </span>
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
                            <label class="labels">Name</label>
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Mobile Number</label>
                            {!! Form::text('phone', null, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                            <div class="col-md-12">
                                <label class="labels">Email</label>
                                {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                            </div>

                        </div>
                        <div class="row mt-3">
                            {{-- <div class="col-md-6">
                                <label class="labels">Last Donated</label>
                                {!! Form::date('last_donated', null, ['class' => 'form-control']) !!}
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="avalable"
                                        {{ $user->available ? 'checked' : '' }}>
                                    <label class="form-check-label" for="avalable"> Available to donation </label>
                                    {!! Form::text('available', null, ['class' => 'form-control w-75 d-none']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="labels">Area</label>
                            <div class="d-flex mb-4">
                                {!! Form::text('area', null, ['placeholder' => 'Area', 'class' => 'form-control w-75']) !!}
                                <button onclick="getLocation()" type="button" class="btn btn-sm btn-success ms-1"> Detect
                                    Location
                                </button>
                            </div>
                            {!! Form::text('lat_lng', null, ['class' => 'lat_lng form-control w-75 d-none']) !!}
                            <div id="googleMap" style="width:100%;"></div>
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
