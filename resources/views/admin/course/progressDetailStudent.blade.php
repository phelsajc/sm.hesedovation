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
                  <label for="">Student: {{$user_info->fname}} {{$user_info->lname}}</label>
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
                    <button type="button" class="btn btn-success btn-xs">View Comments</button>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="b">
                    
                </div>
                <div role="tabpanel" class="fade tab-pane" id="c">
                  
                  
                  <table id="tblCourseMember" class="table table-bordered table-striped compact">
                      <thead>
                          <tr>
                          <th>Title</th>
                          <th>Total No. of Questions.</th>
                           <th>Correct No. of Questions</th>
                         <th>Per Question Mark</th>
                          <th>Total Marks</th>
                          <th>Action</th>
                          </tr>
                      </thead>
                      @foreach ($quiz_topic as $value)
                          <tr>
                            <td>{!!$value['title']!!}</td>
                           
                              @php 
                                $topics = App\QuizTopic::where('course_id', $value['id'])->get();
                              @endphp

                                @php
                                  $get_total_topic = 0;
                                  $get_per_q = 0;
                                  $get_qu_count = 0;
                                  $get_id = 0;
                                @endphp

                                @php
                                $get_id = 1;
                                $qu_count = 0;
                                $quizz = App\Quiz::where('topic_id', $value['id'])->get(); 
                                @endphp

                                @foreach($quizz as $quiz)
                                @if($quiz->topic_id == $value['id'])
                                  @php 
                                    $qu_count++;
                                  @endphp
                                @endif
                                @endforeach

                                @php 

                                $get_per_q =  $value['per_q_mark']; 
                                $get_qu_count = $qu_count; 
                                $get_total_topic =  $value['per_q_mark']*$qu_count;

                                @endphp
                            <td>
                              {{$get_qu_count}}
                            </td>

                              @php
                                  $ca=0;
                                  $ct='';
                                  $mark = 0;
                                  $ans = App\QuizAnswer::where('topic_id',$value['id'])->get(); 
                                  $ans_ans = array();
                                  $check_pg_or_sa=0;
                                  $counter_array = array();
                                  
 /*  dd($ans); */
                                foreach ($ans as $key => $values) {
                                    $row = array();
                                    $row['answer'] = $values->answer;
                                    $row['user_answer'] = $values->user_answer;
                                    $q = App\Quiz::where('id', $values->question_id)->first();
                                    $row['type'] = $q->type;
                                    $row['ans_id'] = $values->id;
                                    $row['id'] = $values->question_id;
                                    $row['points'] = $values->points;
                                    if($q->type=="cb"){
                                        if($values->ans1){
                                            $user_answer_array[] = $values->ans1;
                                        }
                                        if($values->ans2){
                                            $user_answer_array[] = $values->ans2;
                                        }
                                        if($values->ans3){
                                            $user_answer_array[] = $values->ans3;
                                        }
                                        if($values->ans4){
                                            $user_answer_array[] = $values->ans4;
                                        }  
                                        
                                        if($q->ans1){
                                            $ca_answer_array[] = $q->a;
                                        }
                                        if($q->ans2){
                                            $ca_answer_array[] = $q->b;
                                        }
                                        if($q->ans3){
                                            $ca_answer_array[] = $q->c;
                                        }
                                        if($q->ans4){
                                            $ca_answer_array[] = $q->d;
                                        }  
                                    }
                                    $ans_ans[] = $row;
                                }
                                
                              @endphp
                              @foreach ($ans_ans as $answer)
                              @php
                              $ct = $answer['type'];
                              @endphp
                              {{-- @if($answer['type']=="mc")
                              @if ($answer['answer'] == $answer['user_answer'] )
                                @php
                                  $mark++;
                                  $ca++;
                                  if (!in_array("a_".$answer['id'], $counter_array)) {
                                      array_push($counter_array,"a_".$answer['id']);
                                  }
                                @endphp
                              @endif
                            @elseif($answer['type']=="sc")
                              @if ($answer['answer'] == $answer['user_answer'] )
                                @php
                                  $mark++;
                                  $ca++;
                                  if (!in_array("a_".$answer['id'], $counter_array)) {
                                      array_push($counter_array,"a_".$answer['id']);
                                  }
                                @endphp
                              @endif
                            @elseif($answer['type']=="cb")
                              @if (array_diff($user_answer_array, $ca_answer_array) === array_diff($ca_answer_array, $user_answer_array))
                                @php
                                  $mark++;
                                  $ca++;
                                  if (!in_array("a_".$answer['id'], $counter_array)) {
                                      array_push($counter_array,"a_".$answer['id']);
                                  }
                                @endphp
                              @endif
                            @endif --}}

                            @if($answer['type']=="mc")
                        @if ($answer['answer'] == $answer['user_answer'] )
                          @php
                            /* echo $answer['type'] ; */
                            $mark++;
                            $ca++;
                            if (!in_array("a_".$answer['id'], $counter_array)) {
                                array_push($counter_array,"a_".$answer['id']);
                            }
                          @endphp
                        @endif
                      @elseif($answer['type']=="sc")
                        @if ($answer['answer'] == $answer['user_answer'] )
                          @php
                            /* echo $answer['type'] ; */
                            $mark++;
                            $ca++;
                            if (!in_array("a_".$answer['id'], $counter_array)) {
                                array_push($counter_array,"a_".$answer['id']);
                            }
                          @endphp
                        @endif
                      @elseif($answer['type']=="cb")
                        @if (array_diff($user_answer_array, $ca_answer_array) === array_diff($ca_answer_array, $user_answer_array))
                          @php
                            $mark++;
                            $ca++;
                            if (!in_array("a_".$answer['id'], $counter_array)) {
                                array_push($counter_array,"a_".$answer['id']);
                            }
                          @endphp
                        @endif
                        @elseif($answer['type']=="pg"||$answer['type']=="sa")
                          @if ($answer['points'])
                              @php
                                $check_pg_or_sa=$check_pg_or_sa+$answer['points'];
                              @endphp
                          @endif
                      @endif

                              @endforeach
                          <td>
                              {{-- {{$ca}} --}}
                              {{sizeof($counter_array)}} x
                            </td> 

                            <td>{!!$get_per_q!!}</td>
                            @php
                                $correct = ($mark*$get_per_q) + $check_pg_or_sa;
                            @endphp
                            <td>
                              {{$correct}} 
                            </td>
                            <td>
                             <button type="button" class="btn btn-xs btn-info" onclick="checkResults({{$value['id']}})">View</button>
                            </td>
                          </tr>
                      @endforeach
                  </table>
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

@section('scripts')

<script type="text/javascript">

  $(document).ready(function()
  { 

  });

  function checkResults(id) {
    location = "{{URL::to('/checkResults/')}}/"+id
  }

</script>

@endsection

