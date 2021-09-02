@extends('admin.layouts.master')
@section('title', 'PWA Settings - Admin')
@section('body')
@include('admin.message')


<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title">PWA Settings</h1>
        </div>
    	 <div class="box-body">
          <!-- Nav tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-language" aria-hidden="true"></i> Update Manifest</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-laptop" aria-hidden="true"></i> Update SW JS</a></li>
              <li role="presentation"><a href="#admin" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-laptop" aria-hidden="true"></i> Update PWA Icons</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="home">
              	<br>
                <div class="callout callout-success">
                <i class="fa fa-info-circle"></i>
                 Progessive Web App Requirements
                 <ul>
                  <li><b>HTTPS</b> must required in your domain (for enable contact your host provider for SSL configuration).</li>
                  <li><b>Start URL</b> you put must be correct in below settings.</li>
                  <li><b>All icons size</b> required and to be updated in Icon Settings.</li>
                 </ul>
              </div>

              <div class="callout callout-danger">
                <p><i class="fa fa-info-circle"></i> Important Notes
                <ul>
                  <li>IF your domain content /public than in above Manifest setting <u>start_url</u> should be <b>https://yourdomain.com/public/?launcher=true</b> </li>
                  <li>IF your domain doesn't content /public than in above Manifest setting <u>start_url</u> should be <b>/?launcher=true</b> </li>
                  <li>IF your project is under <u>subdomain</u> and content /public than in above Manifest setting <u>start_url</u> should be:
                  <ol type="i">
                    <li><b>https://test.yourdomain.com/public/?launcher=true</b></li>
                  </ol>
                IF Doesnt content /public after subdomain url than <u>start_url</u> should be:
                  <ol type="i">
                    <li><b>https://test.yourdomain.com/?launcher=true</b></li>
                  </ol>
                  </li>
                </ul>
              </div>
              	@include('admin.pwasetting.manifest')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="profile">
              	<br>
              	@include('admin.pwasetting.sw')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="admin">
                <br>
                @include('admin.pwasetting.icon')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
