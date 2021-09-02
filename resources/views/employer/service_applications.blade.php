@extends('theme.master')
@section('title', 'Profile & Setting')
@section('content')

@include('admin.message')

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<!-- about-home start -->
<section id="blog-home" class="blog-home-main-block">
    <div class="container">
        <h1 class="blog-home-heading text-white">Service Applications</h1>
    </div>
</section> 
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container">

		@php			
			use App\Jobs;
			use App\User;
			use App\ServiceOffer;
		@endphp
		<div class="profile-info-block">
			
		<table class="table table-bordered table-striped">
			<thead>
			  <tr>
				<th>#</th>
				<th>Job Title</th>
				<th>Date Applied</th>
				<th>Employer</th>
				<th>Action</th>
			  </tr>
			</thead>
			<tbody>
				@if (sizeof($getJobs) >0 )
					@php
						$int = 1;
					@endphp
					@foreach ($getJobs as $item)
					@php
						$getServiceDetail = ServiceOffer::where(['id'=>$item->service_id])->first();
						$employer = User::where(['id'=>$getServiceDetail->user_id])->first();
					@endphp
						<tr>
							<td align="center">
								{{$int}}
							</td>
							<td align="center">
								{{$getServiceDetail->title}} {{$getServiceDetail->id}}
							</td>
							<td align="center">
								{{date_format(date_create($item->date_applied),'F d, Y')}}
							</td>
							<td align="center">
								{{$employer->fname}}
							</td>
							<td align="center">
								<a href="{{ url('manage-service-applications-convo') }}/{{$item->service_id}}/{{$getServiceDetail->user_id}}/{{Auth::user()->id}}" class="btn btn-success btn-xs">View</a>
							</td>
						</tr>
						@php
							$int++;
						@endphp
					@endforeach
				@else
					<tr>
						<td align="center" colspan="5">No Services Posted</td>
					</tr>
				@endif
			</tbody>
		  </table>
		</div>
    </div>
</section>

<div class="modal fade" id="modalServices" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 1140px !important">
	  <div class="modal-content">
		<div class="modal-header">
		  <h4 class="modal-title" id="myModalLabel">Service</h4>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="box box-primary">
		  <div class="panel panel-sum">
			<div class="modal-body">				
				<form id="sierviceForm" action="{{ url('save-service') }}" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
					{{ csrf_field() }}

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="detail">Title<sup class="redstar">*</sup></label>
								<input type="text" class="form-control" name="titles" id="titles">
								<input type="hidden" class="form-control" name="id" id="id">
							</div>
						</div>     
						<div class="col-md-6">
							<div class="form-group">
								<label for="detail">Budget<sup class="redstar">*</sup></label>
								<input type="number" class="form-control" name="fee" id="fee">
							</div>
						</div>                                                            
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="detail">Category<sup class="redstar">*</sup></label>
								
							</div>
						</div>                                                              
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="detail">Details<sup class="redstar">*</sup></label>
								<textarea name="detail" id="detail" cols="30" rows="10"></textarea>
							</div>
						</div>                                                              
					</div>
					<br>
					<div class="box-footer">
					 <button type="submit" onclick="saveJournal()" class="btn btn-lg col-md-3 btn-primary">{{ __('frontstaticword.Submit') }}</button>
					</div>
				</form>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>

<!-- profile update end -->
@endsection

@section('custom-script')

<script>
	
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
      $('.js-example-basic-single').select2(
        {
          //tags: true,
          tokenSeparators: [',', ' ']
        });
	});

	function openJobModal() {
		$('#modalServices').modal({backdrop: 'static', keyboard: false})  
	}
	
	function edit_service(id) {
			$("#sierviceForm").attr('action',"{{ url('update-service') }}");
		$.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: "{{ url('show-service/') }}/"+id,
          success:function(data){   
			$("#fee").val(data.getServices.fee);
			$("#titles").val(data.getServices.title);
			$("#id").val(data.getServices.id);
			if(data.getServices.details){
				tinymce.activeEditor.setContent(data.getServices.details);
			}else{
				tinymce.activeEditor.setContent("");
			}
			$('#modalServices').modal({backdrop: 'static', keyboard: false});			
			if(data.getServicesCat.length>0){
				$(".remove_cat").remove()
				data.getServicesCat.forEach(element => {
					$("#cat").append(
						'<option value="'+element.category+'" selected class="remove_cat">'+element.category+'</option>'
					)
				});
			}else{				
				$(".remove_cat").remove()
			}
			
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
	}
</script>


@endsection
