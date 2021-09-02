@extends('admin/layouts.master')
@section('title', 'All Message - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Announcement</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              <button type="button" class="btn btn-primary btn-sm" onclick="showForm()">Add</button>
            <table id="example1" class="table table-bordered table-striped">
              
              <thead>
              
                <tr>
                  <th>Announcement</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($topic as $item)
                      <tr>
                        <td>
                          {{$item->text}}
                        </td>
                        <td>
                          {{$item->status==1?'Active':'Inactive'}}
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" onclick="edit_a('{{$item->text}}',{{$item->status}},{{$item->id}})">Edit</button>
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
          <h4 class="modal-title" id="myModalLabel">Announcement</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="POST" action="{{url('add_announcement')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}

               
                    <input type="hidden" name="aid" id="aid">
                    <div class="col-md-12">
                        <div class="extras-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="exampleInputDetails">Announcement :<sup class="redstar">*</sup></label>
                                        <textarea class="form-control" name="announcement" id="announcement"  rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="exampleInputDetails">Active :<sup class="redstar">*</sup></label> <br>
                                        <li class="tg-list-item">  
                                          <input class="tgl tgl-skewed" id="cb3"  type="checkbox"/>
                                          <label class="tgl-btn" data-tg-off="Inactive" data-tg-on="Active" for="cb3"></label>
                                        </li>
                                        <input type="hidden" name="status" value="0" id="test">
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
        
    });

    $(function() {
    $('#cb3').change(function() {
      $('#test').val(+ $(this).prop('checked'))
    })
  })

  $("#cb3").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', '1');
    }
    else {
      $(this).attr('value', '0');
    }});

    function showForm() {
      $("#myModaledit").modal('show')
    }

    function edit_a(text,status,id) {
        $("#aid").val(id);
        $("#announcement").val(text);
        $("#test").val(status);
        if (status==1) {
            $('#cb3').prop('checked', true)
        }
        else {
            $('#cb3').prop('checked',false)
        }
        $("#myModaledit").modal('show')

    }
</script>
@endsection