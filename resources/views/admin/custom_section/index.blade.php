@extends('admin/layouts.master')
@section('title', 'All Message - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Custom Section</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              <button type="button" class="btn btn-primary btn-sm" onclick="showForm()">Add</button>
            <table id="example1" class="table table-bordered table-striped">
              
              <thead>
              
                <tr>
                  <th>Title</th>
                  <th>Filter</th>
                  <th>Display BY</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php                              
                  use App\Categories;
                @endphp       
                  @foreach ($topic as $item)
                      <tr>
                        <td>
                          {{$item->title}}
                        </td>
                        <td>
                          @if ($item->category==1)
                              Course Category
                          @elseif($item->category==2)
                            Free Courses
                          @elseif($item->category==3)
                             Discounted Courses
                          @endif
                        </td>
                        <td>
                          @php                    
                            $getCat = explode("|", $item->display_by);          
                            $getCatTxt = '';
                            foreach ($getCat as $key => $value) {
                              $cat = Categories::where(['id'=>$value])->first();       
                              $getCatTxt .= $cat['title'].', ';
                            }
                          @endphp  
                          {{substr($getCatTxt, 0, -2)}}     
                        </td>
                        <td>
                          @if ($item->status)
                            <button type="button" class="btn btn-success btn-xs">Active</button>
                          @else
                            <button type="button" class="btn btn-danger btn-xs">Inactive</button>
                          @endif
                        </td>
                        <td>
                          <button type="button" class="btn btn-warning btn-sm" onclick="edit_a({{$item->id}})">Edit</button>
                        </td>
                      </tr>
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
          <h4 class="modal-title" id="myModalLabel">Section</h4>
        </div>
        <div class="box box-primary">
          <div class="panel panel-sum">
            <div class="modal-body">
              <form id="demo-form2" method="POST" action="{{url('add_custom_section')}}" data-parsley-validate class="form-horizontal form-label-left">
                {{ csrf_field() }}               
                    <input type="hidden" name="aid" id="id">
                    <div class="col-md-12">
                        <div class="extras-block">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label for="exampleInputDetails">Title :<sup class="redstar">*</sup></label>
                                    <input type="text" class="form-control" id="section" name="section">
                                </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group"> 
                              <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                             <li class="tg-list-item">
                               <input class="tgl tgl-skewed" id="cb10" type="checkbox" checked onchange="changeStatus(this.checked)">
                               <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb10"></label>
                             </li>
                             <input type="hidden" name="status"  id="j">
                           </div>
                          </div>


                          </div>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group"> 
                                    <label for="exampleInputDetails">Course Filter By :<sup class="redstar">*</sup></label>
                                    <select name="filterby" id="filterby" class="form-control" onchange="filter_by(this.value)">
                                      <option value="1">Categroy</option>
                                      <option value="2">Free</option>
                                      <option value="3">Discounted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="catDiv">
                                <div class="form-group"> 
                                    <label for="exampleInputDetails">Course Filter By :<sup class="redstar">*</sup></label>
                                    <select name="cat[]" id="cat" class="form-control" multiple>
                                      
                                    </select>
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

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    { 
      getCategories();
    });

    
    function showForm() {
      $("#myModaledit").modal('show')
      $("#id").val('')
    }

    function getCategories() {
      $.ajax({
        type: "get", 
        dataType: "json", 
        url: "{{url('/getCategories')}}",
        success: function(response) {
          $("#cat").empty();
          response.forEach(element => {
            $("#cat").append('<option value="'+element.id+'">'+element.title+'</option>');
          });
        }
      });
    }

    function filter_by(id) {
      if(id==1){
        $("#catDiv").removeClass('hidden')
      }
      else{
        $("#catDiv").addClass('hidden')
      }
    }

    function edit_a(id) {
      $("#myModaledit").modal('show')
      $("#id").val(id)
      $.ajax({
        type: "get", 
        dataType: "json", 
        url: "{{url('get_custom_section')}}/"+id,
        success: function(response) {          
          var str = response.display_by
          var res = str.split("|");
          $("#section").val(response.title)
          $("#filterby").val(response.category)
          $("#cat").val('');
          $.each(res, function(i,e){
              $("#cat option[value='" + e + "']").prop("selected", true);
          });
          filter_by(response.category)
        }
      });      
    }

    function changeStatus(id) {
        $("#status").val(id)
    }
   
</script>
@endsection