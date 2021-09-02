@extends('admin/layouts.master')
@section('title', 'All Report - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.ReportCourse') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              
                <tr>
                  <th>#</th>
                  <th>{{ __('adminstaticword.User') }}</th>
                  <th>{{ __('adminstaticword.Course') }}</th>
                  <th>{{ __('adminstaticword.Title') }}</th>
                  <th>{{ __('adminstaticword.Email') }}</th>
                  <th>{{ __('adminstaticword.Detail') }}</th>
                  <th>{{-- {{ __('adminstaticword.Edit') }} --}}Actions</th>
                  {{-- <th>{{ __('adminstaticword.Delete') }}</th> --}}
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach($items as $item)
                  <?php $i++;?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{$item->user['fname']}}</td>
                    <td>{{$item->courses['title']}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{ str_limit($item->detail, $limit=50, $end="...")}}</td>
                    <td>
                      <a class="btn btn-primary btn-sm" href="{{url('user/course/report/'.$item->id)}}">
                      <i class="glyphicon glyphicon-pencil"></i></a>
                      <a title="Delete" data-toggle="modal" data-target="#report_course{{ $item->id }}" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                    {{-- <td>
                      <form  method="post" action="{{url('user/course/report/'. $item->id)}}
                        "data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                         <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                      </form>
                    </td> --}}
                    <div id="report_course{{ $p->id }}" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to delete this Report ? This process cannot be undone.</p>
                          </div>
                          <div class="modal-footer">
                               <form method="post" action="{{url('user/course/report/'. $item->id)}} class="pull-right">
                                  {{csrf_field()}}
                                  {{method_field("DELETE")}}
                               <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                              <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                          </div>
                        </div>
                      </div>
                  </div>
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

@endsection
