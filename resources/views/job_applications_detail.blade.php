<head>
    <!-- FSMS -->
    @php
        $url =  URL::current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="{{$getJobDetail->title}}">
    <meta name="description" content="Job Short Desc ">
    <meta name="author" content="elsecolor">
    <meta property="og:title" content="">
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
    use App\JobsApplication;
    use App\User;
@endphp
<section id="about-product" class="about-product-main-block">
	<div class="container">
        <div class="featured-review btm-40">
            <h3>{{$getJobDetail->title}}</h3>
            
            <div class="featured-review-block">
                <div class="row">
                    <div class="col-lg-1 col-sm-1 col-1">
                        <div class="featured-review-img">
                            <div class="review-img text-white">
    
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-11 col-sm-11 col-11">
                        <div class="featured-review-img-dtl">
                            @php
                                $getUser = User::where(['id'=>$getJobsApplicationDetail->user_id])->first();
                            @endphp
                            <div class="review-img-name"><span>{{$getUser->fname}} {{$getUser->lname}}</span></div>
                            <div class="year btm-20">{{ date_format(date_create($getJobsApplicationDetail->date_applied),'jS F Y') }}</div>
                        </div>
                    </div>
                </div>
                <p class="btm-20">{{$getJobsApplicationDetail->message}}</p>   
              <hr>
            </div>
            @foreach ($convo as $item)
            <div class="featured-review-block">
                <div class="row">
                    <div class="col-lg-1 col-sm-1 col-1">
                        <div class="featured-review-img">
                            <div class="review-img text-white">
    
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-11 col-sm-11 col-11">
                        <div class="featured-review-img-dtl">
                            @php
                                $getSender = User::where(['id'=>$item->sender])->first();
                            @endphp
                            <div class="review-img-name"><span>{{$getSender->fname}} {{$getSender->lname}}</span></div>
                            <div class="year btm-20">{{ date_format(date_create($item->sent_dt),'jS F Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
                <p class="btm-20">{!!$item->message!!}</p>   
              <hr>
            </div>
            @endforeach

            <br>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="detail">Message<sup class="redstar">*</sup></label>
								<textarea name="detail" id="detail" cols="30" rows="10"></textarea>
                                <button type="submit" onclick="send_message()" class="btn btn-lg col-md-3 btn-primary">Send Message</button>
                            </div>
						</div>                                                              
					</div>
        </div>
    </div>

  
</section>
<!-- course detail end -->
@endsection


@section('custom-script')
<script type="text/javascript">
    $(document).ready(function(){
        
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

function send_message() {
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"post",
        url:  "{{url('/send_message')}}",
        data: {
            job_id: "{{request()->route('id')}}",
            to: "{{request()->route('to')}}",
            message: tinymce.activeEditor.getContent()
        },
        success:function(data){   
            location = location
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest);
        }
    });
}
</script>
@endsection


