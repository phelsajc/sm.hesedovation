@extends("admin/layouts.master")
@section('title','All Countries')
@section("body")

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary" >
        <div class="box-header with-border">
          <h3 class="box-title">Country</h3>
          <button type="button" onclick="viewArchive()" class="btn btn-info btn-sm pull-right"><i class="fa fa-archive"></i> View Archive</button>&nbsp;&nbsp;&nbsp;
          <a href=" {{url('admin/country/create')}} " class="btn btn-info btn-sm">+ Add Country</a> 
        </div>
         

        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped table-responsive">
             
              <thead>
                <tr class="table-heading-row">
                  <th>#</th>
                  <th>Country Name </th>
                  <th>ISO Code 2</th>
                  <th>ISO Code 3</th>
                  <th>Actions</th>
                  {{-- <th>Edit</th>
                  <th>Delete</th> --}}
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?> 
                @foreach ($countries as $country)

                  <tr>
                    <?php $i++;?>
                    <td><?php echo $i;?></td>
                    <td>{{ $country->nicename }}</td>
                    <td>{{ $country->iso }}</td>
                    <td>{{ $country->iso3 }}</td>
                    <td>
                        
                        <a class="btn btn-success btn-sm" href="{{url('admin/country/'.$country->id. '/edit')}}">
                         <i class="glyphicon glyphicon-pencil"></i></a>

                         <a title="Archive" data-toggle="modal" data-target="#archive_country{{ $country->id }}" class="btn btn-warning btn-sm">
                           <i class="fa fa-archive"></i>
                         </a>
                         
                        <form  method="post" action="{{url('admin/country/'.$country->id)}}
                          "data-parsley-validate class="form-horizontal form-label-left">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                           <button  type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete This User..?)" ><i class="fa fa-fw fa-trash-o"></i></button></td>
                          </form>
                    </td>
                    {{-- <td>
                      <a class="btn btn-success btn-sm" href="{{url('admin/country/'.$country->id. '/edit')}}">

                        <i class="glyphicon glyphicon-pencil"></i></a>
                    </td>
                    <td><form  method="post" action="{{url('admin/country/'.$country->id)}}
                        "data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                         <button  type="submit" class="btn btn-danger" onclick="return confirm('Delete This User..?)" ><i class="fa fa-fw fa-trash-o"></i></button></td>
                        </form>
                    </td> --}}
                    <div id="archive_country{{ $country->id }}" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to archive this Country ?</p>
                          </div>
                          <div class="modal-footer">
                               <form method="post" action="{{url('admin/country/archive/'.$country->id)}}/1" class="pull-right">
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
              </tbody>
            </table>
          </div>
      
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
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
        $countries = App\Country::where(['isarchive'=>1])->get();
      @endphp
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="table-heading-row">
              <th>Country</th>
              <th>Action</th>
            </tr>
            <tbody>
              @foreach ($countries as $item)
                  <tr>
                    <td>
                      {{$item->name}}
                    </td>
                    <td>
                     
                      <form method="post" action="{{url('admin/country/archive/'.$item->id)}}/0" class="pull-right">
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

@endsection
  

