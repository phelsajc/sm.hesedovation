@extends('theme.master')
@section('title', "Search Jobs")

@section('content')
@include('admin.message')

<section id="business-home" class="business-home-main-block">
    <div class="container">
        <h1 class="">Search Jobs</h1>
        <div class="search search-open" id="search">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search for Jobs here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">             
                    <button type="button" class="btn btn-info"> Search Job</button>
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

                    {{-- <div class="card">
                        <div class="card-header" data-toggle="collapse" href="#collapseOne" data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                        <a class="card-title">
                          Categories
                        </a>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="">
                        <div class="card-body">
                            <div class="wrapper-two center-block">
                                @php
                                 $categories = App\Categories::orderBy('position','ASC')->get();
                                @endphp
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach($categories->where('status', '1') as $cate)
                                  <div class="panel panel-default">
                                    <div class="panel-heading active" role="tab" id="headingOnexxx">
                                        <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOnexxx{{ $cate->id }}" aria-expanded="true" aria-controls="collapseOnexxx">
                                            <i class="fa {{ $cate->icon }} rgt-10"></i> <label class="prime-cat" data-url="{{ route('category.page',['id' => $cate->id, 'category' => str_slug(str_replace('-','&',$cate->title))]) }}">{{ str_limit($cate->title, $limit = 20, $end = '..') }}</label> 
                                        </a>
                                        </h4>
                                    </div>

                                    
                                    <div id="collapseOnexxx{{ $cate->id }}" class="subcate-collapse panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOnexxx">
                                    @foreach($cate->subcategory as $sub)
                                      @if($sub->status ==1)
                                      <div class="panel-body">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingelevenxxx">
                                              <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseelevenxxx{{ $sub->id }}" aria-expanded="false" aria-controls="collapseelevenxxx">
                                                  <i class="fa {{ $sub->icon }} rgt-10"></i> <label class="sub-cate" data-url="{{ route('subcategory.page',['id' => $sub->id, 'category' => str_slug(str_replace('-','&',$sub->title))]) }}">{{ str_limit($sub->title, $limit = 15, $end = '..') }}</label>

                                                </a>
                                              </h4>
                                            </div>

                                            <div id="collapseelevenxxx{{ $sub->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingelevenxxx">
                                              @foreach($sub->childcategory as $child)
                                              @if($child->status ==1)
                                              <div class="panel-body sub-cat">
                                                <i class="fa {{ $child->icon }} rgt-10"></i> <label class="child-cate" data-url="{{ route('childcategory.page',['id' => $child->id, 'category' => str_slug(str_replace('-','&',$child->title))]) }}">{{ $child->title }} </label>
                                              </div>
                                              @endif
                                              @endforeach
                                            </div>
                                            
                                        </div>
                                      </div>
                                      @endif
                                    @endforeach
                                    </div>
                                    
                                  </div>
                                @endforeach
                                </div>
                            </div>
                        
                        </div>
                        </div>
                    </div> --}}

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo" data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                        <a class="card-title">
                          Skills 
                        </a>
                        </div>
                        <div id="collapseTwo" class="collapse show" data-parent="">
                        <div class="card-body">
                        <div class="categories-tags">
                            <div class="categories-content-one">
                                <div class="categories-tags-content-one">
                                    <ul style="height: 200px; overflow: auto">
                                        @foreach ($get_job_skills as $item)
                                            <li>
                                                <div class="form-check form-check-inline">
                                                    {{-- <input {{ app('request')->input('type') == 'paid' ? 'checked' : '' }} class="form-check-input type" type="checkbox" id="inlineCheckbox1" value="paid"> --}}
                                                    <input class="form-check-input type" type="checkbox" id="inlineCheckbox1" value="paid">
                                                    <label class="form-check-label active" for="inlineCheckbox1">{{$item->skills}}</label>
                                                </div>
                                            </li>
                                        @endforeach                                        
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo" data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                        <a class="card-title">
                          Language 
                        </a>
                        </div>
                        <div id="collapseTwo" class="collapse show" data-parent="">
                        <div class="card-body">
                        <div class="categories-tags">
                            <div class="categories-content-one">
                                <div class="categories-tags-content-one">
                                    @php
                                    $CourseLanguage = App\CourseLanguage::get();
                                    @endphp
                                    @foreach($CourseLanguage as $lang)
                                    <ul>
                                       
                                        <li>
                                            <div class="form-check form-check-inline">
                                                <input {{ app('request')->input('lang') == '$lang->id' ? 'checked' : '' }}  class="form-check-input lang" type="checkbox" id="inlineCheckbox2" value="{{ $lang->id }}">
                                                <label class="form-check-label" for="inlineCheckbox2">{{ $lang->name }}</label>
                                            </div>
                                        </li>
                                        
                                    </ul>

                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                        </div>
                        </div>
                    </div> --}}

                    <div class="card">
                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo" data-closetxt="Stäng block" data-opentxt="Visa innehåll">
                            <a class="card-title">
                            Category 
                            </a>
                        </div>
                        <select class="form-control" name="jobcat" id="jobcat">
                            <option selected disabled>Select Category</option>
                            @foreach ($get_job_categories as $item)
                                <option value="{{$item->category}}">{{$item->category}}</option>
                            @endforeach           
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="students-bought btm-30">
                    @php
                        use App\User;
                        use App\JobsCategory;
                        use App\JobsSkills;
                    @endphp
                    @foreach ($get_jobs  as $key => $item)
                    <div class="course-bought-block protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$key}}" onclick="window.location='job-detail/{{$item->id}}'">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="categories-popularity-dtl">
                                    <div class="view-heading btm-10"><a href="job-detail/{{$item->id}}">{{ $item->title}}</a></div>
                                    <p>{!!  str_limit( $item->details, $limit = 125, $end = '..') !!}</p>
                                    @php
                                    $get_skills = JobsSkills::where(['job_id' => $item->id])->get();
                                        $get_cat = JobsCategory::where(['job_id' => $item->id])->get();
                                        $get_employer = User::where(['id' => $item->employer_id])->first();
                                    @endphp
                                    <ul>
                                        <li class="best-seller best-seller-one">tags</li>
                                        @foreach ($get_cat as $s)
                                            <li>
                                                <span class="badge badge-primary"><i class="fa fa-tags"></i> {{$s->categories}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-2">
                                <div class="rate text-right">
                                    <ul>
                                        <li class="rate-r">{{$get_employer->fname}} {{$get_employer->lname}}</li>
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

                        <div id="prime-next-item-description-block{{$key}}" class="prime-description-block">
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
                        </div>                        
                    </div>
                    <hr>
                    @endforeach

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="top-20">{{$get_jobs->links()}}</a></li>
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
