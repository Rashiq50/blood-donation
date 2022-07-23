@extends('layouts.app')


@section('content')
    <div class="container" style="height: 100vh">
        <div class="row justify-content-center align-items-center h-100">
            <div class="card shadow p-5">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>{{ $message }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Add New Donor</h2>
                        </div>

                    </div>
                </div>

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::open(['route' => 'addDonor', 'method' => 'POST']) !!}
                <div class="row " style="row-gap: 10px">

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Contact No:</strong>
                            {!! Form::text('contact', null, ['placeholder' => 'Contact No', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Location:</strong>
                            {!! Form::text('address', null, ['placeholder' => 'Location', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Institution:</strong>
                            {!! Form::text('institute', null, ['placeholder' => 'Institution', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
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
                                ['placeholder' => 'Blood group', 'class' => 'form-control'],
                            ) !!}
                        </div>
                    </div>



                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary my-2">Submit</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
