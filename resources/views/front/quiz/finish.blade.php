@extends('theme.master')
@section('title',"Show Report")
@section('content')
 <section class="main-wrapper finish-main-block">
   <div class="container">
    <br/>
  @if ($auth)
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="">
          <div class="question-block">
           
          @if($topics->show_ans==1)

          <div class="question-block">
            <h3 class="text-center main-block-heading">{{ __('frontstaticword.answerreoprt') }}</h3>
            <br/>
            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>{{ __('frontstaticword.Question') }}</th> 
                  <th>Type</th> 
                  <th style="color: red;">{{ __('frontstaticword.YourAnswer') }}</th>
                  <th style="color: #48A3C6;">{{ __('frontstaticword.CorrectAnswer') }}</th>
                  <th style="color: #48A3C6;">Action</th>
                </tr>
              </thead>
              <tbody>
                
                @php
                $x = $count_questions;               
                $y = 1;
                @endphp
                @foreach($ans_ans as $key=> $a)
                    <tr>
                      <td>{{ $a['question'] }}</td>
                      <td>{{ $a['type'] }}</td>
                      <td>

                        @if ($a['type']=="mc"||$a['type']=="pg"||$a['type']=="sa")
                            {{ $a['user_answer'] }}
                        @elseif($a['type']=="cb")
                                {{ $a['ans1'] }} ,{{ $a['ans2'] }} ,{{ $a['ans3'] }}, {{ $a['ans4'] }}
                        @elseif($a['type']=="sc")
                            @if ($a['user_answer']=="A")
                              True
                            @else
                              False
                            @endif
                        @endif

                      
                      </td>
                      <td>
                        
                        @if ($a['type']=="mc")
                                {{ $a['answer'] }}
                        @elseif($a['type']=="cb")
                                {{ $a['cans1'] }} ,{{ $a['cans2'] }} ,{{ $a['cans3'] }}, {{ $a['cans4'] }}
                        @elseif($a['type']=="sc")
                            @if ($a['answer']=="A")
                              True
                            @else
                              False
                            @endif
                        @elseif($a['type']=="pg"||$a['type']=="sa")
                            {{ $a['custom_answer'] }}
                        @endif
                      
                      </td>

                      <td>
                        @if ($a['type']=="pg"||$a['type']=="sa")
                            @if ($a['points'])
                                {{$a['points']}}
                              @else
                              <button type="button" class="btn btn-xs btn-info" onclick="givePoints({{$a['ans_id']}})">Set Points</button>
                            @endif
                        @endif
                      </td>

                      {{-- <td>{{ $a->quiz->type }}</td>
                       <td>{{ $a->user_answer }}</td>
                      <td>{{ $a->answer }}</td> --}}
                     
                    
                    </tr>
                    @php                
                      $y++;
                      if($y > $x){                 
                        break;
                      }
                      
                    @endphp
                 
                @endforeach              
               
              </tbody>
            </table>
            
          </div>



          @endif

          <div id="printableArea">

           <h3 class="text-center main-block-heading">{{ __('frontstaticword.scorecard') }} </h3>
            <br/>

            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>{{ __('frontstaticword.TotalQuestion') }}</th>
                  <th>{{ __('frontstaticword.CorrectQuestions') }}</th>
                  <th>{{ __('frontstaticword.PerQuestionMark') }}</th>
                  <th>{{ __('frontstaticword.TotalMarks') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$count_questions}}</td>
                  <td>
                    @php
                      $mark = 0;
                      $ca=0;
                      $correct = collect();
                    @endphp
                    @foreach ($ans_ans as $answer)

                      @if($answer['type']=="mc")
                        @if ($answer['answer'] == $answer['user_answer'] )
                          @php
                          /* echo $answer['type'] ; */
                            $mark++;
                            $ca++;
                          @endphp
                        @endif
                      @elseif($answer['type']=="sc")
                        @if ($answer['answer'] == $answer['user_answer'] )
                          @php
                          /* echo $answer['type'] ; */
                            $mark++;
                            $ca++;
                          @endphp
                        @endif
                      @elseif($answer['type']=="cb")
                        @if (array_diff($user_answer_array, $ca_answer_array) === array_diff($ca_answer_array, $user_answer_array))
                          @php
                            $mark++;
                            $ca++;
                          @endphp
                        @endif
                        @elseif($answer['type']=="pg"||$answer['type']=="sa")
                          @if ($answer['points'])
                              @php
                                  $ca=$ca+$answer['points'];
                              @endphp
                          @endif
                      @endif
                      
                    @endforeach
                    {{$ca}}
                  </td>
                  <td>{{$topics->per_q_mark}}</td>
                    @php
                        $correct = $mark*$topics->per_q_mark;
                    @endphp
                  <td>{{$correct}}</td>
                </tr>
              </tbody>
            </table>
           
            <br/>
            <h2 class="text-center">{{ __('frontstaticword.ThankYou') }}</h2>
          </div>

          

            <div class="finish-btn text-center">
              
              <input type="button" class="btn btn-primary"  onclick="printDiv('printableArea')" value="Print" />

              @if($topics->quiz_again == '1')
              <a href="{{route('tryagain',$topics->id)}}" class="btn btn-primary">{{ __('frontstaticword.TryAgain') }} </a>
              @endif
              <a href="{{ route('course.content',['id' => $topics->course_id, 'slug' => $topics->courses->slug ]) }}" class="btn btn-secondary">{{ __('frontstaticword.Back') }} </a>

              


            </div>

          </div>
        </div>
      </div>
    </div>
  @endif
</div>
</section>
<br/>


<div id="pointsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Set Points</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        
        <form id="demo-form2" method="post" 
            data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
                    
            <div class="row">
              <div class="col-md-12">
                <label for="detail">Answer:<sup class="redstar">*</sup></label>
                <textarea name="custom_answer" id="custom_answer" rows="4"  class="form-control" placeholder=""></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="detail">Points:<sup class="redstar">*</sup></label>
                <input type="text" name="points" id="points" class="form-control">
              </div>
            </div>
            <br>
        </form>
    </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('frontstaticword.Close') }}</button>
        <button type="button" onclick="savePoints()" class="btn btn-default btn-danger">{{ __('frontstaticword.Submit') }}</button>
      </div>
    </div>

  </div>
</div>
@endsection


@section('custom-script')

<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
   }
</script>

<script type="text/javascript">
  var getId;
  $(document).ready(function()
  { 
  });

  function givePoints(id) {
    getId = id;
    $("#pointsModal").modal('show')
  }

  function savePoints() {    
    $.ajax({
            url: "{{ url('givePoints') }}",
            type: "post",
            data:{
              ans_id: getId,
              custom_ans: $("#custom_answer").val(),
              points: $("#points").val(),
            },            
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'JSON',
            success: function(data) {
                $("#pointsModal").modal('hide');
                $("#custom_answer").val('');
                $("#points").val('');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            }
        });
  }

</script>

@endsection


