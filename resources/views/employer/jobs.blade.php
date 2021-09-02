@extends('admin/layouts.master')
@section('title', 'All Jobs - {{Auth::user()->name}}')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> All Jobs</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                
                <br>
                <br>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Level</th>
                  <th>Budget</th>
                  <th>Duration</th>
                  <th>Expiry</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $i=0;?>
              @foreach($get_job_list as $j)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  <td>
                    {{$j->title}}
                  </td>                 
                  <td>
                    @if($j->level == 1)
                     Basic Level
                    @elseif($j->level == 2)
                          Meduim Level
                    @elseif($j->level == 3)
                           Expert level
                    @endif
                    
                  </td>
                  <td>{{$j->cost}}</td>
                  <td>
                    @if($j->time_frame == 1)
                      Less than a week
                    @elseif($j->time_frame == 2)
                           Less than a month
                    @elseif($j->time_frame == 3)
                           1 to 3 months
                    @elseif($j->time_frame == 4)
                           3 to 6 months
                    @elseif($j->time_frame == 5)
                           more than 6 months
                    @endif
                  </td>
                  <td>
                    
                    {{date_format(date_create($j->expiry_dt),'F j, Y')}}
                  
                  </td>               
                  <td>
                    <a class="btn btn-primary btn-sm" href="{{url('edit-job')}}/{{$j->id}}">Edit</a>
                    <a class="btn btn-success btn-sm" href="{{url('job-detail')}}/{{$j->id}}">View Job</a>
                    <a class="btn btn-warning btn-sm" href="{{url('all-applicants')}}/{{$j->id}}">View Applicants</a>
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
@endsection
