<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('admin/create_template/custom.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".add-page-fst").click(function () {
            $(".title-page-fst").toggle();
        });
    });

    $(document).ready(function () {
        $(".add-page-secnd").click(function () {
            $(".title-page-secnd").toggle();
        });
    });

    $(document).ready(function () {
        $(".first-row").click(function () {
            $(".show-hide-box").toggle();
        });
    });

    $(document).ready(function () {
        $(".add-first-row").click(function () {
            $(".add-show-hide-box").toggle();
        });
    });

    $(document).ready(function () {
        $("button.bulk-page-mdl").click(function () {
            $("body").toggleClass("bulk-show");
        });
    });

    $(document).ready(function () {
        $(".batn-full-size").click(function () {
            $(".togl-btn-prev").toggle();
        });
    });
    $(document).ready(function () {
        $(".pre-page-next").click(function () {
            $(".popup-show-height").toggleClass("show-next");
        });
    });
</script>
</body>
</html>