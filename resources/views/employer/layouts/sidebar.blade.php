<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(Auth::User()->user_img != null || Auth::User()->user_img !='')
          <img src="{{ asset('images/user_img/'.Auth::User()->user_img)}}" class="img-circle" alt="User Image">

          @else
          <img src="{{ asset('images/default/user.jpg') }}" class="img-circle" alt="User Image">

          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::User()->fname }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Employer</a>
        </div>
      </div>
 

      @if(Auth::User()->role == "employer")
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">{{ __('adminstaticword.Navigation') }} </li>


          <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('courselang') }} treeview">
            <a href="#">
                <i class="flaticon-browser-1"></i>Manage Jobs
                <i class="fa fa-angle-left pull-right"></i>
            </a>

            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('courselang') }} {{ Nav::isRoute('assignment.view') }} treeview">
                
                  <li class="{{ Nav::isResource('add-job') }}"><a href="{{url('add-job')}}"><i class="flaticon-document" aria-hidden="true"></i><span>Add Job</span></a></li>

                  <li class="{{ Nav::isResource('all-jobs') }}"><a href="{{url('all-jobs')}}"> <i class="flaticon-translation" aria-hidden="true"></i></i><span> All Jobs</span></a></li>
                    
                 
                </li>
              </ul>
          </li>
          


        <ul>
      @endif


    </section>
    <!-- /.sidebar -->
</aside>