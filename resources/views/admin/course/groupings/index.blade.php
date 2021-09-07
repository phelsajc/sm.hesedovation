<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <a data-toggle="modal" data-target="#myModalGroups" href="#" class="btn btn-info btn-sm pull-left" onclick="newGroup()">+ {{ __('adminstaticword.Add') }}</a>

      <div class="table-responsive">
      
        <table id="example1" class="table table-bordered table-striped">

          <thead>
            <br>
            <br>
            <th>#</th>
            <th>Group</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php $i=0;?>
            @foreach($grps as $val)
              <tr>
                <?php $i++;?>
                <td><?php echo $i;?></td>
                <td>{{$val->name}}</td>             
              
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-default">Action</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="javascript:void(0)" onclick="edit_g({{$val->id}})">Edit</a></li>
                      <li><a href="javascript:void(0)" onclick="add_member({{$val->id}})">Add Member</a></li>
                      <li><a href="javascript:void(0)">View Member</a></li>
                      {{-- <li><a href="{{url('admin/quiztopic/'.$val->id)}}">Edit</a></li>
                      <li><a href="{{route('answersheet', $val->id)}}">Delete Answer</a></li>
                      <li><a href="{{route('questions.show', $val->id)}}">Add Question</a></li>
                      <li><a href="{{route('show.quizreport', $val->id)}}">Show Report</a></li>
                      <li class="divider"></li>
                      <li>
                        <form method="post" action="{{url('admin/quiztopic/'.$val->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        <button  type="submit" class="btn btn-danger btn-sm" title="Delete">Delete</button>
                        </form>
                      </li> --}}
                    </ul>
                  </div>                  
                </td>
              </tr>
            @endforeach
          
          </tbody>
        </table>
      </div>


    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!--Model start-->
  <div class="modal fade" id="myModalGroups" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> Groups</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="groupForm" method="post" action="{{url('admin/quiztopic/')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}
               
                <input type="hidden" name="group_id" id="group_id" />
               

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputTit1e">Group Name:<span class="redstar">*</span> </label>
                    <input type="text" placeholder="Enter Group Name" class="form-control " name="name" id="name" value="">
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputDetails">Description:<sup class="redstar">*</sup></label>
                    <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter Description"></textarea>
                  </div>
                </div>
                <br>
              </div>
        
                <div class="box-footer">
                  <button type="button" onclick="save_groups()" class="btn btn-md col-md-3 btn-primary"> {{ __('adminstaticword.Save') }}</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- ADD MEMBER MODAL -->
  <div class="modal fade" id="myModalAddMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"> Add</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="groupForm" method="post" action="{{url('admin/quiztopic/')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}
               
                <input type="hidden" name="group_id" id="group_id" />
               

                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInputTit1e">Group Name:<span class="redstar">*</span> </label>
                    <select name="user_grp_rquest" id="user_grp_rquest" class="form-control" multiple>
                      @foreach ($users_grp as $item)
                          <option value="{{$item->id}}#{{$item->role}}">{{$item->fname}} {{$item->lname}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <br>
              </div>
        
                <div class="box-footer">
                  <button type="button" onclick="add_to_grp()" class="btn btn-md col-md-3 btn-primary"> Add to Group</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Model close -->    
</section>

@section('script_c')

<script type="text/javascript">
  var is_grp_update = false;
var grp_id = 0;
  $(document).ready(function() {    
    $('#user_grp_rquest').select2();
  });

function save_groups() {
    var datas = $('#groupForm').serializeArray();
    
    datas.push({
            name: "course_id",
            value: "{{request()->route('id')}}",
        });
            $.ajax({
                url: is_grp_update?"{{url('/update_group')}}":"{{url('/store_group')}}",
                type: 'post',
                data:datas,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function(data) {
                  location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error.');
                }
            }); 
}

function edit_g(id) {
  is_grp_update = true;
      var datas = $('#groupForm').serializeArray();
              $.ajax({
                  url: "{{url('/edit_group')}}/"+id,
                  type: 'get',
                  dataType: 'JSON',
                  success: function(data) {
                    $("#myModalGroups").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $("#group_id").val(data.id)
                    $("#name").val(data.name)
                    $("#description").val(data.description)
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error.');
                  }
              }); 
  }

  function newGroup() {
    is_grp_update = false;
  }

  function add_member(id) {
    grp_id = id;
                    $("#myModalAddMember").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
  }

  function add_to_grp() {

            $.ajax({
                url: "{{url('/add_member')}}",
                type: 'post',
                data:{
                  user_grp_rquest:$("#user_grp_rquest").val(),
                  grp: grp_id,
                  course: "{{request()->route('id')}}"
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'JSON',
                success: function(data) {
                    $("#myModalAddMember").modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error.');
                }
            }); 
                    
  }

  
</script>

@endsection