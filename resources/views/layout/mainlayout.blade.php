<!DOCTYPE html>
<html lang="en">
@include('layout.theme.head')
@auth
@if(getSchoolPid())
@include('layout.theme.school-header')
@include('layout.theme.sidebar')
@else
@include('layout.theme.header')
@endif
@endauth
<main id="main" class="main">
    @yield('content')
    @auth
    @include('layout.modals.modal')
    @include('layout.theme.footer')
    @include('layout.mainjs')
</main>
<!-- include('layout.partials.modals') -->
@endauth
<!-- include('layout.partials.footer-scripts') -->

</body>

</html>