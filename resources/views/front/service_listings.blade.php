@extends('theme.master')
@section('title', "Search Jobs")

@section('content')
@include('admin.message')

<section id="business-home" class="business-home-main-block">
    <div class="container">
        <h1 class="">Search Services</h1>
        <div class="search search-open" id="search">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search for Services here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">             
                    <button type="button" class="btn btn-info"> Search Service</button>
                </div>
          </div>
        </div>
    </div>
</section>  

<br>
<section id="categories-popularity" class="categories-popularity-main-block category-filters">
    <div class="container">

        <div class="row">

            <div class="col-md-3 col-sm-6">
                
                <div id="accordion">

                   

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo" data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                            <a class="card-title">
                            Category 
                            </a>
                        </div>
                        <select class="form-control" name="jobcat" id="jobcat">
                            <option value="">Select Category</option>
                            <option value="12">Office &amp; Admin (Virtual Assistant)</option>
                            <option value="1">English</option><option value="11">Writing</option>
                            <option value="3">Marketing &amp; Sales</option>
                            <option value="14">Advertising</option>
                            <option value="15">Web Development</option>
                            <option value="4">Webmaster</option>
                            <option value="5">Graphics &amp; Multimedia</option>
                            <option value="2">Software Development / Programming</option>
                            <option value="8">Finance &amp; Management</option>
                            <option value="9">Customer Service &amp; Admin Support</option>
                            <option value="18">Professional Services</option>
                            <option value="17">Project Management</option>                  
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="students-bought btm-30">
                    @php
                        use App\User;
                        use App\ServiceOfferCategory;
                        use App\JobsSkills;
                    @endphp
                    @foreach ($get_services  as $key => $item)
                    <div class="course-bought-block protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$key}}" onclick="window.location='service-detail/{{$item->id}}'">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="categories-popularity-dtl">
                                    <div class="view-heading btm-10"><a href="service-detail/{{$item->id}}">{{ $item->title}}</a></div>
                                    <p>{!!  str_limit( $item->details, $limit = 125, $end = '..') !!}</p>
                                    @php
                                    $get_skills = JobsSkills::where(['job_id' => $item->id])->get();
                                        $get_cat = ServiceOfferCategory::where(['service_id' => $item->id])->get();
                                        $get_freelancer = User::where(['id' => $item->user_id])->first();
                                    @endphp
                                    <ul>
                                        <li class="best-seller best-seller-one">tags</li>
                                        @foreach ($get_cat as $s)
                                            <li>
                                                <span class="badge badge-primary"><i class="fa fa-tags"></i> {{$s->category}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-2">
                                <div class="rate text-right">
                                    <ul>
                                        <li class="rate-r">{{$get_freelancer->fname}} {{$get_freelancer->lname}}</li>
                                    </ul>
                                    <div class="rating">
                                        <ul>
                                          <li>		     
                                            @php
                                                $posted_dt = date_format(date_create($item->created_dt),'F d, Y')
                                            @endphp               
		                                    Posted: <span>{{$posted_dt}}</span> 
		                                  </li> 
                                        </ul>
                                    </div>
                                        <ul>
                                            <li>
                                                @if ($item->time_frame==1)
                                                    <b>Less than a week</b>                                                    
                                                @elseif($item->time_frame==2)
                                                    <b>Less than a month</b>
                                                @elseif($item->time_frame==3)
                                                    <b>1 to 3 months</b>
                                                @elseif($item->time_frame==4)
                                                    <b>3 to 6 months</b>                                     
                                                @elseif($item->time_frame==5)
                                                    <b> more than 6 months</b> 
                                                @endif
                                            </li>
                                        </ul>
                                    <ul>
                                        <li>
                                        	@if ($item->level==1)
                                                Basic Level
                                            @elseif($item->level==2)
                                                Meduim Level
                                            @elseif($item->level==3)
                                                Expert LEvel
                                            @endif
                                        </li> 
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- <div id="prime-next-item-description-block{{$key}}" class="prime-description-block">
                            <div class="prime-description-under-block">
                                <div class="prime-description-under-block">
                                    <h6 >Skills Required</h6>
                                    
                                        <div class="product-learn-dtl protip-whatlearn">
                                            <ul>
                                                
                                            @foreach ($get_skills as $s)
                                                <li><i class="fa fa-check"></i>{{ str_limit($s->skills, $limit = 120, $end = '...') }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    
                                </div>
                            </div>
                        </div> --}}                        
                    </div>
                    <hr>
                    @endforeach

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="top-20">{{$get_services->links()}}</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- categories end -->
@endsection



@section('custom-script')

<script type="text/javascript">
    
     var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
      for(i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if(sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
      }
    };

    
    $('.type').on('click',function(){
        if($(this).is(':checked')){
            var type  = $(this).val();

        var exist = window.location.href;
      var url = new URL(exist);
      var query_string = url.search;
      var search_params = new URLSearchParams(query_string);
      search_params.set('type', type);
      url.search = search_params.toString();
      var new_url = url.toString();
      window.history.pushState('page2', 'Title', new_url);

        }else{
         var element = '&type='+getUrlParameter('type');
        var exist = window.location.href;
        var new_url = exist.replace(element, '');
        window.history.pushState('page2', 'Title', new_url);  
        }

        location.reload();
        
    });


    $('.lang').on('click',function(){
        if($(this).is(':checked')){
            var type  = $(this).val();

        var exist = window.location.href;
      var url = new URL(exist);
      var query_string = url.search;
      var search_params = new URLSearchParams(query_string);
      search_params.set('lang', type);
      url.search = search_params.toString();
      var new_url = url.toString();
      window.history.pushState('page2', 'Title', new_url);

        }else{
         var element = '&lang='+getUrlParameter('lang');
        var exist = window.location.href;
        var new_url = exist.replace(element, '');
        window.history.pushState('page2', 'Title', new_url);  
        }

        location.reload();
        
    });
</script>


@endsection
