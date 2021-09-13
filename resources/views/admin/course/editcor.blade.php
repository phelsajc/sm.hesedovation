
@php        
use App\Delete_messages;
@endphp
@php        
  $get_message = Delete_messages::where('module',2)->first();
@endphp
<section class="content">
  {{-- @include('admin.message') --}}
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Course') }}</h3>
        </div>
        <br>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <form action="{{route('course.update',$cor->id)}}" id="form" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}  
              {{ method_field('PUT') }}
             
              <div class="row">
                <div class="col-md-4">
                  <label>{{ __('adminstaticword.Category') }}<span class="redstar">*</span></label>
                  <select name="category_id" id="category_id" class="form-control js-example-basic-single" required>
                    <option value="0">{{ __('adminstaticword.SelectanOption') }}</option>
                    @php
                      $category = App\Categories::all();
                    @endphp 

                    @foreach($category as $caat)
                      <option {{ $cor->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                    @endforeach 
                  </select>
                  <input type="hidden" name="isdraft" id="isdraft">
                </div>
                <div class="col-md-4">
                  <label>{{ __('adminstaticword.SubCategory') }}<span class="redstar">*</span></label>
                  <select name="subcategory_id" id="upload_id" class="form-control js-example-basic-single">
                    @php
                      $subcategory =App\SubCategory::where('category_id', $cor->category_id)->get();
                    @endphp
                     <option value="none" selected disabled hidden> 
                        {{ __('frontstaticword.SelectanOption') }}
                      </option>
                    @if(!empty($subcategory))
                    @foreach($subcategory as $caat)
                      <option {{ $cor->subcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                    @endforeach
                    @endif

                   

                  </select>
                </div>
                <div class="col-md-4">
                  <label>{{ __('adminstaticword.ChildCategory') }}</label>
                  <select name="childcategory_id" id="grand" class="form-control js-example-basic-single">
                    @php
                      $childcategory = App\ChildCategory::where('subcategory_id', $cor->subcategory_id)->get();
                    @endphp 
                     <option value="none" selected disabled hidden> 
                        {{ __('frontstaticword.SelectanOption') }}
                      </option>
                    @if(!empty($childcategory))
                    @foreach($childcategory as $caat)
                      <option {{ $cor->childcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>     
                <div class="col-md-3 display-none">
                  @php
                    $User = App\User::all();
                  @endphp
                  <label for="exampleInputSlug">{{ __('adminstaticword.SelectUser') }}</label>
                  <select name="user" class="form-control js-example-basic-single col-md-7 col-xs-12">
                    <option  value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                  </select>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-6"> 
                  @php
                      $languages = App\CourseLanguage::all();
                  @endphp
                  <label for="exampleInputSlug">{{ __('adminstaticword.SelectLanguage') }}</label>
                  <select name="language_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                     <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>
                    @foreach($languages as $cat)
                      <option {{ $cor->language_id == $cat->id ? 'selected' : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                  </select>
                </div>


                <div class="col-md-6"> 
                    
                    @php
                        $ref_policy = App\RefundPolicy::all();
                    @endphp
                    <label for="exampleInputSlug">{{ __('adminstaticword.SelectRefundPolicy') }}</label>
                    <select name="refund_policy_id" class="form-control js-example-basic-single col-md-7 col-xs-12">
                      <option value="none" selected disabled hidden> 
                        {{ __('frontstaticword.SelectanOption') }}
                      </option>
                      @foreach($ref_policy as $ref)
                        <option {{ $cor->refund_policy_id == $ref->id ? 'selected' : "" }} value="{{ $ref->id }}">{{ $ref->name }}</option>
                      @endforeach
                    </select>
                </div>
                  
                  
                </div>
              
              <br>

               @if(Auth::User()->role == "admin")

               <div class="row">


                <div class="col-md-12"> 
                    <label for="exampleInputSlug">{{ __('adminstaticword.SelectTags') }}</label>
                  <select class="form-control js-example-basic-single" name="tags">
                     <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>

                    <option {{ $cor->tags == 'new' ? 'selected' : ''}} value="new">New</option>

                    <option {{ $cor->tags == 'trending' ? 'selected' : ''}} value="trending">Trending</option>

                    <option {{ $cor->tags == 'onsale' ? 'selected' : ''}} value="onsale">Onsale</option>

                    <option {{ $cor->tags == 'featured' ? 'selected' : ''}} value="featured">Featured</option>

                    <option {{ $cor->tags == 'bestseller' ? 'selected' : ''}} value="bestseller">Bestseller</option>
                    
                  </select>
                  


                  </div>

              </div>
              <br>
              <br>

              @endif

              <div class="row">

                <div class="col-md-6"> 
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
                </div>
                
                <div class="col-md-6">
                  <label for="exampleInputSlug">{{ __('adminstaticword.Slug') }} <sup class="redstar">*</sup></label>
                  <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputPassword1" value="{{ $cor->slug}}" required>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('adminstaticword.ShortDetail') }}<sup class="redstar">*</sup></label>
                  <textarea name="short_detail" rows="3" class="form-control" >{!! $cor->short_detail !!}</textarea>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Requirements') }}<sup class="redstar">*</sup></label>
                  <textarea name="requirement" id="requirement" rows="3" class="form-control" required >{!! $cor->requirement !!}</textarea>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}</label>
                  <textarea id="detail" name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
                </div>
              </div>
              <br>

             

              <div class="row">
                <div class="col-md-3 display-none">
                  <label for="exampleInputDetails">{{ __('adminstaticword.MoneyBack') }}</label>
                  <li class="tg-list-item">
                    <input  class="tgl tgl-skewed" id="rox" type="checkbox" @if($cor->day !="" && $cor->day !="") checked @endif/>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="rox" ></label>
                  </li>
                  <input type="hidden" name="money" value="0" id="roxx">
                  <br>     

                  <div @if($cor->day =="" && $cor->day =="") class="display-none" @endif id="jeet">
                    <label for="exampleInputSlug">{{ __('adminstaticword.Days') }}<sup class="redstar">*</sup></label>
                    <input type="number" min="1"  class="form-control" name="day" id="exampleInputPassword1" placeholder="" value="{{ $cor->day }}">
                  </div>
                </div>
                <div class="col-md-3">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Free') }}</label>  
                  <li class="tg-list-item"> 
                    <input  class="tgl tgl-skewed" id="cb111" name="type" type="checkbox" {{ $cor->type == '1' ? 'checked' : '' }}/>
                    <label class="tgl-btn" data-tg-off="Free" data-tg-on="Paid" for="cb111" ></label>
                  </li>
                  <input type="hidden" name="free" value="0" id="j111">
                  <br>     

                  <div @if($cor->type ==  '0') class="display-none" @endif id="doabox">
                    <label for="exampleInputSlug">{{ __('adminstaticword.Price') }} <sup class="redstar">*</sup></label>
                    <input type="number" step="0.01"   class="form-control" name="price" id="exampleInputPassword1" placeholder="" value="{{ $cor->price }}">
                  </div>

                  <div @if($cor->type ==  '0') class="display-none" @endif id="doaboxx">
                  <br>
                    <label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }} <sup class="redstar">*</sup></label>
                    <input type="number" step="0.01"  class="form-control" name="discount_price" id="exampleInputPassword1" placeholder="" value="{{ $cor->discount_price }}">
                  </div>
                </div>
                <div class="col-md-3"> 
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Featured') }}</label>
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb1" type="checkbox"{{ $cor->featured==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="cb1"></label>
                  </li>
                  <input type="hidden" name="featured" value="{{ $cor->featured }}" id="f">
                  @endif
                </div>
                <div class="col-md-3">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}</label>
                    <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb333" type="checkbox" {{ $cor->status==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb333"></label>
                    </li>
                    <input type="hidden" name="status" value="{{ $cor->status }}" id="c33">
                  @endif
                </div>

                <div class="col-sm-3">
                  <label for="exampleInputDetails">{{ __('adminstaticword.InvolvementRequest') }}</label>                 
                  <li class="tg-list-item">
                    <input name="involvement_request" class="tgl tgl-skewed" id="involve" type="checkbox" {{ $cor->involvement_request==1 ? 'checked' : '' }}/>
                    <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="involve"></label>
                  </li>
                </div>
              </div>
              <br>
           
              <div class="row">
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('adminstaticword.PreviewVideo') }}</label>  
                  <li class="tg-list-item"> 
                    <input name="preview_type"  class="tgl tgl-skewed" id="preview" type="checkbox" {{ $cor->preview_type=="video" ? 'checked' : '' }}>

                    <label class="tgl-btn" data-tg-off="URL" data-tg-on="Upload" for="preview" ></label>
                  </li>
                  <input type="hidden" name="free" value="0" id="to">

                  <div @if($cor->preview_type =="url" ) class="display-none" @endif id="document1">
                    <br>
                    <label for="exampleInputSlug">{{ __('adminstaticword.UploadVideo') }} <sup class="redstar">*</sup></label>
                    <input  type="file" class="form-control" name="video" id="video" value="{{ $cor->video }}">
                    @if($cor->video !="")
                      <video src="{{ asset('video/preview/'.$cor->video) }}" width="200" height="150" controls>
                      </video>
                    @endif 
                  </div>

                  <div @if($cor->preview_type =="video") class="display-none" @endif id="document2">
                    <br>
                    <label for="exampleInputSlug">{{ __('adminstaticword.URL') }} <sup class="redstar">*</sup></label>
                    <input  class="form-control" placeholder="Enter Your URL" name="url" id="url" value="{{ $cor->url }}">
                  </div>
                </div>
                


                <div class="col-md-6">
                  <label for="">{{ __('adminstaticword.Duration') }} </label>
                  <li class="tg-list-item">              
                    <input class="tgl tgl-skewed" id="duration_type" type="checkbox" name="duration_type" {{ $cor->duration_type == "m" ? 'checked' : '' }} >
                    <label class="tgl-btn" data-tg-off="days" data-tg-on="month" for="duration_type"></label>
                  </li>

                  <br>
                  {{-- <label for="exampleInputSlug">Course Expire Duration</label> --}}
                  <label for="exampleInputSlug">Expire Duration</label>
                  <input min="1" class="form-control" name="duration" type="number" id="duration" value="{{ $cor->duration }}" placeholder="">
                </div>


              </div>
              <br>


              <div class="row">
                <div class="col-md-6">
                  <label>{{ __('adminstaticword.PreviewImage') }}</label> 
                  <br> 
                  <input type="file" name="image" id="image" class="inputfile inputfile-1"  />
                  <label for="image"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="7" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>{{ __('adminstaticword.Chooseafile') }}&hellip;</span>
                  </label>
                  <br>
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                      <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;"/>
                  @else
                      <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>

                <div class="col-md-6">
                  @if(Auth::User()->role == "admin")
                  <label for="Revenue">Instructor Revenue:</label>
                  <div class="input-group">
                            
                    <input min="1" max="100" class="form-control" name="instructor_revenue" type="number" value="{{ $cor['instructor_revenue'] }}" id="revenue"  placeholder="Enter revenue percentage" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                  @endif
                </div>


                
              </div>
              <br>


              <div class="row">
              <div class="col-sm-4">

                  <label for="exampleInputDetails">{{ __('Assignment Enable') }}</label>                 
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" name="assignment_enable"  id="frees" type="checkbox" {{ $cor['assignment_enable']=="1" ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees"></label>
                  </li>
                </div>

                 <div class="col-sm-4">

                  <label for="exampleInputDetails">{{ __('Appointment Enable') }}</label>                 
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" name="appointment_enable"  id="frees1" type="checkbox" {{ $cor['appointment_enable']=="1" ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees1"></label>
                  </li>
                </div>

                 <div class="col-sm-4">

                  <label for="exampleInputDetails">{{ __('Certificate Enable') }}</label>                 
                  <li class="tg-list-item">
                    <input class="tgl tgl-skewed" name="certificate_enable"  id="frees2" type="checkbox" {{ $cor['certificate_enable']=="1" ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees2"></label>
                  </li>
                </div>
            </div>
            <br>
            <br>      

              <br>
              <div class="box-footer">
                {{-- <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('adminstaticword.Save') }}</button> --}}
                
               {{--  <button type="submit" class="btn btn-lg col-md-4 btn-primary" onclick="testing(0)">{{ __('adminstaticword.Submit') }}</button>
                <button type="submit" class="btn btn-lg col-md-4 course-draft" onclick="testing(1)">Draft</button>&emsp;&emsp;&emsp;
                <a href="{{URL::to('/course')}}/ {{request()->route('id')}}/{{ $cor->slug}}" target="_blank" class="">Preview Course Overview</a>&emsp;&emsp;&emsp;
                <a href="{{URL::to('/coursecontent')}}/ {{request()->route('id')}}/{{ $cor->slug}}" target="_blank" class="">Preview Course Detail</a> --}}

                <div class="btn-group">
                  <button type="button" class="btn btn-default">Action</button>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li>        
                        <a href="#" onclick="testing(0)">Submit</a>
                    </li>

                    <li>
                      <a href="#" onclick="testing(1)">Draft</a>
                    </li>

                    <li>
                      <a href="{{URL::to('/course')}}/{{request()->route('id')}}/{{ $cor->slug}}" target="_blank" class="">Preview Course Overview</a>
                    </li>

                    <li>
                      <a href="{{URL::to('/coursecontent')}}/{{request()->route('id')}}/{{ $cor->slug}}" target="_blank" class="">Preview Course Detail</a>
                    </li>

                    @if(Auth::User()->role == "admin")
                    <li>                      
                      <form>
                        @if($cor->status ==6||$cor->status ==0||$cor->status ==1)
                          @if($cor->status ==6||$cor->status ==0)
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#status_modal{{ $cor->id }}">{{ __('adminstaticword.Active') }}</a>
                          @endif      
                        
                          @if($cor->status ==1||$cor->status ==7)
                          <a href="javascript:void(0)" data-toggle="modal" data-target="#status_modal{{ $cor->id }}">Deactivate</a>
                          @endif
                        @endif
                      </form>
                    </li>

                    
                    <li>
                      <form action="{{ route('course.quick_reject',$cor->id) }}" method="POST">
                        {{ csrf_field() }}
                        @if($cor->status ==0||$cor->status ==1||$cor->status ==7)
                          <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn-danger">
                            Reject
                          </button>
                        @endif
                      </form>
                    </li>
                    @endif

                    <li>
                      @if($cor->status ==1)
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#live_modal{{ $cor->id }}">  Live this Course</a>
                      
                      @endif
                    </li>

                    {{-- <li>
                      <form>
                      <button  type="button" onclick="goTo('{{ route('course.show',$cor->id) }}')" class="btn-danger">
                        Edit
                      </button>
                      </form>
                    </li> --}}

                    <li>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#course_modal{{ $cor->id }}">  Delete</a>
                    </li>

                    
                    <li>
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#archive_course{{ $cor->id }}">  Archive</a>
                    </li>

                  </ul>
                </div>

              </div>
         
            </form>
          </div>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->

  <div id="live_modal{{ $cor->id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">            
            Live Course
          </h4>
          <p>Are you sure to live this course?</p>
        </div>
        <div class="modal-footer">
          
          <form action="{{url('quickupdate/course_live/'.$cor->id)}}" method="POST">
            {{ csrf_field() }}
            <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn dd-primary">
                Live this Course
              </button>
              <button  type="button"  data-dismiss="modal" class="btn btn-danger">
                  Cancel
              </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="archive_modal{{ $cor->id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">            
            Live Course
          </h4>
          <p>Are you sure to live this course?</p>
        </div>
        <div class="modal-footer">
          
          <form action="{{url('quickupdate/course_live/'.$cor->id)}}" method="POST">
            {{ csrf_field() }}
            <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn dd-primary">
                Live this Course
              </button>
              <button  type="button"  data-dismiss="modal" class="btn btn-danger">
                  Cancel
              </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="status_modal{{ $cor->id }}" class="delete-modal modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div class="delete-icon"></div>
        </div>
        <div class="modal-body text-center">
          <h4 class="modal-heading">            
            @if($cor->status ==6||$cor->status ==0)
                Activate
              @endif      
            
              @if($cor->status ==1||$cor->status ==7)
                Deactivate
              @endif
          </h4>
          <p>Are you sure to @if($cor->status ==6||$cor->status ==0)
            Activate
          @endif      
        
          @if($cor->status ==1||$cor->status ==7)
            Deactivate
          @endif this course?</p>
        </div>
        <div class="modal-footer">
          <form action="{{ route('course.quick',$cor->id) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="st_{{$cor->id}}" name="st_{{$cor->id}}">
            @if($cor->status ==6||$cor->status ==0||$cor->status ==1)
              @if($cor->status ==6||$cor->status ==0)
              <button  type="Submit" onclick="changeStat({{$cor->status}},{{$cor->id}})" class="btn dd-primary">
                  Activate
              </button>
              <button  type="button"  data-dismiss="modal" class="btn btn-danger">
                  Cancel
              </button>
              @endif      
            
              @if($cor->status ==1||$cor->status ==7)
                <button  type="Submit" onclick="changeStat(0,{{$cor->id}})" class="btn dd-primary">
                  Deactivate 
                </button>
                <button  type="button"  data-dismiss="modal" class="btn btn-danger">
                    Cancel
                </button>
              @endif
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>

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


</section> 


@section('scripts')

<script type="text/javascript">
  $(document).ready(function() {    

  });
  function testing(id) {
    document.getElementById("isdraft").value = id;
    document.getElementById('form').submit();
  }
</script>

<script>
(function($) {
  "use strict";

  $(function() {
    $('.js-example-basic-single').select2();
  });

  $(function() {
    $('#cb1').change(function() {
      $('#f').val(+ $(this).prop('checked'))
    })
  })

  $(function() {
    $('#cb3').change(function() {
      $('#test').val(+ $(this).prop('checked'))
    })
  })

  $(function(){

      $('#murl').change(function(){
        if($('#murl').val()=='yes')
        {
            $('#doab').show();
        }
        else
        {
            $('#doab').hide();
        }
      });

  });

  $(function(){

      $('#murll').change(function(){
        if($('#murll').val()=='yes')
        {
            $('#doabb').show();
        }
        else
        {
            $('#doab').hide();
        }
      });

  });

  $('#preview').on('change',function(){

    if($('#preview').is(':checked')){
      $('#document1').show('fast');
      $('#document2').hide('fast');    

    }else{
      $('#document2').show('fast');
      $('#document1').hide('fast');    
    }

  });

  $(function() {
    var urlLike = '{{ url('admin/dropdown') }}';
    $('#category_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });

  $(function() {
    var urlLike = '{{ url('admin/gcat') }}';
    $('#upload_id').change(function() {
      var up = $('#grand').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });

})(jQuery);

</script>
  
@endsection
