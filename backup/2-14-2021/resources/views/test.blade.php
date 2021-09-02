@extends('admin.layouts.master')
@section('body')
@section('title', 'ADD User - Admin')

<section class="content">
 
  
   
      <div class="form-group{{ $errors->has('selecturl') ? ' has-error' : '' }}">
        

         <label for="type">{{ __('Add Video') }}:<sup class="redstar">*</sup></label>

        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select one of the options to add Video/Movie"></i>
       {{--  {!! Form::select('selecturl', array('iframeurl' => 'IFrame URL/Embed URL',
         'youtubeapi' =>'Youtube API', 'vimeoapi' => 'Vimeo API',
         'customurl' => 'Custom URL/ Youtube URL/ Vimeo URL','multiqcustom' => 'Multi Quality Custom URL & URL Upload'), null, ['class' => 'form-control select2','id'=>'selecturl']) !!} --}}

        <select name="selecturl" id="selecturl" class="form-control js-example-basic-single">
          <option>{{ __('adminstaticword.ChooseFileType') }}</option>
          <option value="youtubeapi">{{ __('Youtube API') }}</option>
          <option value="vimeoapi">{{ __('Vimeo API') }}</option>
        </select>


         <small class="text-danger">{{ $errors->first('selecturl') }}</small>
      </div>


      <div id="ready_url" class="form-group{{ $errors->has('ready_url') ? ' has-error' : '' }}">
        <label id="ready_url_text"></label>
        <p class="inline info"> - Please enter your video url</p>
        {{-- {!! Form::text('ready_url', null, ['class' => 'form-control','id'=>'apiUrl']) !!} --}}

        <input type="text" class="form-control" id="apiUrl" name="ready_url" id="exampleInputTitle"   placeholder="Enter Your Title"value="">

        <small class="text-danger">{{ $errors->first('ready_url') }}</small>


      </div>



  <!--youtube API Modal -->
  <div id="myyoutubeModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!--youtube API Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title">Search From Youtube API</h5>
        </div>
        <div class="modal-body">
          @if(is_null(env('YOUTUBE_API_KEY')))
          <p>Make Sure You Have Added Youtube API Key in <a href="{{url('admin/api-settings')}}">API Settings</a></p>
          @endif
         
            <div id="hyv-page-container" style="clear:both;">
                  <div class="hyv-content-alignment">
                      <div id="hyv-page-content" class="" style="overflow:hidden;">
                          <div class="container-4">
                              <form action="" method="post" name="hyv-yt-search" id="hyv-yt-search">
                                  <input type="search" name="hyv-search" id="hyv-search" placeholder="Search..." class="ui-autocomplete-input" autocomplete="off">
                                  <button class="icon" id="hyv-searchBtn"></button>
                              </form>
                          </div>
                          <div>
                              <input type="hidden" id="pageToken" value="">
                              <div class="btn-group" role="group" aria-label="...">
                                <button type="button" id="pageTokenPrev" value="" class="btn btn-default">Prev</button>
                                <button type="button" id="pageTokenNext" value="" class="btn btn-default">Next</button>
                              </div>
                          </div>
                          <div id="hyv-watch-content" class="hyv-watch-main-col hyv-card hyv-card-has-padding">
                              <ul id="hyv-watch-related" class="hyv-video-list">
                              </ul>
                          </div>

                      </div>
                  </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div> 


</section> 



@endsection

 

@section('script')
<!--courseclass.js is included -->

{{-- youtube APi code --}}


