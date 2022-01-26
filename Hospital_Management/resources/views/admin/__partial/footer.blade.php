</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Basundhara Clinic and digonestic center All Right Reserve, 2021 || Developed by <a
                    href="https://www.facebook.com/SabbirHossain308/" target="_blank">Md Sabbir Hossain</a></span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
{{--{{ asset('template/') }}--}}
<!-- Bootstrap core JavaScript-->

<script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
{{--<script src="{{ asset('template/js/demo/chart-area-demo.js') }}"></script>--}}
{{--<script src="{{ asset('template/js/demo/chart-pie-demo.js') }}"></script>--}}

@yield("cartScript")
{{--<script>--}}
{{--    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';--}}
{{--    Chart.defaults.global.defaultFontColor = '#858796';--}}

{{--    // Pie Chart Example--}}
{{--    var ctx = document.getElementById("myPieChart");--}}
{{--    var myPieChart = new Chart(ctx, {--}}
{{--        type: 'doughnut',--}}
{{--        data: {--}}
{{--            labels: ["Direct", "Referral", "Social"],--}}
{{--            datasets: [{--}}
{{--                data: [45, 30, 25],--}}
{{--                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],--}}
{{--                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],--}}
{{--                hoverBorderColor: "rgba(234, 236, 244, 1)",--}}
{{--            }],--}}
{{--        },--}}
{{--        options: {--}}
{{--            maintainAspectRatio: false,--}}
{{--            tooltips: {--}}
{{--                backgroundColor: "rgb(255,255,255)",--}}
{{--                bodyFontColor: "#858796",--}}
{{--                borderColor: '#dddfeb',--}}
{{--                borderWidth: 1,--}}
{{--                xPadding: 15,--}}
{{--                yPadding: 15,--}}
{{--                displayColors: false,--}}
{{--                caretPadding: 10,--}}
{{--            },--}}
{{--            legend: {--}}
{{--                display: false--}}
{{--            },--}}
{{--            cutoutPercentage: 80,--}}
{{--        },--}}
{{--    });--}}
{{--</script>--}}

<!-- Page level plugins -->
<script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>


</body>

</html>
