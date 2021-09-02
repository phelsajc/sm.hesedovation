@extends('admin.layouts.master')
@section('title', 'Add Question - Admin')
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
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.Quiz') }} {{ __('adminstaticword.Question') }}</h3>
        </div>
        <div class="box-header">
          <a data-toggle="modal" data-target="#myModalquiz" href="#" class="btn btn-info btn-sm">+   {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Question') }}</a>

        </div>

        
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('adminstaticword.Course') }}</th>
                  <th>{{ __('adminstaticword.Topic') }}</th>
                  <th>{{ __('adminstaticword.Question') }}</th>
                  <th>{{ __('adminstaticword.A') }}</th>
                  <th>{{ __('adminstaticword.B') }}</th>
                  <th>{{ __('adminstaticword.C') }}</th>
                  <th>{{ __('adminstaticword.D') }}</th>
                  <th>{{ __('adminstaticword.Answer') }}</th>
                  <th>{{ __('adminstaticword.Edit') }}</th>
                  <th>{{ __('adminstaticword.Delete') }}</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach($quizes as $quiz)
                <?php $i++;?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td>{{$quiz->course_id}}</td>
                    <td>{{$quiz->topic_id}}</td> 
                    <td>{{$quiz->question}}</td>
                    <td>{{$quiz->a}}</td>
                    <td>{{$quiz->b}}</td>
                    <td>{{$quiz->c}}</td>
                    <td>{{$quiz->c}}</td>
                    <td>{{$quiz->answer}}</td>
                    <td>
                      <a data-toggle="modal" data-target="#myModaledit{{$quiz->id}}" href="#" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                    </td>
                    <td>
                      <form  method="post" action="{{url('admin/questions/'.$quiz->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash-o"></i></button>
                      </form>
                    </td>
                  </tr>  

                  <!--Model for edit question-->
                  {{-- <div class="modal fade" id="myModaledit{{$quiz->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Question') }}</h4>
                        </div>
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">
                              <form id="demo-form2" method="POST" action="{{route('questions.update', $quiz->id)}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <input type="hidden" name="course_id" value="{{ $topic->course_id }}"  />

                                <input type="hidden" name="topic_id" value="{{ $topic->id }}"  /> 

                                <input type="text" name="topic_id" value="{{ $quiz->type }}"  />

                                <div class="row"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question" >{{ $quiz->question }}</textarea>
                                    <br>

                                    <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                    <select style="width: 100%" name="answer" class="form-control js-example-basic-single">
                                      <option {{ $quiz->answer == 'A' ? 'selected' : ''}} value="A">{{ __('adminstaticword.A') }}</option>
                                      <option {{ $quiz->answer == 'B' ? 'selected' : ''}} value="B">{{ __('adminstaticword.B') }}</option>
                                      <option {{ $quiz->answer == 'C' ? 'selected' : ''}} value="C">{{ __('adminstaticword.C') }}</option>
                                      <option  {{ $quiz->answer == 'D' ? 'selected' : ''}} value="D">{{ __('adminstaticword.D') }}</option>
                                    </select>
                                  </div>
                                
                             
                                  <div class="col-md-6">
                                   
                                    <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="a" value="{{ $quiz->a }}" class="form-control" placeholder="Enter Option A">
                                  </div>
                                 
                                  <div class="col-md-6">
                                    <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="b" value="{{ $quiz->b }}" class="form-control" placeholder="Enter Option B" />
                                  </div>

                                  <div class="col-md-6">
                                
                                    <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label> 
                                    <input type="text" name="c" value="{{ $quiz->c }}" class="form-control" placeholder="Enter Option C" />
                                  </div>

                                  <div class="col-md-6">
                                 
                                    <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="d" value="{{ $quiz->d }}" class="form-control" placeholder="Enter Option D" />
                                  </div>

                                </div>
                                <br>

                          <div class="col-md-12">
                            <div class="extras-block">
                              <h4 class="extras-heading">Images And Video For Question</h4>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                                   

                                    <label for="exampleInputDetails">Add Video To Question :<sup class="redstar">*</sup></label>
                                    <input type="text" name="question_video_link" value="{{ $quiz->question_video_link }}" class="form-control" placeholder="https://myvideolink.com/embed/.." />

                                    <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                    <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                    

                                    <label for="exampleInputDetails">Add Image To Question :<sup class="redstar">*</sup></label>
                                    <input type="file" name="question_img" class="form-control"  />


                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                    <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                               
                              
                                <div class="box-footer">
                                  <button type="submit" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> --}}

                  <div class="modal fade" id="myModaledit{{$quiz->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Question') }}</h4>
                        </div>
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">
                              <form id="demo-form2" method="POST" action="{{route('questions.update', $quiz->id)}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <input type="hidden" name="course_id" value="{{ $topic->course_id }}"  />

                                <input type="hidden" name="topic_id" value="{{ $topic->id }}"  /> 

                                <input type="hidden" name="topic_id" value="{{ $quiz->type }}"  />

                                {{-- <div class="row"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question" >{{ $quiz->question }}</textarea>
                                    <br>

                                    <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                    <select style="width: 100%" name="answer" class="form-control js-example-basic-single">
                                      <option {{ $quiz->answer == 'A' ? 'selected' : ''}} value="A">{{ __('adminstaticword.A') }}</option>
                                      <option {{ $quiz->answer == 'B' ? 'selected' : ''}} value="B">{{ __('adminstaticword.B') }}</option>
                                      <option {{ $quiz->answer == 'C' ? 'selected' : ''}} value="C">{{ __('adminstaticword.C') }}</option>
                                      <option  {{ $quiz->answer == 'D' ? 'selected' : ''}} value="D">{{ __('adminstaticword.D') }}</option>
                                    </select>
                                  </div>
                                
                             
                                  <div class="col-md-6">
                                   
                                    <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="a" value="{{ $quiz->a }}" class="form-control" placeholder="Enter Option A">
                                  </div>
                                 
                                  <div class="col-md-6">
                                    <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="b" value="{{ $quiz->b }}" class="form-control" placeholder="Enter Option B" />
                                  </div>

                                  <div class="col-md-6">
                                
                                    <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label> 
                                    <input type="text" name="c" value="{{ $quiz->c }}" class="form-control" placeholder="Enter Option C" />
                                  </div>

                                  <div class="col-md-6">
                                 
                                    <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="d" value="{{ $quiz->d }}" class="form-control" placeholder="Enter Option D" />
                                  </div>

                                </div> --}}

                                <div class="row">                
                                  <div class="col-md-6">
                                    <label for="">Type</label>
                                    <select style="width: 100%" name="quiz_type_edit" id="quiz_type_edit" onchange="quizType_edit(this.value)" class="form-control">
                                      <option value="none" selected disabled hidden> 
                                        {{ __('adminstaticword.SelectanOption') }}
                                      </option>
                                      <option value="mc">Multiple Choise</option>
                                      <option value="cb">Checkbox</option>
                                      <option value="pg">Paragraph</option>
                                      <option value="sa">Short Answer</option>
                                      <option value="sc">Switch</option>
                                    </select>
                                  </div>
                  
                                </div>

                                <div class="row" id="cbQuiz_edit"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="cb_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                                    <br>
                  
                                    <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                    <select style="width: 100%" name="cb_answer[]" id="cb_answer_edit" class="form-control js-example-basic-single">
                                      <option value="none" selected disabled hidden> 
                                        {{ __('adminstaticword.SelectanOption') }}
                                      </option>
                                      <option value="A">{{ __('adminstaticword.A') }}</option>
                                      <option value="B">{{ __('adminstaticword.B') }}</option>
                                      <option value="C">{{ __('adminstaticword.C') }}</option>
                                      <option value="D">{{ __('adminstaticword.D') }}</option>
                                    </select>
                                  </div>
                                
                             
                                  <div class="col-md-6">
                                   
                                    <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="cb_a" class="form-control" placeholder="Enter Option A">
                                  </div>
                                 
                                  <div class="col-md-6">
                                    <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="cb_b" class="form-control" placeholder="Enter Option B" />
                                  </div>
                  
                                  <div class="col-md-6">
                                
                                    <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="_edit" class="form-control" placeholder="Enter Option C" />
                                  </div>
                  
                                  <div class="col-md-6">
                                 
                                    <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="cb_d" class="form-control" placeholder="Enter Option D" />
                                  </div>
                                </div>
                  
                                <div class="row hidden" id="mcQuiz_edit"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="mc_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                                    <br>
                  
                                    <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                    <select style="width: 100%" name="mc_answer" class="form-control js-example-basic-single">
                                      <option value="none" selected disabled hidden> 
                                        {{ __('adminstaticword.SelectanOption') }}
                                      </option>
                                      <option value="A">{{ __('adminstaticword.A') }}</option>
                                      <option value="B">{{ __('adminstaticword.B') }}</option>
                                      <option value="C">{{ __('adminstaticword.C') }}</option>
                                      <option value="D">{{ __('adminstaticword.D') }}</option>
                                    </select>
                                  </div>
                                
                             
                                  <div class="col-md-6">
                                   
                                    <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="mc_a" class="form-control" placeholder="Enter Option A">
                                  </div>
                                 
                                  <div class="col-md-6">
                                    <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="mc_b" class="form-control" placeholder="Enter Option B" />
                                  </div>
                  
                                  <div class="col-md-6">
                                
                                    <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="mc_c" class="form-control" placeholder="Enter Option C" />
                                  </div>
                  
                                  <div class="col-md-6">
                                 
                                    <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                                    <input type="text" name="mc_d" class="form-control" placeholder="Enter Option D" />
                                  </div>
                                </div>
                                
                                <div class="row hidden" id="pgQuiz_edit"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="pg_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                                    <br>
                                  </div>
                                </div>
                                
                                <div class="row hidden" id="saQuiz_edit"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <input type="text" name="sa_question" class="form-control" placeholder="Enter Your Question">
                                    <br>
                                  </div>
                                </div>
                  
                                
                                <div class="row hidden" id="scQuiz_edit"> 
                                  <div class="col-md-6">
                                    <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                                    <textarea name="sc_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                                    <br>
                  
                                    <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                                    <select style="width: 100%" name="sc_answer" class="form-control js-example-basic-single">
                                      <option value="none" selected disabled hidden> 
                                        {{ __('adminstaticword.SelectanOption') }}
                                      </option>
                                      <option value="A">True</option>
                                      <option value="B">False</option>
                                    </select>
                                  </div>              
                                </div>
                                <br>

                          <div class="col-md-12">
                            <div class="extras-block">
                              <h4 class="extras-heading">Images And Video For Question</h4>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                                   

                                    <label for="exampleInputDetails">Add Video To Question :<sup class="redstar">*</sup></label>
                                    <input type="text" name="question_video_link" value="{{ $quiz->question_video_link }}" class="form-control" placeholder="https://myvideolink.com/embed/.." />

                                    <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                    <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                    

                                    <label for="exampleInputDetails">Add Image To Question :<sup class="redstar">*</sup></label>
                                    <input type="file" name="question_img" class="form-control"  />


                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                    <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                               
                              
                                <div class="box-footer">
                                  <button type="submit" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--Model close -->
          
      
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!--Model for add question -->
<div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Question') }}</h4>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{route('questions.store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}

              <input type="hidden" name="course_id" value="{{ $topic->course_id }}"  />

              <input type="hidden" name="topic_id" value="{{ $topic->id }}"  />

              <div class="row">                
                <div class="col-md-6">
                  <label for="">Type</label>
                  <select style="width: 100%" name="quiz_type" id="quiz_type" onchange="quizType(this.value)" class="form-control">
                    <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>
                    <option value="mc">Multiple Choise</option>
                    <option value="cb">Checkbox</option>
                    <option value="pg">Paragraph</option>
                    <option value="sa">Short Answer</option>
                    <option value="sc">Switch</option>
                  </select>
                </div>

              </div>

              <div class="row" id="cbQuiz"> 
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                  <textarea name="cb_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                  <br>

                  <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                  <select style="width: 100%" name="cb_answer[]" id="cb_answer" class="form-control js-example-basic-single">
                    <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>
                    <option value="A">{{ __('adminstaticword.A') }}</option>
                    <option value="B">{{ __('adminstaticword.B') }}</option>
                    <option value="C">{{ __('adminstaticword.C') }}</option>
                    <option value="D">{{ __('adminstaticword.D') }}</option>
                  </select>
                </div>
              
           
                <div class="col-md-6">
                 
                  <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="cb_a" class="form-control" placeholder="Enter Option A">
                </div>
               
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="cb_b" class="form-control" placeholder="Enter Option B" />
                </div>

                <div class="col-md-6">
              
                  <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="cb_c" class="form-control" placeholder="Enter Option C" />
                </div>

                <div class="col-md-6">
               
                  <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="cb_d" class="form-control" placeholder="Enter Option D" />
                </div>
              </div>

              <div class="row hidden" id="mcQuiz"> 
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                  <textarea name="mc_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                  <br>

                  <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                  <select style="width: 100%" name="mc_answer" class="form-control js-example-basic-single">
                    <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>
                    <option value="A">{{ __('adminstaticword.A') }}</option>
                    <option value="B">{{ __('adminstaticword.B') }}</option>
                    <option value="C">{{ __('adminstaticword.C') }}</option>
                    <option value="D">{{ __('adminstaticword.D') }}</option>
                  </select>
                </div>
              
           
                <div class="col-md-6">
                 
                  <label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="mc_a" class="form-control" placeholder="Enter Option A">
                </div>
               
                <div class="col-md-6">
                  <label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="mc_b" class="form-control" placeholder="Enter Option B" />
                </div>

                <div class="col-md-6">
              
                  <label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="mc_c" class="form-control" placeholder="Enter Option C" />
                </div>

                <div class="col-md-6">
               
                  <label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup class="redstar">*</sup></label>
                  <input type="text" name="mc_d" class="form-control" placeholder="Enter Option D" />
                </div>
              </div>
              
              <div class="row hidden" id="pgQuiz"> 
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                  <textarea name="pg_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                  <br>
                </div>
              </div>
              
              <div class="row hidden" id="saQuiz"> 
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                  <input type="text" name="sa_question" class="form-control" placeholder="Enter Your Question">
                  <br>
                </div>
              </div>

              
              <div class="row hidden" id="scQuiz"> 
                <div class="col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
                  <textarea name="sc_question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
                  <br>

                  <label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                  <select style="width: 100%" name="sc_answer" class="form-control js-example-basic-single">
                    <option value="none" selected disabled hidden> 
                      {{ __('adminstaticword.SelectanOption') }}
                    </option>
                    <option value="A">True</option>
                    <option value="B">False</option>
                  </select>
                </div>              
              </div>

              <br>
             
              <div class="col-md-12">
                <div class="extras-block">
                  <h4 class="extras-heading">Video And Image For Question</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                        

                        <label for="exampleInputDetails">Add Video To Question :<sup class="redstar">*</sup></label>
                        <input type="text" name="question_video_link" class="form-control" placeholder="https://myvideolink.com/embed/.." />
                        <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                        <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                       
                        <label for="exampleInputDetails">Add Image To Question :<sup class="redstar">*</sup></label>
                        <input type="file" name="question_img" class="form-control"  />
                        <small class="text-danger">{{ $errors->first('question_img') }}</small>
                         <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                      </div>
                    </div>
                    <br>

                    <br>
                  </div>
                </div>
              </div>              
             
            
              <div class="box-footer">
                <button type="submit" class="btn btn-md col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!--Model close --> 


