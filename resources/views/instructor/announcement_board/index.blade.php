@extends('admin/layouts.master')
@section('title', 'All Message - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              {{-- <button type="button" class="btn btn-primary btn-sm" onclick="showForm()">Add</button> --}}
            <table id="example1" class="table table-bordered table-striped">
              
              <thead>
              
                <tr>
                  <th>Announcement</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($topic as $item)
                  @if ($item->status==1)
                      
                      <tr>
                        <td>
                          @php
                                $string = strip_tags($item->text);
                                if (strlen($string) > 100) {

                                    // truncate string
                                    $stringCut = substr($string, 0, 100);
                                    $endPoint = strrpos($stringCut, ' ');

                                    //if the string doesn't contain any space then it will cut without word basis.
                                    $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                }
                               //echo $string;
                            @endphp     
                          {{$string.' .....'}}
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" onclick="edit_a('{{$item->text}}')">View More</button>
                        </td>
                      </tr>
                      @endif
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<div class="modal fade" id="myModaledit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Announcement</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <p class="" id="txt"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
        
    });

    $(function() {
    $('#cb3').change(function() {
      $('#test').val(+ $(this).prop('checked'))
    })
  })

  $("#cb3").on('change', function() {
    if ($(this).is(':checked')) {
      $(this).attr('value', '1');
    }
    else {
      $(this).attr('value', '0');
    }});

    function showForm() {
      $("#myModaledit").modal('show')
    }

    function edit_a(text) {
        $("#txt").empty();
        $("#txt").text(text);
        $("#myModaledit").modal('show')

    }
</script>
@endsection