<script>
    $(document).ready(function() {
       var videourl;
        youtubeApiCall();
        $("#pageTokenNext").on( "click", function( event ) {
            $("#pageToken").val($("#pageTokenNext").val());
            youtubeApiCall();
        });
        $("#pageTokenPrev").on( "click", function( event ) {
            $("#pageToken").val($("#pageTokenPrev").val());
            youtubeApiCall();
        });
        $("#hyv-searchBtn").on( "click", function( event ) {
            youtubeApiCall();
            return false;
        });
        jQuery( "#hyv-search" ).autocomplete({
          source: function( request, response ) {
            //console.log(request.term);
            var sqValue = [];
            jQuery.ajax({
                type: "POST",
                url: "http://suggestqueries.google.com/complete/search?hl=en&ds=yt&client=youtube&hjson=t&cp=1",
                dataType: 'jsonp',
                data: jQuery.extend({
                    q: request.term
                }, {  }),
                success: function(data){
                    // console.log(data[1]);
                    obj = data[1];
                    jQuery.each( obj, function( key, value ) {
                        sqValue.push(value[0]);
                    });
                    response( sqValue);
                }
            });
          },
          select: function( event, ui ) {
            setTimeout( function () { 
                youtubeApiCall();
            }, 300);
          }
        });  
    });
    function youtubeApiCall(){
        $.ajax({
            cache: false,
            data: $.extend({
                key: '{{env('YOUTUBE_API_KEY')}}',
                q: $('#hyv-search').val(),
                part: 'snippet'
            }, {maxResults:15,pageToken:$("#pageToken").val()}),
            dataType: 'json',
            type: 'GET',
            timeout: 5000,
            url: 'https://www.googleapis.com/youtube/v3/search'
        })
        .done(function(data) {
            if (typeof data.prevPageToken === "undefined") {$("#pageTokenPrev").hide();}else{$("#pageTokenPrev").show();}
            if (typeof data.nextPageToken === "undefined") {$("#pageTokenNext").hide();}else{$("#pageTokenNext").show();}
            var items = data.items, videoList = "";
            $("#pageTokenNext").val(data.nextPageToken);
            $("#pageTokenPrev").val(data.prevPageToken);
            console.log(items);
            $.each(items, function(index,e) {
                 
                 videourl="https://www.youtube.com/watch?v="+e.id.videoId;
                   console.log(videourl);
                videoList = videoList 
                + '<li class="hyv-video-list-item" ><div class="hyv-content-wrapper"><p  class="hyv-content-link" title="'+e.snippet.title+'"><span class="title">'+e.snippet.title+'</span><span class="stat attribution">by <span>'+e.snippet.channelTitle+'</span></span></p><button class="bn btn-info btn-sm inline" onclick=setVideoURl("'+videourl+'")>Add</button></div><div class="hyv-thumb-wrapper"><p class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.snippet.title+'" src="'+e.snippet.thumbnails.default.url+'" height="90"></span></p></div></li>';
                  
              
            });

            $("#hyv-watch-related").html(videoList);
           
        });
    }
</script>



<script type="text/javascript">
  $(document).ready(function(){ 
    $('#selecturl').change(function() {
     $('#apiUrl').val('');  
        var opval = $(this).val(); //Get value from select element
        if(opval=="youtubeapi"){ //Compare it and if true
            $('#myyoutubeModal').modal("show"); //Open Modal
        }
        if(opval=="vimeoapi"){ //Compare it and if true
            $('#myvimeoModal').modal("show"); //Open Modal
        }
    });
});
</script>


<script type="text/javascript">
  function setVideoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myyoutubeModal').modal("hide");
  }
</script>
<script type="text/javascript">
  function setVideovimeoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myvimeoModal').modal("hide");
  }
</script>

@endsection

@section('stylesheets')

<style type="text/css">
    body{
            background-color: #efefef;
        }
        .container-4 input#hyv-search {
            width: 500px;
            height: 30px;
            border: 1px solid #c6c6c6;
            font-size: 10pt;
            float: left;
            padding-left: 15px;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-bottom-left-radius: 5px;
            -moz-border-top-left-radius: 5px;
            -moz-border-bottom-left-radius: 5px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
          .container-4 input#vimeo-search {
            width: 500px;
            height: 30px;
            border: 1px solid #c6c6c6;
            font-size: 10pt;
            float: left;
            padding-left: 15px;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-bottom-left-radius: 5px;
            -moz-border-top-left-radius: 5px;
            -moz-border-bottom-left-radius: 5px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .container-4 button.icon {
            height: 30px;
            background: #f0f0f0 url('images/icons/searchicon.png') 10px 1px no-repeat;
            background-size: 24px;
            -webkit-border-top-right-radius: 5px;
            -webkit-border-bottom-right-radius: 5px;
            -moz-border-radius-topright: 5px;
            -moz-border-radius-bottomright: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border: 1px solid #c6c6c6;
            width: 50px;
            margin-left: -44px;
            color: #4f5b66;
            font-size: 10pt;
        }
    
</style>


@endsection
