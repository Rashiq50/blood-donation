@extends('layouts.app')

@section('content')
    <div style="width:'100vw'; height: 100vh; overflow:hidden; display:flex; position: relative; align-items: center; justify-content: center">
        <img width="1920" height="1080" src="{{ asset('/images/home.jpg') }}" />

        <div class="text-center" style="position: absolute;" data-aos="fade-up" data-aos-duration="500">
            <h1 style="font-size: 6rem" class="text-white fw-bold" >Blood Support</h1>
            <a href="{{ route('browse') }}" >
                <button class="btn btn-danger px-5 mt-3" style="border-radius: 15px; font-size: 2.5rem" > Search Donor </button>
            </a>
        </div>
    </div>
@endsection
