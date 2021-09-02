@extends('admin/layouts.master')
@section('title', 'Edit Course - Admin')
@section('body')

<section class="content">

	@include('admin.message')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{$course_title}}</h3>
                {{-- <a class="btn btn-info btn-sm" href="{{url('course/create')}}">
                  <i class="glyphicon glyphicon">+</i> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}
                </a> --}}
            </div>            
                <div class="box-body">
                <div class="table-responsive">
                    <table id="tblCourseMember" class="table table-bordered table-striped compact">
                        <thead>
                            <tr>
                            <th>Student</th>
                            <th>Image</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($course_data as $value)
                            <tr>
                              <td>{{$value['student']}}</td>
                              <td>
                                  @if($value['img']!=null) 
                                    <img src="{{URL::to('/')}}/images/user_img/{{$value['img']}}" class="img-responsive"> 
                                  @endif
                              </td>
                              <td><button type="button" class="btn btn-sm btn-success" onclick="view_progress({{$value['id']}},{{$value['uid']}})">View</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>     	
</section>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
        
    });

    function view_progress(id,uid) {
        location = "{{URL::to('/')}}"+'/show_student_detail/'+id+"/"+uid;
    }
</script>
@endsection
  