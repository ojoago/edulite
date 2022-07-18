<!DOCTYPE html>
<html lang="en">
@include('layout.theme.head')

    @auth
        @include('layout.theme.header')
        @include('layout.theme.sidebar')
    @endauth
    <main id="main" class="main">
        @yield('content')
        @auth
        @include('layout.theme.footer')
    </main>
        <!-- include('layout.partials.modals') -->
    @endauth
    <!-- include('layout.partials.footer-scripts') -->

</body>

</html>