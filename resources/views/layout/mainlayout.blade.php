@include('layout.theme.head')
@guest
    @include('layout.theme.guest.guest-header')
    @include('layout.flash')
    @yield('content')
    @include('layout.theme.guest.guest-footer')
@endguest

@auth
    @if(getSchoolPid())
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
<!-- include('layout.partials.modals') -->
@endauth
<!-- include('layout.partials.footer-scripts') -->

</body>

</html>