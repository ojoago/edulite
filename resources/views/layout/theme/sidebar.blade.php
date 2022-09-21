  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      
            @include('layout.theme.admin-sidebar')
        
          {{-- @if(getUserActiveRole()===300)
            @include('layout.theme.staff-sidebar')
          @endif
          @if(getUserActiveRole()===400)
            @include('layout.theme.student-sidebar')
          @endif
          @if(getUserActiveRole()===500)
            @include('layout.theme.parent-sidebar')
          @endif
          @if(getUserActiveRole()===100)
             @include('layout.theme.app-sidebar')
          @endif --}}
    </ul>

  </aside><!-- End Sidebar-->