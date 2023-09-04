@include('layout.theme.head')
@guest
@include('layout.theme.guest.guest-header')
@include('layout.flash')
@yield('content')
@include('layout.theme.guest.guest-footer')
@endguest

@auth
@if(getSchoolPid() && !(session('status') && session('status')==2))
@include('layout.theme.school-header')

@include('layout.theme.sidebar')

@else
@include('layout.theme.header')
@endif
@include('layout.flash')
@yield('content')
@include('layout.modals.modal')
@include('layout.mainjs')
@include('layout.theme.footer')
</main>
@endauth

</body>

</html>