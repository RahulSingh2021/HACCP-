 <script src="{{asset('admin/course_manage/js/jquery-3.6.0.min.js?dsfdf')}}"></script>
 <script src="{{asset('admin/course_manage/js/bootstrap.bundle.js')}}"></script>
 <script src="{{asset('admin/course_manage/js/scrolltab.js')}}"></script>
 <script src="{{asset('admin/course_manage/js/toastr.min.js')}}"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.min.js"></script>
 <script type="text/javascript">
     jQuery(".select2-multiple").select2({
         theme: "bootstrap",
         placeholder: "Select a State",
         containerCssClass: ':all:'
     });
 </script>
 <script type="text/javascript">
     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
     var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
         return new bootstrap.Tooltip(tooltipTriggerEl)
     })
 </script>
 <script type="text/javascript">
     $('#multiple-select-field').select2({
         theme: "bootstrap-5",
         width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
         placeholder: $(this).data('placeholder'),
         closeOnSelect: false,
     });
 </script>

 <script>
     function showDiv() {
         document.getElementById('hiddenDiv').style.display = 'flex';
     }

     function hideDiv() {
         document.getElementById('hiddenDiv').style.display = 'none';
     }
 </script>
  <script>
    @if(Session::has('message'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif
  </script>
 </body>

 </html>
