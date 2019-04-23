@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('success_msg'))
            <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
            @endif
            <div class="card">
                <div class="card-header">Shared Conatct List</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table table-bordered" id="contactList">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Acion</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="shareModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="share_form" name="share_form">
                <div class="modal-header">
                    <h4 class="modal-title">Share Contacts</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
                   
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th><label>Select Users</label></th>
                            <th><label>User Name</label></th>
                          </tr>
                        </thead>
                        <tbody id="share_user_tab"></tbody>
                      </table>
                    </div>
                </div>
                <div class="modal-footer">
                     <input type="hidden" name="contact_id" id="contact_id" value="" />
                    <input type="submit" name="submit" id="action" value="Share" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#contactList').DataTable({
            processing: true,
            serverSide: true,
            ajax:'{{ route('contact.shared.list') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'first_name', name: 'first_name'},
                {data: 'middle_name', name: 'middle_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: null,
                    render: function ( data, type, row ) {
                      return '</a><a href="{{ url('contact/shared-details') }}/' + Base64.encode(row.contact_id) + '" class="table-edit btn btn-sm btn-success" data-id="' + row.contact_id + '">Details</a>';
                    }
                }
            ]
        });
    });
    
    
</script>
@endsection
