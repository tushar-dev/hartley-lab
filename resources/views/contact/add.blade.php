@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Contact</div>

                <div class="card-body">
                    <form name="addContactFrm" id="addContactFrm" method="POST" action="{{ route('contact.insert') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middle_name" class="col-md-4 col-form-label text-md-right">Middle Name</label>
                            <div class="col-md-6">
                                <input id="middle_name" type="text" class="form-control{{ $errors->has('middle_name') ? ' is-invalid' : '' }}" name="middle_name" value="{{ old('middle_name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}">
                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="primary_phone_no" class="col-md-4 col-form-label text-md-right">Primary Phone No</label>
                            <div class="col-md-6">
                                <input id="primary_phone_no" type="text" class="form-control{{ $errors->has('primary_phone_no') ? ' is-invalid' : '' }}" name="primary_phone_no" value="{{ old('primary_phone_no') }}" >
                                @if ($errors->has('primary_phone_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('primary_phone_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="secondary_phone_no" class="col-md-4 col-form-label text-md-right">Secondary Phone No</label>

                            <div class="col-md-6">
                                <input id="secondary_phone_no" type="text" class="form-control{{ $errors->has('secondary_phone_no') ? ' is-invalid' : '' }}" name="secondary_phone_no" value="{{ old('secondary_phone_no') }}">

                                @if ($errors->has('secondary_phone_no'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('secondary_phone_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact_image" class="col-md-4 col-form-label text-md-right">Contact Image</label>
                            <div class="col-md-6">
                                <input id="contact_image" type="file" class="{{ $errors->has('contact_image') ? ' is-invalid' : '' }}" name="contact_image" >

                                @if ($errors->has('contact_image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact_image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <a href="{{ route('contact.index') }}" class="btn btn-primary pull-left"> Back</a>
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
  $("#addContactFrm").validate({

      rules: {
          first_name: {
              required: true
          },
          last_name: {
              required: true
          },
          email: {
              required: true,
              email: true
          },
          primary_phone_no: {
              required: true,
              number: true,
              minlength: 10
          },
          secondary_phone_no: {
              number: true,
              minlength: 10
          },
          contact_image:{
//              extension: "jpg|jpeg|png|JPG|JPEG|PNG"
          }

      },
      messages: {
          first_name: {
              required: "Please enter first name."
          },
          last_name: {
              required: "Please enter last name."
          },
          email: {
              required: "Please enter email address.",
              email: "Please enter valid emial address."
          },
          primary_phone_no: {
              required: "Please enter primary phone no.",
              number: "Please enter digits only.",
              minlength: "Please enter atleast 10 digits."
          },
          secondary_phone_no: {
              number: "Please enter digits only.",
              minlength: "Please enter atleast 10 digits."
          },
          contact_image:{
//              extension: "Please select only jpg|jpeg|png types image."
          }

      },
  });
});
</script>

@endsection

