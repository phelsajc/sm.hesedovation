@extends('admin/layouts.master')
@section('title', 'All Message - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Custom Section</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              <button type="button" class="btn btn-primary btn-sm" onclick="showForm()">Add</button>
            <table id="example1" class="table table-bordered table-striped">
              
              <thead>
              
                <tr>
                  <th>Module</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>    
                  @foreach ($topic as $item)
                      <tr>
                        <td>
                          @if ($item->module==1)
                              User   
                          @elseif ($item->module==2)
                              Course                              
                          @endif
                        </td>
                        <td>
                          {{$item->text}}
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" onclick="edit_a({{$item->id}})">Edit</button>
                        </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Section</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="POST" action="{{url('add_delete_message')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}               
                    <input type="hidden" name="aid" id="id">
                    <div class="col-md-12">
                        <div class="extras-block">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label for="exampleInputDetails">Module :<sup class="redstar">*</sup></label>
                                    <select name="module" id="module" class="form-control">
                                      <option value="1">User</option>
                                      <option value="2">Course</option>
                                    </select>
                                </div>
                            </div>
                          </div>


                          </div>
                          <div class="row">
                            <div class="col-md-6" id="catDiv">
                                <div class="form-group"> 
                                    <label for="exampleInputDetails">Message :<sup class="redstar">*</sup></label>
                                    <textarea name="text" id="text" cols="5" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
               
              
                <div class="box-footer">
                  <button type="submit" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
      getCategories();
    });

    
    function showForm() {
      $("#myModaledit").modal('show')
      $("#id").val('')
    }

    function getCategories() {
      $.ajax({
        type: "get", 
        dataType: "json", 
        url: "{{url('/getCategories')}}",
        success: function(response) {
          $("#cat").empty();
          response.forEach(element => {
            $("#cat").append('<option value="'+element.id+'">'+element.title+'</option>');
          });
        }
      });
    }

    function filter_by(id) {
      if(id==1){
        $("#catDiv").removeClass('hidden')
      }
      else{
        $("#catDiv").addClass('hidden')
      }
    }

    function edit_a(id) {
      $("#myModaledit").modal('show')
      $("#id").val(id)
      $.ajax({
        type: "get", 
        dataType: "json", 
        url: "{{url('get_deleted_message')}}/"+id,
        success: function(response) { 
          $("#text").val(response.text)
          $("#module").val(response.module)
        }
      });      
    }

    function changeStatus(id) {
        $("#status").val(id)
    }
   
</script>
@endsection