<head>
    <!-- FSMS -->
    @php
        $url =  URL::current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="{{$get_service_detail->title}}">
    <meta name="title" content="">
    <meta name="description" content="Job Short Desc ">
    <meta name="author" content="elsecolor">
    <meta property="og:title" content="{{$get_service_detail->title}}">
    <meta property="og:url" content="{{ $url }}">
    {{-- <meta property="og:description" content="{{ $course['short_detail'] }}">
    <meta property="og:image" content="{{ asset('images/course/'.$course['preview_image']) }}">
    <meta itemprop="image" content="{{ asset('images/course/'.$course['preview_image']) }}"> --}}
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    {{-- <meta name="twitter:image" content="{{ asset('images/course/'.$course['preview_image']) }}">
    <meta property="twitter:title" content="{{ $course['title'] }} ">
    <meta property="twitter:description" content="{{ $course['short_detail'] }}"> --}}
<!-- FSMS -->
</head>

@extends('theme.master')
@section('title', "Job Title")
@section('content')

@include('admin.message')
@php
    use App\ServiceRequest;
@endphp
<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="about-home-block">
					<h1 class="about-home-heading">{{$get_service_detail->title}}</h1>
                
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">

                <div class="about-home-product">
                    <div class="video-item hidden-xs">
                        <div class="video-device">
                            <a href="{{ url('employer-detail/') }}/{{$get_freelancer_img->id}}">    
                                <img src="{{ url('/images/user_img/'.$get_freelancer_img->user_img) }}" class="bg_img img-fluid" alt="Background">
                            </a>
                        </div>
                    </div>

                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">

                            <div class="about-home-includes-list btm-40">
                                <ul class="btm-40">
                                    <li><i class="fa fa-money"></i>Name: {{$get_freelancer_img->fname}} {{$get_freelancer_img->lname}}</li>
                                    <li><i class="fa fa-money"></i>Address: {{$get_freelancer_img->address}} </li>
                                </ul>
                                <span>Tags:</span>
                                <br>
                                
                                @foreach($get_service_categories as $wl)
                                <span class="badge badge-primary"><i class="fa fa-tags"></i> {{$wl['category']}}</span>
                                @endforeach                                
                             </div>

                        <hr>
                        <div class="about-home-share text-center">
                           
                            @if(Auth::check())
                                @php                                    
                                    //$job_applied = JobsApplication::where(['job_id'=>$get_job_detail->id])->first();
                                    $job_applied = ServiceRequest::where(['employer_id'=>Auth::User()->id,'service_id'=>$get_service_detail->id])->first();
                                @endphp
                            @if (!$job_applied)
                            <a href="#" data-toggle="modal" data-target="#myModalshare" title="share">
                                <i class="fa fa-share rgt-10"></i> GET THIS SERVICE  </a> 
                            @else
                            <h1><span class="badge badge-secondary">APPLIED</span></h1>
                            @endif
                            
                            @endif
                        </div>

			</div>
			<div class="container-fluid" id="adsense">
                
				<?php
                          if (isset($ad)) {
                           if ($ad->isdetail==1 && $ad->status==1) {
                              $code = $ad->code;
                              echo html_entity_decode($code);
                           }
                          }
                        ?>
			</div>
		</div>
		<br> </div> --}} </div>
	</div>
</section>


<div id="myModalshare" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">&nbsp;</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="formUpdate" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control">
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-12">
                            <label>Message <span class="text-danger">*</span></label>
                           <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>                    
                </form>                                    
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</button> --}}
                <button class="btn btn-info" type="button" onclick="save_service()"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>


<section id="about-product" class="about-product-main-block">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="description-block btm-30">
					<h3>{{ __('frontstaticword.Description') }}</h3>
					
                        
                        {!!$get_service_detail->details!!}

                        
                   
				</div>
				{{-- <div class="product-learn-block">
					<h3 class="product-learn-heading">Skills Required</h2>
                        <div class="row">
                            @foreach($get_job_skills as $wl)
                            <div class="col-lg-6 col-md-6">
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i class="flaticon-tick-inside-circle"></i>{{ str_limit($wl['skills'], $limit = 120, $end = '...') }}</li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach                            
                        </div>
                    </div>
                    
                <div class="course-content-block btm-30 top-20">



            

      
            </div> --}}

        </div>
    </div>


</section>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<!-- course detail end -->
@endsection



@section('custom-script')
<script type="text/javascript">
    
function save_service() {
    var datas = $('#formUpdate').serializeArray(); 
    datas.push({
        name: 'service_id',
        value: "{{request()->route('id')}}"
    });
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"post",
        url:  "{{url('/apply_service')}}",
        data: datas,
        success:function(data){   
            $("#myModalshare").modal('hide')
            location = location
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
    });
}
</script>
@endsection