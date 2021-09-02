@extends('admin/layouts.master')
@section('title', 'Create Job - Employer')
@section('body')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif


<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-10">
              <h3 class="box-title">@if (request()->route('id')) Edit Job @else Add Job @endif</h3>
            </div>
            <div  class="col-md-2">
                <div><h4 class="admin-form-text"><a href="{{url('course')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons"><button class="btn btn-xs btn-success abc"> << {{ __('adminstaticword.Back') }}</button> </i></a></h4></div>
            </div>
          </div>
        </div>
         
        <div class="box-body">
          <div class="form-group">
            <form action="@if (request()->route('id')){{url('employer/update-job')}} @else {{url('employer/store-job')}} @endif" method="post" enctype="multipart/form-data">
              {{ csrf_field() }} 
                <legend>Job Description</legend> 
                <hr>
                <input type="hidden" name="id" id="id" value="@if (request()->route('id')) {{$get_job_detail->id}} @endif">
              <div class="row">
                <div class="col-md-4">
                  <label>Job Title<span class="redstar">*</span></label>
                  <input type="text" name="title" id="title" class="form-control" value="@if (request()->route('id')) {{$get_job_detail->title}} @endif">
                </div>
                <div class="col-md-4">
                  <label>Level<span class="redstar">*</span></label>
                    <select name="lvl" id="lvl" class="form-control js-example-basic-single">
                      <option value="1" @if(request()->route('id')) @if($get_job_detail->level==1) selected @endif @endif>Basic</option>
                      <option value="2" @if(request()->route('id')) @if($get_job_detail->level==2) selected @endif @endif>Intermediate</option>
                      <option value="3" @if(request()->route('id')) @if($get_job_detail->level==3) selected @endif @endif>Expert</option>
                    </select>
                </div>
                <div class="col-md-4">
                  <label>Project Duration</label>
                  <select name="proj_duration" id="proj_duration" class="form-control js-example-basic-single">
                    <option value="1">Less than a week</option>
                    <option value="2">Less than a month</option>
                    <option value="3">1 to 3 months</option>
                    <option value="4">3 to 6 onths</option>
                    <option value="5">more than 6 months</option>
                  </select>
                </div>
              </div>
              <br>

              <div class="row">
                  <div class="col-md-3"> 
                    <label>Freelance <span class="redstar">*</span></label>
                    <select name="freelancers" id="freelancers" class="form-control js-example-basic-dta">
                      <option value="1">Independent</option>
                      <option value="2">Agency</option>
                      <option value="3">Beginner</option>
                    </select> 
                  </div>

                  <div class="col-md-3"> 
                    <label for="eng_lvl">English Level</label>
                    <select name="eng_lvl" id="eng_lvl" class="form-control js-example-basic-single col-md-7 col-xs-12">
                      <option value="1">Basic</option>
                      <option value="2">Conversational</option>
                      <option value="3">Fluent</option>
                    </select>                  
                  </div>            

                  <div class="col-md-3"> 
                    <label for="cost">Budget</label>
                    <input type="number" name="cost" id="cost" class="form-control" value="@if(request()->route('id')){{$get_job_detail->cost}}@endif">               
                  </div>

                  <div class="col-md-3"> 
                    <label for="exampleInputSlug">Job Expiry</label>
                    <input type="text" name="job_expiry" id="datepicker" class="form-control" value="@if (request()->route('id')) {{$get_job_detail->expiry_dt}} @endif">               
                </div>

              </div>

              <div class="row">
                
                <div class="col-md-4">
                  <label>Category<span class="redstar">*</span></label>
                    <select name="cetegories[]" id="cetegories" multiple="" class="form-control js-example-basic-single">
                      
                      @if (request()->route('id'))                            
                        @foreach ($new_array as $item)
                          @php
                              echo $item;
                          @endphp
                        @endforeach
                        @else                     
                        @foreach ($category as $item)
                          <option value="{{$item->category}}">{{$item->category}}</option>
                        @endforeach
                      @endif
                      
                    </select>
                </div>
               {{--  <div class="col-md-4">
                  <label>Programming Language<span class="redstar">*</span></label>
                    <select name="pro_lang[]" id="pro_lang" multiple="" class="form-control js-example-basic-single">
                      <option value="1">Basic</option>
                      <option value="2">Intermediate</option>
                      <option value="4">Expert</option>
                    </select>
                </div> --}}
                <div class="col-md-4">
                  <label>Skills<span class="redstar">*</span></label>
                    <select name="skills[]" id="skills" multiple="" class="form-control js-example-basic-single">
                      @if (request()->route('id'))                            
                        @foreach ($new_array_skills as $item)
                          @php
                              echo $item;
                          @endphp
                        @endforeach
                        @else            
                        @foreach ($skills as $item)
                          <option value="{{$item->skills}}">{{$item->skills}}</option>
                        @endforeach
                      @endif
                    </select>
                </div>    
                         
                  <div class="col-md-3">
                    <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}</label>
                    <li class="tg-list-item">  
                      <input class="tgl tgl-skewed" id="cb3" @if (request()->route('id')) @if ($get_job_detail->status==1) checked     @endif @endif  type="checkbox"/>
                      <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb3"></label>
                    </li>
                    <input type="hidden" name="status" value="0" id="test">
                  </div>
              </div>



              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Detail') }} <sup class="redstar">*</sup></label>
                  <textarea id="detail" name="details" rows="3" class="form-control">
                    
                    @if (request()->route('id'))
                        {!!$get_job_detail->details!!}
                    @endif
                  
                  </textarea>
                </div>
              </div>
              <br>


              <div class="row">
                <div class="col-md-6 display-none">
                    <label for="exampleInputSlug">{{ __('Return Available') }}</label>
                    <select name="refund_enable" class="form-control js-example-basic-single col-md-7 col-xs-12">
                      <option value="none" selected disabled hidden> 
                        {{ __('frontstaticword.SelectanOption') }}
                      </option>                     
                        <option  value="1">Return Available</option>
                        <option value="0">Return Not Available</option>                     
                    </select>                  
                </div>
              </div>


              


              <br>           

              <div class="box-footer">
                <button type="submit" class="btn btn-lg col-md-4 btn-primary">{{ __('adminstaticword.Submit') }}</button>
              </div>

            </form>
          </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
