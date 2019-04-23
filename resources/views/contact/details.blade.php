@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Contact Details</div>

                <div class="card-body">

                    <div class="form-group row">
                        <label for="first_name" class="col-md-4 text-md-right">First Name</label>

                        <div class="col-md-6">
                            {{ $contact_detail->first_name }}

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="middle_name" class="col-md-4  text-md-right">Middle Name</label>
                        <div class="col-md-6">
                            {{ $contact_detail->middle_name??'-' }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 text-md-right">Last Name</label>
                        <div class="col-md-6">
                            {{ $contact_detail->last_name }}

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="primary_phone_no" class="col-md-4 text-md-right">Primary Phone No</label>
                        <div class="col-md-6">
                            {{ $contact_detail->primary_phone_no }}

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="secondary_phone_no" class="col-md-4 text-md-right">Secondary Phone No</label>

                        <div class="col-md-6">
                            {{ $contact_detail->secondary_phone_no??'-' }}

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 text-md-right">Email</label>

                        <div class="col-md-6">
                            {{ $contact_detail->email }}

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact_image" class="col-md-4 text-md-right">Image</label>
                        <div class="col-md-6">
                            <!--{{asset('storage/images/') . $contact_detail->contact_image}}-->
                            <img src="{{asset('storage/images/'.$contact_detail->contact_image) }}" alt="No image available" width="100px" />
                        </div
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ route('contact.index') }}" class="btn btn-primary pull-left"> Back</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

