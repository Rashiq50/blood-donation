@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <div id="googleMap" style="width:100%;height:400px;"></div>

                        <div id="demo" style="width:100%;height:40px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const myLatLng = { lat: -25.363, lng: 131.044 };

        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDVtg1Pr02TgeFFUCwoMYMgw3qsmAs8mck&callback=myMap';
        script.async = true;

        window.myMap = function() {
            var mapProp = {
                center: myLatLng,
                zoom: 15,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "You location",
            });
        };

        document.head.appendChild(script);


        var x = document.getElementById("demo");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            myLatLng.lat = position.coords.latitude;
            myLatLng.lng = position.coords.longitude;

            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }

        getLocation();
        showPosition();

        window.myMap();
    </script>
@endsection
