@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Generate VCard</div>

                <div class="card-body">
                    <form name="vcardFrm" id="vcardFrm" method="POST" action="{{ route('download.vcard') }}" >
                        @csrf

                       <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th><label>Select Users</label></th>
                            <th><label>User Name</label></th>
                          </tr>
                        </thead>
                        <tbody >
                            @forelse ($contacts as $user)
                                <tr>
                                    <td><input type="checkbox" name="contact_users[]" value="{{ $user->contact_id }}"></td>
                                    <td>{{ $user->contact->first_name.' ' .  $user->contact->last_name }}</td>
                                </tr>
                            @empty
                                <p>No Contacts</p>
                            @endforelse
                        </tbody>
                      </table>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Generate
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
  $("#vcardFrm").validate({

      rules: {
          'contact_users[]': {
              required: true
          }

      },
      messages: {
          'contact_users[]': {
              required: "Please select at least one contact ."
          }

      },
  });
});
</script>
@endsection

