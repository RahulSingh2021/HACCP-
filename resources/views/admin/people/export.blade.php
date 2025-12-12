

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<h3>daterangepicker - get date example</h3>
<input type="text" name="datetimes" />
<p id="startDate">Start Date:</p>
<p id="endDate">End Date:</p>



<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script>
    $(document).ready(function () {
  $("input[name='datetimes']").daterangepicker(
    {},
    function (start, end, label) {
      let startDate = start.format("YYYY-MM-DD").toString();
      let endDate = end.format("YYYY-MM-DD").toString();

      document.getElementById("startDate").innerHTML =
        "Start date: " + startDate;
      document.getElementById("endDate").innerHTML = "End date: " + endDate;
      
    }
  );
});

</script>