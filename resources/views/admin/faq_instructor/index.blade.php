@extends('admin/layouts.master')
@section('title', 'All Faq Instructor - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.FAQInstructor') }}</h3>
          <button type="button" onclick="viewArchive()" class="btn btn-info btn-sm pull-right"><i class="fa fa-archive"></i> View Archive</button>&nbsp;&nbsp;&nbsp;
          <a href="{{url('faqinstructor/create')}}" class="btn btn-info btn-sm">+ {{ __('adminstaticword.Add') }}</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              
              <tr>
                <th>#</th>
                <th>{{ __('adminstaticword.Title') }}</th>
                <th>{{ __('adminstaticword.Detail') }}</th>
                <th>{{ __('adminstaticword.Status') }}</th>
                <th>{{-- {{ __('adminstaticword.Edit') }} --}}Action</th>
                {{-- <th>{{ __('adminstaticword.Delete') }}</th> --}}
              </tr>
            </thead>
            <tbody>
            @foreach($faq as $key=>$p)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$p->title}}</td>                 
                <td>{{ str_limit(strip_tags($p->details), $limit = 50, $end = '...') }}</td>
                <td>
                  <form action="{{ route('faqInstructor.quick',$p->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button type="Submit" class="btn btn-xs {{ $p->status ==1 ? 'btn-success' : 'btn-danger' }}">
                      @if($p->status ==1)
                      {{ __('adminstaticword.Active') }}
                      @else
                      {{ __('adminstaticword.Deactive') }}
                      @endif
                    </button>
                  </form>
                </td>
                <td>
                  <a class="btn btn-success btn-sm" href="{{url('faqinstructor/'.$p->id.'/edit')}}">
                    <i class="glyphicon glyphicon-pencil"></i></a>
                    <a title="Delete" data-toggle="modal" data-target="#faq_ins{{ $p->id }}" class="btn btn-danger btn-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                    <a title="Archive" data-toggle="modal" data-target="#archive_faq{{ $p->id }}" class="btn btn-warning btn-sm">
                      <i class="fa fa-archive"></i>
                    </a>
                </td>
                {{-- <td>
                  <form  method="post" action="{{url('faqinstructor/'.$p->id)}}"
                      data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger">
                          <i class="fa fa-fw fa-trash-o"></i>
                    </button>
                  </form>
                </td> --}}
                <div id="faq_ins{{ $p->id }}" class="delete-modal modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="delete-icon"></div>
                      </div>
                      <div class="modal-body text-center">
                        <h4 class="modal-heading">Are You Sure ?</h4>
                        <p>Do you really want to delete this Record ? This process cannot be undone.</p>
                      </div>
                      <div class="modal-footer">
                           <form method="post" action="{{url('faqinstructor/'.$p->id)}}" class="pull-right">
                              {{csrf_field()}}
                              {{method_field("DELETE")}}
                           <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                      </div>
                    </div>
                  </div>
              </div>

              
              <div id="archive_faq{{ $p->id }}" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to archive this FAQ ?</p>
                    </div>
                    <div class="modal-footer">
                         <form method="post" action="{{url('admin/faq_instructor/archive/'.$p->id)}}/1" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("POST")}}
                         <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              </tr>
            @endforeach 
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>


<div id="archive_modal" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        
        @php
        $faq_archive = App\FaqInstructor::where(['isarchive'=>1])->get();
      @endphp
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="table-heading-row">
              <th>Title</th>
              <th>Action</th>
            </tr>
            <tbody>
              @foreach ($faq_archive as $item)
                  <tr>
                    <td>
                      {{$item->title}}
                    </td>
                    <td>
                     
                      <form method="post" action="{{url('admin/faq_instructor/archive/'.$item->id)}}/0" class="pull-right">
                        {{csrf_field()}}
                        {{method_field("POST")}}
                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                  </form>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
@endsection

@section('script_c')

<script type="text/javascript">

  $(document).ready(function() {    
    
  });

  function viewArchive() {
    $("#archive_modal").modal('show')
  }


</script>