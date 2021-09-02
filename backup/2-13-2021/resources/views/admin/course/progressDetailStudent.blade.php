@extends('admin/layouts.master')
@section('title', 'Edit Course - Admin')

@section('body')

<section class="content">
    @include('admin.message')
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-primary">
  
          <div class="content-header">
          </div>
          <div class="box-body">
            <div class="nav-tabs-custom">
              <div class="row">
                <div class="col-md-2">
                   <ul class="nav nav-stacked" id="nav-tab" role="tablist"> 
           
                        <li role="presentation" class="active"><a href="#a" aria-controls="home" role="tab" data-toggle="tab">Journal</a></li>
                        <li class=""  role="presentation"><a href="#b" aria-controls="profile" role="tab" data-toggle="tab">Article</a></li>
                        <li  class=""  role="presentation"><a href="#c" aria-controls="messages" role="tab" data-toggle="tab">Quiz</a></li>
                    
                    </ul>
                </div>

                <div class="col-md-10">
                  <div class="tab-content">
  
                <div role="tabpanel" class="tab-pane fade in active" id="a">
                    {!!$course_journal['content']!!} 
                    <button type="button" class="btn btn-success">View Comments</button>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="b">
                    
                </div>
                <div role="tabpanel" class="fade tab-pane" id="c">
                    
                </div>
              
  
               
              </div>
                  
                </div>
              </div>
  
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@endsection


