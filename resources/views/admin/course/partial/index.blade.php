@include('admin.message')
<style>
  .course-draft{
    background-color: #313131;
    color: white;
}
.dd{
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    /* color: #333; */
    /* white-space: nowrap; */
    color: #777;
}
</style>
@php        
use App\Delete_messages;
        use App\User;
@endphp
@php        
  $get_message = Delete_messages::where('module',2)->first();
@endphp
<div class="row">
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('adminstaticword.Course') }}</h3>

        <div style="text-align: center">         
          <button type="button" onclick="viewArchive()" class="btn btn-info btn-sm pull-right"><i class="fa fa-archive"></i> View Archive</button>
          &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;
          <a class="btn btn-info btn-sm" href="{{url('course/create')}}">
            <i class="glyphicon glyphicon">+</i> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}
          </a>
      </div>

       
        <button type="button" class="btn btn-xs btn-info" onclick="view_statuses()">Course Status</button>
      </div>
     
      <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">

              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('adminstaticword.Image') }}</th>
                  <th>{{ __('adminstaticword.Title') }}</th>
                  <th>{{ __('adminstaticword.Instructor') }}</th>
                  <th>{{ __('adminstaticword.Type') }}</th>
                  @if(Auth::User()->role == "admin")<th>{{ __('adminstaticword.Featured') }}</th>@endif
                  {{-- @if(Auth::User()->role == "admin")<th>{{ __('adminstaticword.Status') }}</th>@endif --}}
                  <th>{{ __('adminstaticword.Status') }}</th>
                  {{-- @if(Auth::User()->role == "admin")<th>Action</th>@endif --}}
                  <th>&nbsp;</th>
                  {{-- <th>{{ __('adminstaticword.Edit') }}</th>
                  <th>{{ __('adminstaticword.Delete') }}</th> --}}
                </tr>
              </thead>

              <tbody>
                <?php $i=0;?>
                  @if(Auth::User()->role == "admin")
                    @foreach($course as $cat)
                      <?php $i++;?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td>
                          @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                              <img src="images/course/<?php echo $cat['preview_image'];  ?>" class="img-responsive" >
                          @else
                              <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-responsive" >
                          @endif
                        </td>
                        <td>{{$cat->title}}</td>
                        <td>{{ $cat->user['fname'] }}</td>
                        <td>
                          @if($cat->type == '1')
                            Paid
                          @else
                            Free
                          @endif
                        </td>
                        <td>
                          <form action="{{ route('course.featured',$cat->id) }}" method="POST">
                            {{ csrf_field() }}
                            <button  type="Submit" class="btn btn-xs {{ $cat->featured ==1 ? 'btn-success' : 'btn-danger' }}">
                              @if($cat->featured ==1)
                              {{ __('adminstaticword.Yes') }}
                              @else
                              {{ __('adminstaticword.No') }}
                              @endif
                            </button>
                          </form>
                        </td>
                         
                        <td>
                          @if($cat->status ==1)
                             <button type="button" class="btn btn-xs course-accepted"> Accepted </button>
                            @elseif($cat->status ==6)
                             <button type="button" class="btn btn-xs btn-danger"> Rejected </button>
                            @elseif($cat->status ==0)                             
                              <button type="button" class="btn btn-xs course-new"> New </button>
                            @elseif($cat->status ==2)                             
                              <button type="button" class="btn btn-xs course-draft"> Draft </button>
                            @elseif($cat->status ==7)                             
                              <button type="button" class="btn btn-xs btn-warning"> Live </button>
                            @endif

                          {{-- <form action="{{ route('course.quick',$cat->id) }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" id="st_{{$cat->id}}" name="st_{{$cat->id}}">
                            @if($cat->status ==6||$cat->status ==0||$cat->status ==1)
                              @if($cat->status ==6||$cat->status ==0)
                                <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-success">
                                    {{ __('adminstaticword.Active') }}
                                </button>
                              @endif

                            
                              @if($cat->status ==1||$cat->status ==7)
                                <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-danger">
                                    {{ __('adminstaticword.Deactive') }}
                                </button>
                              @endif
                            @endif
                          </form>
                          
                          <form action="{{ route('course.quick_reject',$cat->id) }}" method="POST">
                            {{ csrf_field() }}
                            @if($cat->status ==0||$cat->status ==1||$cat->status ==7)
                              <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-danger">
                                Reject
                              </button>
                            @endif
                          </form>
                          
                          @if($cat->status ==1)
                            <form action="/quickupdate/course_live/{{ $cat->id }}" method="POST">
                              {{ csrf_field() }}
                                <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-warning">
                                  Live this Course
                                </button>
                            </form>
                          @endif --}}
                          
                        </td>

                        <td>

                          <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li>
                                <form action="{{ route('course.quick',$cat->id) }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" id="st_{{$cat->id}}" name="st_{{$cat->id}}">
                                  @if($cat->status ==6||$cat->status ==0||$cat->status ==1)
                                    @if($cat->status ==6||$cat->status ==0)
                                      <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="dd btn-danger">
                                          {{ __('adminstaticword.Active') }}
                                      </button>
                                    @endif      
                                  
                                    @if($cat->status ==1||$cat->status ==7)
                                      <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="dd btn-danger">
                                          {{ __('adminstaticword.Deactive') }}
                                      </button>
                                    @endif
                                  @endif
                                </form>
                              </li>

                              <li>
                                <form action="{{ route('course.quick_reject',$cat->id) }}" method="POST">
                                  {{ csrf_field() }}
                                  @if($cat->status ==0||$cat->status ==1||$cat->status ==7)
                                    <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn-danger dd">
                                      Reject
                                    </button>
                                  @endif
                                </form>
                              </li>

                              <li>
                                @if($cat->status ==1)
                                  <form action="quickupdate/course_live/{{ $cat->id }}" method="POST">
                                    {{ csrf_field() }}
                                      <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="dd btn-danger">
                                        Live this Course
                                      </button>
                                  </form>
                                @endif
                              </li>

                              <li>
                                <form>
                                <button  type="button" onclick="goTo('{{ route('course.show',$cat->id) }}')" class="dd btn-danger">
                                  Edit
                                </button>
                                </form>
                              </li>

                              <li>
                                <form>
                                  <button  type="button" title="Delete" data-toggle="modal" data-target="#course_modal{{ $cat->id }}" class="dd btn-danger">
                                    Delete
                                  </button>
                                </form>
                              </li>

                              
                              <li>
                                <form>
                                  <button type="button" title="Archive" data-toggle="modal" data-target="#archive_course{{ $cat->id }}" class="dd btn-danger">
                                    Archive
                                  </button>
                                </form>
                              </li>

                            </ul>
                          </div>
                            
                           {{--  <form action="{{ route('course.quick',$cat->id) }}" method="POST">
                              {{ csrf_field() }}
                              <input type="hidden" id="st_{{$cat->id}}" name="st_{{$cat->id}}">
                              @if($cat->status ==6||$cat->status ==0||$cat->status ==1)
                                @if($cat->status ==6||$cat->status ==0)
                                  <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-success">
                                      {{ __('adminstaticword.Active') }}
                                  </button>
                                  <a href="#" onclick="$(this).closest('form').submit()">Active 2</a>
                                @endif
  
                              
                                @if($cat->status ==1||$cat->status ==7)
                                  <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-danger">
                                      {{ __('adminstaticword.Deactive') }}
                                  </button>
                                @endif
                              @endif
                            </form>
                            
                            <form action="{{ route('course.quick_reject',$cat->id) }}" method="POST">
                              {{ csrf_field() }}
                              @if($cat->status ==0||$cat->status ==1||$cat->status ==7)
                                <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-danger">
                                  Reject
                                </button>
                              @endif
                            </form>
                            
                            @if($cat->status ==1)
                              <form action="quickupdate/course_live/{{ $cat->id }}" method="POST">
                                {{ csrf_field() }}
                                  <button  type="Submit" onclick="changeStat({{$cat->status}},{{$cat->id}})" class="btn btn-xs btn-warning">
                                    Live this Course
                                  </button>
                              </form>
                            @endif

                          <a class="btn btn-success btn-xs" href="{{ route('course.show',$cat->id) }}" title="Edit">
                            <i class="glyphicon glyphicon-pencil"></i>
                          </a>                            

                          <a title="Delete" data-toggle="modal" data-target="#course_modal{{ $cat->id }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i>
                          </a>
                          
                          <a title="Archive" data-toggle="modal" data-target="#archive_course{{ $cat->id }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-archive"></i>
                          </a> --}}  
                                                 
                        </td>
                        

                        <div id="course_modal{{ $cat->id }}" class="delete-modal modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="delete-icon"></div>
                              </div>
                              <div class="modal-body text-center">
                                <h4 class="modal-heading">COURSE</h4>
                                <p>{{$get_message->text}}</p>
                              </div>
                              <div class="modal-footer">
                                <form method="post" action="{{url('course/'.$cat->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                      {{csrf_field()}}
                                      {{method_field("DELETE")}}
                                  <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                  <button type="submit" class="btn btn-danger">Yes</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div id="archive_course{{ $cat->id }}" class="delete-modal modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="delete-icon"></div>
                              </div>
                              <div class="modal-body text-center">
                                <h4 class="modal-heading">Are You Sure ?</h4>
                                <p>Do you really want to archive this Course ?</p>
                              </div>
                              <div class="modal-footer">
                                   <form method="post" action="{{url('admin/course/archive/'.$cat->id)}}/1" class="pull-right">
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
                  @else
                  
                    @php
                      $cors = App\Course::where(['user_id' => Auth::User()->id,'isarchive' => 0])->get();
                    @endphp
                    @foreach($cors as $cor)
                      <?php $i++;?>
                      <tr>
                        <td><?php echo $i;?></td>
                        <td>
                          @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                              <img src="images/course/<?php echo $cor['preview_image'];  ?>" class="img-responsive">
                          @else
                              <img src="{{ Avatar::create($cor->title)->toBase64() }}" class="img-responsive" >
                          @endif
                        </td>
                        <td>{{$cor->title}}</td>
                        <td>{{ $cor->user['fname'] }}</td>
                        {{-- <td>{{$cor->slug}}</td> --}}
                         
                        <td>
                          
                          @if($cor->status ==1)
                            {{-- {{ __('adminstaticword.Active') }} --}}
                            <button  type="button" title="Accepted" class="btn btn-xs course-accepted">Accepted</button>
                            @elseif($cor->status ==0)
                              {{-- {{ __('adminstaticword.Deactive') }} --}} 
                              <button  type="button" title="Pending" class="btn btn-xs course-pending">Pending</button>
                              @elseif($cor->status ==6)
                                {{-- {{ __('adminstaticword.Deactive') }} --}} 
                                <button  type="button" title="Rejected" class="btn btn-xs btn-danger">Rejected</button>
                              @elseif($cor->status ==2)
                                {{-- {{ __('adminstaticword.Deactive') }} --}} 
                                <button  type="button" title="Draft" class="btn btn-xs course-draft">Draft</button>
                              @elseif($cor->status ==7)
                                {{-- {{ __('adminstaticword.Deactive') }} --}} 
                                <button  type="button" title="Live" class="btn btn-xs btn-warning">Live</button>
                          @endif
                            
                        </td>

                        <td>
                          @if($cor->type == '1')
                            Paid
                          @else
                            Free
                          @endif
                        </td>
                        {{-- <td>
                         
                          @if($cor->featured ==1)
                            {{ __('adminstaticword.Yes') }}
                          @else
                            {{ __('adminstaticword.No') }}
                          @endif
                          
                        </td> --}}

                       

                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              {{-- <li>
                                <form action="{{ route('course.quick',$cor->id) }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" id="st_{{$cor->id}}" name="st_{{$cor->id}}">
                                  @if($cor->status ==6||$cor->status ==0||$cor->status ==1)
                                    @if($cor->status ==6||$cor->status ==0)
                                      <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="dd btn-danger">
                                          {{ __('adminstaticword.Active') }}
                                      </button>
                                    @endif      
                                  
                                    @if($cor->status ==1||$cor->status ==7)
                                      <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="dd btn-danger">
                                          {{ __('adminstaticword.Deactive') }}
                                      </button>
                                    @endif
                                  @endif
                                </form>
                              </li>
                        
                              <li>
                                <form action="{{ route('course.quick_reject',$cor->id) }}" method="POST">
                                  {{ csrf_field() }}
                                  @if($cor->status ==0||$cor->status ==1||$cor->status ==7)
                                    <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn-danger dd">
                                      Reject
                                    </button>
                                  @endif
                                </form>
                              </li> --}}
                        
                              <li>
                                @if($cor->status ==1)
                                <form action="{{ route('course.quick_live2',$cor->id) }}" method="POST">
                                  {{ csrf_field() }}
                                    <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="dd btn-danger">
                                      Live this Course
                                    </button>
                                </form>
                                @endif
                              </li>
                        
                              <li>
                                <form>
                                <button  type="button" onclick="goTo('{{ route('course.show',$cor->id) }}')" class="dd btn-danger">
                                  Edit
                                </button>
                                </form>
                              </li>
                        
                              <li>
                                <form>
                                  <button  type="button" title="Delete" data-toggle="modal" data-target="#course_modal{{ $cor->id }}" class="dd btn-danger">
                                    Delete
                                  </button>
                                </form>
                              </li>
                        
                              
                              <li>
                                <form>
                                  <button type="button" title="Archive" data-toggle="modal" data-target="#archive_course{{ $cor->id }}" class="dd btn-danger">
                                    Archive
                                  </button>
                                </form>
                              </li>
                        
                            </ul>
                          </div>
{{-- xxxxxxxxxxxxxxxxxxxxxxxxxx
                          
                          <a class="btn btn-warning btn-sm" title="Edit" href="{{ route('course.show',$cor->id) }}">
                          <i class="glyphicon glyphicon-pencil"></i></a>
                          
                          @if($cor->status ==1)
                          
                          <form action="{{ route('course.quick_live2',$cor->id) }}" method="POST">
                            {{ csrf_field() }}
                              <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn btn-xs btn-warning">
                                Live this Course 2
                              </button>
                          </form>
                          @endif

                          
                          <a title="Delete" data-toggle="modal" data-target="#course_modal{{ $cor->id }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                          </a>

                          <a title="Archive" data-toggle="modal" data-target="#archive_course{{ $cor->id }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-archive"></i>
                          </a> --}}
                        </td>


                        <div id="course_modal{{ $cor->id }}" class="delete-modal modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="delete-icon"></div>
                              </div>
                              <div class="modal-body text-center">
                                <h4 class="modal-heading">COURSE</h4>
                                <p>{{$get_message->text}}</p>
                              </div>
                              <div class="modal-footer">
                                <form method="post" action="{{url('course/'.$cor->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                      {{csrf_field()}}
                                      {{method_field("DELETE")}}
                                  <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                                  <button type="submit" class="btn btn-danger">Yes</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div id="archive_course{{ $cor->id }}" class="delete-modal modal fade" role="dialog">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="delete-icon"></div>
                              </div>
                              <div class="modal-body text-center">
                                <h4 class="modal-heading">Are You Sure ?</h4>
                                <p>Do you really want to archive this Course ?</p>
                              </div>
                              <div class="modal-footer">
                                   <form method="post" action="{{url('admin/course/archive/'.$cor->id)}}/1" class="pull-right">
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
                  @endif
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

