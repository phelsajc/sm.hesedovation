
<!-- /.box-header -->
<div class="box-body">

  <div class="table-responsive">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
     
      <tr>
        <th>#</th>                  
        <th>{{ __('adminstaticword.User') }}</th>
        <th>{{ __('adminstaticword.Course') }}</th>
        <th>{{ __('adminstaticword.OrderId') }}</th>
        <th>{{ __('adminstaticword.PaymentMethod') }}</th>
        <th>{{ __('adminstaticword.Status') }}</th>
        {{-- <th>{{ __('adminstaticword.View') }}</th> --}}
        <th>{{-- {{ __('adminstaticword.Delete') }} --}}Action</th>
      </tr>
      </thead>
      <tbody>
        @foreach($refunds as $key=>$refund)
        @if($refund->status == 0)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $refund->user['fname'] }}</td>
        <td>{{ $refund->courses->title }}</td>
        <td>{{ $refund->order->order_id }}</td>
        <td>{{ $refund->payment_method }}</td>
        <td>
           
            @if($refund->status ==1)
            {{ __('adminstaticword.Refunded') }}
            @else
            {{ __('adminstaticword.Pending') }}
            @endif
             
        </td>
        
        <td><a class="btn btn-success btn-sm" href="{{url('refundorder/'.$refund->id.'/edit')}}">
          view</a>
          <a title="Delete" data-toggle="modal" data-target="#refund_order{{ $refund->id }}" class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i>
          </a>
        </td>

        {{-- <td><form  method="post" action="{{url('refundorder/'.$refund->id)}}
              "data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
            <button  type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
          </form>
        </td> --}}

        <div id="refund_order{{ $refund->id }}" class="delete-modal modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="delete-icon"></div>
              </div>
              <div class="modal-body text-center">
                <h4 class="modal-heading">Are You Sure ?</h4>
                <p>Do you really want to delete this Refund Order ? This process cannot be undone.</p>
              </div>
              <div class="modal-footer">
                   <form method="post" action="{{url('refundorder/'.$refund->id)}} class="pull-right">
                      {{csrf_field()}}
                      {{method_field("DELETE")}}
                   <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                  <button type="submit" class="btn btn-danger">Yes</button>
                </form>
              </div>
            </div>
          </div>
      </div>


      </tr>
      @endif
      @endforeach
      
      </tbody>
    </table>
  </div>
</div>
<!-- /.box-body -->



