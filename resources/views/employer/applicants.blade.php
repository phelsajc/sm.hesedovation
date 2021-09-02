@extends('admin/layouts.master')
@section('title', 'All Jobs - {{Auth::user()->name}}')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> {{$get_job_detail->title}}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong>Applicants</strong>
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-condensed">
              <thead>                
                <br>
                <br>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Date Applied</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=0;?>
              @php
                  use App\User;
                use App\Jobs;
                use App\JobsHiring;
              @endphp
              @foreach($get_application_lists as $j)
                <?php $i++;?>
                @php
                  $getUser = User::where(['id' => $j->user_id])->first();
                  $checkHiring = JobsHiring::where(['user_id' => $j->user_id,'job_id' => $get_job_detail->id])->first();                  
                @endphp
                <tr>
                  <td><?php echo $i;?></td>
                  <td>
                    {{$getUser->fname}} {{$getUser->lname}}
                  </td>  
                  <td>                    
                    {{date_format(date_create($j->expiry_dt),'F j, Y')}}                  
                  </td>    
                  <td>                    
                    @if ($checkHiring)
                    <button type="button" class="btn btn-primary btn-sm">Hire</button>
                    @endif                 
                  </td>               
                  <td>
                    <a target="_blank" class="btn btn-warning btn-sm" href="{{url('manage-jobs-applications-convo')}}/{{$get_job_detail->id}}/{{$getUser->id}}/{{$getUser->id}}">View Thread</a>
                    @if (!$checkHiring)
                      <button type="button" class="btn btn-success btn-sm" onclick="hire_this({{$j->user_id}},{{$get_job_detail->id}})">Hire</button>
                    @endif
                  </td>
                  
                  {{-- <td>
                    <form  method="post" action="{{url('order/'.$order->id)}}"
                        data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger">
                            <i class="fa fa-fw fa-trash-o"></i>
                      </button>
                    </form>
                  </td> --}}
                </tr>
              @endforeach 
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

<div id="modalHire" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myLargeModalLabel">Remarks to Applicant</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
              <form id="formUpdate" enctype="multipart/form-data" method="POST">
                  {{ csrf_field() }} 
                  <div class="row">
                      <div class="col-md-12">
                          <label>Remarks <span class="text-danger">*</span></label>
                         <textarea name="remarks" id="remarks" cols="30" rows="10" class="form-control"></textarea>
                      </div>
                  </div>                    
              </form>                                    
          </div>
          <div class="modal-footer">
              <button class="btn btn-info" type="button" onclick="submit_applicant()"><i class="fa fa-save"></i> Submit</button>
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">	

	$(document).ready(function(){
    var get_user;
    var get_job_id;
		tinymce.init({   
        selector: 'textarea#detail', 
        height: 250,
        menubar: 'edit view insert format tools table tc',
        autosave_ask_before_unload: true,
        autosave_interval: "30s",
        autosave_prefix: "{path}{query}-{id}-",
        autosave_restore_when_empty: false,
        autosave_retention: "2m",
        image_advtab: true,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks fullscreen',
          'insertdatetime media table paste wordcount'
        ],
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        content_css: '//www.tiny.cloud/css/codepen.min.css'  
          });
	});

	function hire_this(user_id,job_id) {
    get_user = user_id;
    get_job_id = job_id;
		$('#modalHire').modal({backdrop: 'static', keyboard: false})  
	}	
  
  function submit_applicant() {
    $.ajax({
        type:"post",
        url:  "{{url('hire_this')}}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          remarks: $("#remarks").val(),
          user_id: get_user,
          job_id: get_job_id,
        },
        success:function(data){   
          alert("Hired")
            location = location
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
    });
  }
</script>
@endsection

