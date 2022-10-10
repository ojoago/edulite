    <div class="text-center"> <span id="quickFlash"></span> </div>
    </main>
    <!-- ======= Footer ======= -->
    <div style=" flex-grow: 1;"></div>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>{{env('APP_NAME', APP_NAME)}}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Developed by <a href="#">Optimal </a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('themes/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalert/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/DataTables/FixedHeader-3.2.4/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('plugins/DataTables/FixedHeader-3.2.4/js/dataTables.fixedHeader.bootstrap5.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('themes/vendor/tinymce/tinymce.min.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('themes/js/main.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script>
        window.alert_toast = function($msg, $bg = 'success') {
            Toast.fire({
                icon: $bg,
                title: $msg
            })
        }
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        window.animate_swal = function(msg) {
            Swal.fire({
                title: msg,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })

        }
        
    </script>
    </div>
    </body>

    </html>