<div class="modal fade" id="modalCourseStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Announcement</h4>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <table class="table table-bordered table-striped condensed">
              <thead>
                <tr>
                  <th></th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs course-draft"> Draft </button>
                  </td>
                  <td>
                    Course in Draft stage
                  </td>
                </tr>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs course-new"> New </button>
                  </td>
                  <td>
                    Course submitted for admin approval (email notification)
                  </td>
                </tr>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs course-pending"> Pending </button>
                  </td>
                  <td>
                    Course pending Admin approval
                  </td>
                </tr>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs course-accepted"> Accepted </button>
                  </td>
                  <td>
                    Course Approved by Admin (email notification to vendor)
                  </td>
                </tr>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs btn-danger"> Declined </button>
                  </td>
                  <td>
                    Course Declined by Admin (email notification to vendor)
                  </td>
                </tr>
                <tr>
                  <td>
                    <button  type="button" class="btn btn-xs btn-warning"> In progress </button>
                  </td>
                  <td>
                    Course is Published and is Live
                  </td>
                </tr>
                
                
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

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
          if(Auth::User()->role == "admin"){
            $countries = App\Course::where(['isarchive'=>1])->get();
          }else{
            $countries = App\Course::where(['isarchive'=>1,'user_id' =>Auth::user()->id])->get();
          }
      @endphp
        <table class="table table-bordered table-striped" id="tblArchive">
          <thead>
            <tr class="table-heading-row">
              <th>Country</th>
              @if(Auth::User()->role == "admin") 
              <th>User</th>
              @endif
              <th>Action</th>
            </tr>
            <tbody>
              @foreach ($countries as $item)
                  <tr>
                    <td>
                      {{$item->title}}
                    </td>
                      @if(Auth::User()->role == "admin") 
                      <td>
                        @php
                            $getUser = User::where(['id' => $item->user_id])->first();
                        @endphp
                        {{$getUser->fname}} {{$getUser->lname}}
                      </td>
                      @endif
                    <td>
                     
                      <form method="post" action="{{url('admin/course/archive/'.$item->id)}}/0" class="pull-right">
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
@section('script_c')

<script type="text/javascript">

  $(document).ready(function() {    
    $("#tblArchive").DataTable();
  });

  function view_statuses() {
    $("#modalCourseStatus").modal('show')
  }
  
  function changeStat(params,id) {
    $("#st_"+id).val(params)
    return false;
  }

  function changeStat2(params,id) {
    $("#st2_"+id).val(params)
    return false;
  }
  

  function viewArchive() {
    $("#archive_modal").modal('show')
  }

function goTo(params) {
  location = params
}

</script>

@endsection