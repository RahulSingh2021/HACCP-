<script src="{{asset('student_dashboard/assets/js/jquery-3.6.0.min.js?dsfdf')}}"></script>
<script src="{{asset('student_dashboard/assets/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('student_dashboard/assets/js/app.js')}}"></script>
<script src="{{asset('student_dashboard/assets/js/slick.js?fsdfsd')}}"></script>
<script type="text/javascript">
    $(".togglebtn").click(function() {
        $(".menuSidebar").toggleClass("sidebaropen");
        $("body").toggleClass("open");
    });

    $(".toggleclosebtn").click(function() {
        $(".menuSidebar").toggleClass("sidebaropen");
        $("body").toggleClass("open");
    });
</script>
<script type="text/javascript">
    $('.latestfeed').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1
    });
</script>
<script>
    $(document).ready(function() {
        $(".sidebarbtn").click(function() {
            $(".profilesidebar").toggleClass("sidebaropen");
        });

        $(".sidebarbtnclose").click(function() {
            $(".profilesidebar").toggleClass("sidebaropen");
        });
    });
</script>
