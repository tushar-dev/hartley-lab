@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('success_msg'))
            <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
            @endif
            <div class="card">
                <div class="card-header">Conatct List</div>
                <div class="card-header"><a href="{{ route('contact.add') }}">Add Contact </a></div>
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
            ajax:'{{ route('contact.list') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'first_name', name: 'first_name'},
                {data: 'middle_name', name: 'middle_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: null,
                    render: function ( data, type, row ) {
                        console.log(row.contact_id);
                      return '</a><a href="{{ url('contact/details') }}/' + Base64.encode(row.contact_id) + '" class="table-edit btn btn-sm btn-success" data-id="' + row.contact_id + '">Details</a>\n\
                            <a href="{{ url('contact/edit') }}/' + Base64.encode(row.contact_id) + '" class="table-edit btn btn-sm btn-success" data-id="' + row.contact_id + '">Edit\n\
                            </a><a href="javascript:void(0);" class="table-edit btn btn-sm btn-success share" data-id="' + row.contact_id + '">Share</a>\n\
                            </a><a href="javascript:void(0);" class="table-edit btn btn-sm btn-success delete" data-id="' + row.contact_id + '" >Delete</a>';
                    }
                }
            ]
        });
    });
    
    $(document).on('click', '.share', function(){
        var id = $(this).attr("data-id");
        $("#contact_id").val(id);
        $.ajax({
            url:"{{route('contact.user.list')}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                if(data.length>0){
                    var str = '';
                    
                    $.each(data, function (index, value) {
                        str += '<tr>';
                        str += '<td>';
                        str += '<input type="checkbox" name="share_to_users[]" id="share_to_users" class="checkboxClass" value="'+value.user_id+'">';
                        str += '</td>';
                        str += '<td>';
                        str += value.name ;
                        str += '</td>';
                         str += '</tr>';
                     });   
                    
                     $('#share_user_tab').html(str);
                } else {
                    $('#share_user_tab').html('');
                }
                $('#shareModal').modal('show');
            }
        })
    });
    $(document).ready(function(){
        $('#share_form').on('submit', function(event){
            event.preventDefault();
            var user_ids = new Array();
                jQuery(".checkboxClass:checked").each(function(){
                    user_ids.push($(this).val());
                });
            var contact_id = $("#contact_id").val();   
            var _token = $("input[name='_token']").val();
            if(user_ids.length > 0){    
            $.ajax({
                url:"{{route('contact.share.update')}}",
                method:"POST",
                data:{
                    share_to_users : user_ids,
                    contact_id : contact_id,
                    _token:_token
                },
                success:function(data)
                {
                    alert(data);
                    $('#share_form')[0].reset();
                    $('#shareModal').modal('hide');
                }
            })
        }
        });
    });
    
    
     $(document).on('click', '.delete', function(){
        var id = $(this).attr('data-id');
        if(confirm("Are you sure you want to Delete this data?"))
        {
            $.ajax({
                url:"{{route('contact.delete')}}",
                mehtod:"get",
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#contactList').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    });
</script>
@endsection