</section> 

@endsection

@section('scripts')
<script type="text/javascript">
      $(document).ready(function() {    
        $('#datepicker').datepicker({
          autoclose: true,
          changeYear: true,
        });

        $(".js-example-tags").select2();
      });
  function testing(id) {
    document.getElementById("isdraft").value = id;
  }

</script>
       

<script>
(function($) {
"use strict";

  $(function() { 
    $('.js-example-basic-single').select2({
     // tags: true
    });
  });

  $(function() {
    $('#cb1').change(function() {
      $('#j').val(+ $(this).prop('checked'))
    })
  })

  $(function() {
    $('#cb3').change(function() {
      $('#test').val(+ $(this).prop('checked'))
    })
  })

  $('#cb111').on('change',function(){

    if($('#cb111').is(':checked')){
      $('#pricebox').show('fast');

      $('#priceMain').prop('required','required');

    }else{
      $('#pricebox').hide('fast');

      $('#priceMain').removeAttr('required');
    }

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

  $("#cb3").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', '1');
    }
    else {
      $(this).attr('value', '0');
    }});

  $(function(){

      $('#ms').change(function(){
        if($('#ms').val()=='yes')
        {
            $('#doabox').show();
        }
        else
        {
            $('#doabox').hide();
        }
      });

  });

  $(function(){

      $('#ms').change(function(){
        if($('#ms').val()=='yes')
        {
            $('#doaboxx').show();
        }
        else
        {
            $('#doaboxx').hide();
        }
      });

  });

  $(function(){

      $('#msd').change(function(){
        if($('#msd').val()=='yes')
        {
            $('#doa').show();
        }
        else
        {
            $('#doa').hide();
        }
      });

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
