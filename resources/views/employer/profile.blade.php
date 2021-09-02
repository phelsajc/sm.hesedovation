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
        <h1 class="blog-home-heading text-white">Employer Information</h1>
    </div>
</section> 
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container">
    	<form action="{{ route('user.profile',$employer->id) }}" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }}
            {{ method_field('PUT') }}

	        <div class="row">
	            <div class="col-xl-3 col-lg-4">
	                <div class="dashboard-author-block text-center">
	                    <div class="author-image">
						    <div class="avatar-upload">
						        <div class="avatar-preview">
									<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.$employer->user_img) }});">
									</div>
						        </div>
						    </div>
	                    </div>
	                    <div class="author-name">{{ $employer->fname }}&nbsp;{{ $employer->lname }}</div>
	                </div>
	                {{-- <div class="dashboard-items">
	                    <ul>
	                        <li><i class="fa fa-bookmark"></i><a href="{{ route('mycourse.show') }}" title="Dashboard">{{ __('frontstaticword.MyCourses') }}</a></li>
	                        <li><i class="fa fa-heart"></i><a href="{{ route('wishlist.show') }}" title="Profile Update">{{ __('frontstaticword.MyWishlist') }}</a></li>
	                        <li><i class="fa fa-history"></i><a href="{{ route('purchase.show') }}" title="Followers">{{ __('frontstaticword.PurchaseHistory') }}</a></li>
	                        <li><i class="fa fa-user"></i><a href="{{route('profile.show',Auth::User()->id)}}" title="Upload Items">{{ __('frontstaticword.UserProfile') }}</a></li>
	                        @if(Auth::User()->role == "user")
	                        <li><i class="fas fa-chalkboard-teacher"></i><a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a></li>
	                        @endif
	                        <li><i class="fa fa-user"></i><a href="{{ url('bankdetail') }}" title="Upload Items">{{ __('frontstaticword.MyBankDetails') }}</a></li>
	                    </ul>
	                </div> --}}
	            </div>
	            <div class="col-xl-9 col-lg-8">

	                <div class="profile-info-block">
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="name">{{ __('frontstaticword.FirstName') }}</label>
	                                <input type="text" readonly id="name" name="fname" class="form-control" placeholder="{{ __('frontstaticword.EnterFirstName') }}" value="{{ $employer->fname }}" required>
	                            </div>
	                            <div class="form-group">
	                                <label for="email">{{ __('frontstaticword.Email') }}</label>
	                                <input type="email" readonly id="email" name="email" class="form-control" placeholder="iNo Email Provided" required value="{{ $employer->email }}" >
	                            </div>
	                           
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="Username">{{ __('frontstaticword.LastName') }}</label>
	                                <input type="text" readonly id="lname" name="lname" class="form-control" placeholder="{{ __('frontstaticword.EnterLastName') }}" value="{{ $employer->lname }}" required>
	                            </div>
	                            <div class="form-group">
	                                <label for="mobile">{{ __('frontstaticword.Mobile') }}</label>
	                                <input type="text" readonly name="mobile" id="mobile" value="{{ $employer->mobile }}" class="form-control" placeholder="No Mobile NUmber Provided">
	                            </div>
	                           
	                            
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="bio">{{ __('frontstaticword.address') }}</label>
	                        <textarea id="address" readonly name="address" class="form-control" placeholder="No Adress Provided" value="">{{ $employer->address }}</textarea>
	                    </div>
	                    <br>

	                    {{-- <div class="row">
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                                <label for="city_id">{{ __('frontstaticword.Country') }}:</label>
					                <select id="country_id" class="form-control js-example-basic-single" name="country_id">
					                  	<option value="none" selected disabled hidden> 
					                      {{ __('frontstaticword.SelectanOption') }}
					                    </option>
					                  
					                 
					                </select>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('frontstaticword.State') }}:</label>
					                <select id="upload_id" class="form-control js-example-basic-single" name="state_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('frontstaticword.SelectanOption') }}
					                  </option>

					                </select>
	                        	</div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('frontstaticword.City') }}:</label>
					                <select id="grand" class="form-control js-example-basic-single" name="city_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('frontstaticword.SelectanOption') }}
					                  </option>
									  
					                </select>
	                        	</div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="bio">{{ __('frontstaticword.AuthorBio') }}</label>
	                        <textarea id="detail" name="detail" class="form-control" placeholder="{{ __('frontstaticword.Enteryourdetails') }}" value="">{{ $employer->detail }}</textarea>
	                    </div> --}}
	                    <br>

	                    {{-- <div class="row">
		                    <div class="col-lg-12">
		                      <div class="update-password">
		                        <label for="box1"><b>{{ __('frontstaticword.UpdatePassword') }}:</b></label>
		                        <input type="checkbox" name="update_pass" id="myCheck" onclick="myFunction()">
		                      </div>
		                    </div>
		                </div> --}}
		                {{-- <div class="password display-none" id="update-password">
			                <div class="row">
				                <div class="col-lg-6">
					                <div class="form-group">
						                <label for="confirmpassword">{{ __('frontstaticword.Password') }}:</label>
										  <input name="password" class="form-control" id="password" type="password" placeholder="{{ __('frontstaticword.EnterPassword') }}" onkeyup='check();' />
										</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>{{ __('frontstaticword.ConfirmPassword') }}:</label>
										  <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{ __('frontstaticword.ConfirmPassword') }}" onkeyup='check();' /> 
										  <span id='message'></span>
										</label>
									</div>
								</div>
							</div>
		            	</div>
		                <br> --}}
	                </div>
	                {{-- <div class="social-profile-block">
	                    <div class="social-profile-heading">{{ __('frontstaticword.SocialProfile') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="facebook">{{ __('frontstaticword.FacebookUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $employer->fb_url }}" target="_blank" title="facebook"><i class="fa fa-facebook facebook"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="fb_url" value="{{ $employer->fb_url }}" id="facebook" class="form-control" placeholder="Facebook.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="behance2">{{ __('frontstaticword.YoutubeUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $employer->youtube_url }}" target="_blank" title="googleplus"><i class="fab fa-youtube youtube"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="youtube_url" value="{{ $employer->youtube_url }}" id="behance2" class="form-control" placeholder="youtube.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="twitter">{{ __('frontstaticword.TwitterUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $employer->twitter_url }}" target="_blank" title="twitter"><i class="fab fa-twitter twitter"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="twitter_url" value="{{ $employer->twitter_url }}" id="twitter" class="form-control" placeholder="Twitter.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="dribbble2">{{ __('frontstaticword.LinkedInUrl') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $employer->linkedin_url }}" target="_blank" title="linkedin"><i class="fab fa-linkedin-in linkedin"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="linkedin_url" value="{{ $employer->linkedin_url }}" id="dribbble2" class="form-control" placeholder="Linkedin.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="upload-items text-right">
	                    <button type="submit" class="btn btn-primary" title="upload items">{{ __('frontstaticword.UpdateProfile') }}</button>
	                </div> --}}
	                
	            </div>
	        </div>

        </form>
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')

<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/dropdown') }}';
    $('#country_id').change(function() {
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
  })(jQuery);

</script>

<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/gcity') }}';
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

<script>
(function($) {
  "use strict";
	function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	        $('#imagePreview').hide();
	        $('#imagePreview').fadeIn(650);
	    }
	    reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
	    readURL(this);
	});
})(jQuery);
</script>

<script>
  function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("update-password");
    if (checkBox.checked == true){
      text.style.display = "block";
    } else {
       text.style.display = "none";
    }
  }
</script>

<script>
(function($) {
  "use strict";
	$('#password, #confirm_password').on('keyup', function () {
	  if ($('#password').val() == $('#confirm_password').val()) {
	    $('#message').html('Password Match').css('color', 'green');
	  } else 
	    $('#message').html('Password Do Not Match').css('color', 'red');
	});
})(jQuery);

</script>

<script>
(function($) {
  "use strict";
	tinymce.init({selector:'textarea#detail'});
})(jQuery);
</script>

@endsection