</section> 

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
        
    });

    function quizType(id) {
      if(id=="mc"){
        $("#mcQuiz").removeClass('hidden')
        $("#cbQuiz").addClass('hidden')
        $("#pgQuiz").addClass('hidden')
        $("#saQuiz").addClass('hidden')
        $("#cb_answer").select2('destroy'); 
        $("#cb_answer").removeAttr("multiple")
        $("#cb_answer").select2(); 
        $('#cb_answer').val(null).trigger('change');        
      }

      if(id=="cb"){
        $("#cbQuiz").removeClass('hidden')
        $("#mcQuiz").addClass('hidden')
        $("#pgQuiz").addClass('hidden')
        $("#saQuiz").addClass('hidden')
        $("#scQuiz").addClass('hidden')
        $("#cb_answer").select2('destroy'); 
        $("#cb_answer").attr("multiple",true)
        $("#cb_answer").select2(); 
        $('#cb_answer').val(null).trigger('change');
      }

      if(id=="pg"){
        $("#pgQuiz").removeClass('hidden')
        $("#mcQuiz").addClass('hidden')
        $("#cbQuiz").addClass('hidden')
        $("#saQuiz").addClass('hidden')
        $("#scQuiz").addClass('hidden')
        $("#cb_answer").select2('destroy'); 
        $("#cb_answer").removeAttr("multiple")
        $("#cb_answer").select2(); 
        $('#cb_answer').val(null).trigger('change');
      }

      if(id=="sa"){
        $("#saQuiz").removeClass('hidden')
        $("#mcQuiz").addClass('hidden')
        $("#cbQuiz").addClass('hidden')
        $("#pgQuiz").addClass('hidden')
        $("#scQuiz").addClass('hidden')
        $("#cb_answer").select2('destroy'); 
        $("#cb_answer").removeAttr("multiple")
        $("#cb_answer").select2(); 
        $('#cb_answer').val(null).trigger('change');
      }

      if(id=="sc"){
        $("#scQuiz").removeClass('hidden')
        $("#saQuiz").addClass('hidden')
        $("#mcQuiz").addClass('hidden')
        $("#cbQuiz").addClass('hidden')
        $("#pgQuiz").addClass('hidden')
        $("#cb_answer").select2('destroy'); 
        $("#cb_answer").removeAttr("multiple")
        $("#cb_answer").select2(); 
        $('#cb_answer').val(null).trigger('change');
      }

    }

    function quizType_edit(id) {
      if(id=="mc"){
        $("#mcQuiz_edit").removeClass('hidden')
        $("#cbQuiz_edit").addClass('hidden')
        $("#pgQuiz_edit").addClass('hidden')
        $("#saQuiz_edit").addClass('hidden')
        $("#cb_answer_edit").select2('destroy'); 
        $("#cb_answer_edit").removeAttr("multiple")
        $("#cb_answer_edit").select2(); 
        $('#cb_answer_edit').val(null).trigger('change');
      }

      if(id=="cb"){
        $("#cbQuiz_edit").removeClass('hidden')
        $("#mcQuiz_edit").addClass('hidden')
        $("#pgQuiz_edit").addClass('hidden')
        $("#saQuiz_edit").addClass('hidden')
        $("#scQuiz_edit").addClass('hidden')
        $("#cb_answer_edit").select2('destroy'); 
        $("#cb_answer_edit").attr("multiple",true)
        $("#cb_answer_edit").select2(); 
        $('#cb_answer_edit').val(null).trigger('change');
      }

      if(id=="pg"){
        $("#pgQuiz_edit").removeClass('hidden')
        $("#mcQuiz_edit").addClass('hidden')
        $("#cbQuiz_edit").addClass('hidden')
        $("#saQuiz_edit").addClass('hidden')
        $("#scQuiz_edit").addClass('hidden')
        $("#cb_answer_edit").select2('destroy'); 
        $("#cb_answer_edit").removeAttr("multiple")
        $("#cb_answer_edit").select2(); 
        $('#cb_answer_edit').val(null).trigger('change');
      }

      if(id=="sa"){
        $("#saQuiz_edit").removeClass('hidden')
        $("#mcQuiz_edit").addClass('hidden')
        $("#cbQuiz_edit").addClass('hidden')
        $("#pgQuiz_edit").addClass('hidden')
        $("#scQuiz_edit").addClass('hidden')
        $("#cb_answer_edit").select2('destroy'); 
        $("#cb_answer_edit").removeAttr("multiple")
        $("#cb_answer_edit").select2(); 
        $('#cb_answer_edit').val(null).trigger('change');
      }

      if(id=="sc"){
        $("#scQuiz_edit").removeClass('hidden')
        $("#saQuiz_edit").addClass('hidden')
        $("#mcQuiz_edit").addClass('hidden')
        $("#cbQuiz_edit").addClass('hidden')
        $("#pgQuiz_edit").addClass('hidden')
        $("#cb_answer_edit").select2('destroy'); 
        $("#cb_answer_edit").removeAttr("multiple")
        $("#cb_answer_edit").select2(); 
        $('#cb_answer_edit').val(null).trigger('change');
      }

    }
</script>
@endsection
