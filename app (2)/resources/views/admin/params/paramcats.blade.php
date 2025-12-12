@extends('layouts.app', ['pagetitle'=>'Filter Parameter Category'])
@section('content')
<div class="content-body">
  <div class="d-sm-flex align-items-center justify-content-between mb-3">
    <div class="flex-grow-1">
      <ol class="breadcrumb df-breadcrumbs mg-b-10">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"> Filter Parameter Category</li>
      </ol>
      <h4 class="pagetitle">Parameter Category</h4>
    </div>
    <div class="mg-l-auto">
      <div class="text-right">
        <a class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" title="Add Inspection" href="javascript:void(0);" id="btnaddinspection">Add Filter Parameter Category</a>
      </div>
    </div>
  </div>
  <div class=" pd-x-0">
<div class="row row-xs">
  <div class="col-sm-12 col-lg-12">
    <div class="alert alert-success" style="display: none;" role="alert" id="success-alert"></div>
  </div>
</div>
    <form name="deldata" class="form-horizontal" method="post" action="{{route('paramcatsdelete')}}">
      @csrf
    <div class="row row-xs">
      <div class="col-sm-12 col-lg-12">
        <table class="table" id="paramcatsList" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>#</th>
                <th>
                  <input type="checkbox" class="checked_all" name="checkall" value="checkall"/>
                </th>
              <th>Category Name</th>
              <th>Parent Category</th>
              <th>Added By</th>
              <th>Added On</th>
              <th>Action</th> 
            </tr>
          </thead>
        </table>
        </div>
        <div class="col-sm-12 col-lg-12 mg-b-20">
          <button type="submit" id="delbutton" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div id="createForm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="paramcatsCrudModal">Create Filter Parameter Category</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="paramcatsForm" name="paramcatsForm" class="form-horizontal">
        <div class="modal-body">
          <div class="row row-sm">
            <input type="hidden" class="form-control" name="paramcats_id" id="paramcats_id" value="">

            <div class="col-sm-12">
              <label>Parent Category <span class="text-danger">*</span></label>
              <select class="form-control" name="parentcategory" id="regulationcats_parent_id" required="required">
                <option value="0">Parent Category</option>
                <?php
                foreach ($catlist as $cat) {
                  echo '<option value="'.$cat->id.'">'.$cat->cat_name.'</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-sm-12 mg-t-10">
              <label>Category Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" required="required" name="paramcats_cat_name" id="paramcats_cat_name"  oninvalid="this.setCustomValidity('Please Enter Product Category Name')" oninput="setCustomValidity('')">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="createParamcats" class="btn btn-success" id="btn-save" value="create">Save Filter Parameter Category</button>
          <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footerscript')
<script>
$(document).ready(function() {
  var SITEURL = $('base').attr('href');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#paramcatsList').DataTable({
    pageLength: 10,
    processing: true,
    serverSide: true,
    ajax: {
      url: SITEURL + "paramcats",
      type: 'GET',
    },
    language: {
      'loadingRecords': '&nbsp;',
      'processing': '<div class="spinner"></div>',
      searchPlaceholder: 'Search...',
      sSearch: '',
      lengthMenu: '_MENU_ Categories/Page',
    },
    columns: [
    {data: 'id', name: 'id', visible:false},
    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false , sClass: "text-center"},

    {data: 'deldata',
    render: function(data, type, row, meta){
      return '<input type="checkbox" name="deldata[]" value="'+row.id+'" class="cb-element" />';
    },
    name: 'deldata', orderable: false,searchable: false},

    {data: 'cat_name', name: 'cat_name' },

    {data: 'parent_cat_name', 
    render: function(data, type, row, meta){
      if(data){
        data = data;
      }else{
        data = '-';
      }
      return data;
    },
    name: 'regulationcats.cat_name' },

    {data: 'cname', name: 'users.first_name' },
    {data: 'created_at', 
    render: function(data, type, row, meta){
      if(data && data!='0000-00-00 00:00:00'){
        data = formatDate(data);
      } else{
        data = '-';
      }
      return data;
    },
    name: 'created_at', sClass: "text-center" },
    {data: 'action',
    render: function(data, type, row, meta){
      var SITEURL = $('base').attr('href');
      var Status='';
      if(row.is_active==1){
        Status='<a href="javascript:void(0);" data-status="'+row.is_active+'" data-rowid="'+row.id+'" class="changeParamcatStatus" title="Active"><i class="text-success fa fa-circle"></i></a>';
      }else{
        Status='<a href="javascript:void(0);" data-status="'+row.is_active+'" data-rowid="'+row.id+'" class="changeParamcatStatus" title="De-active"><i class="text-danger fa fa-circle"></i></a>';
      }
      var DELHTML='&nbsp;<a href="javascript:void(0);" data-rowid="'+row.id+'" class="deleteParamcat" title="Delete Parameter Category"><i class="text-danger fa fa-trash"></i></a>';
      data = '<a href="javascript:void(0);" title="Edit Food Safety Category" data-rowid="'+row.id+'"  class="editParamcatButton"><i class="text-primary fa fa-edit"></i></a>&nbsp;'+Status+DELHTML;

      return data;
    },
    name: 'action', orderable: false,searchable: false},
    ],
    order: [[0, 'desc']]
  });
  $('body').on('click', '.deleteParamcat', function () {
    var rowID=$(this).data("rowid");
    if (confirm("Are you sure you want to delete this Parameter category?\nThis action can not be reversed!")) {
      $.get(SITEURL + 'paramcats/'+rowID+'/delete', function (data) {
        $("#success-alert").html('Category deleted successfully!!');
        $("#success-alert").fadeTo(500, 2000);
        $("#success-alert").slideDown(1000);
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
          $("#success-alert").slideUp(2000);
        });
        var oTable = $('#paramcatsList').dataTable();
        oTable.fnDraw(false);
      })
    }
  });


  $('#btnaddinspection').click(function () {

    $('#btn-save').val("create-paramcats");
    $('#paramcats_id').val('');
    $('#paramcatsForm').trigger("reset");    
    $('#paramcatsForm .form-control').removeClass("error");
    $('#paramcatsForm label.error').hide();
    
    $("#regulationcats_parent_id").val('').trigger("change");

    $('#iconDoc').hide();  
    $('#downloadLink').html('');

    $("#paramcats_parent_id").val(0).trigger("change");
    $('#paramcatsCrudModal').html("Create Food Safety Category");
    $('#createParamcat').html('Save Food Safety Category');
    $('#createForm').modal('show');
  });
  $('body').on('click', '.editParamcatButton', function () {
    var rowID=$(this).data("rowid");
    $.get(SITEURL + 'paramcats/'+rowID+'/edit', function (data) {
      $('#btn-save').val("create-paramcats");
      $('#paramcatsForm').trigger("reset");    
      $('#paramcats_id').val(data.id);

      $("#regulationcats_parent_id").val(data.parentcategory).trigger("change");


      $('#paramcats_cat_name').val(data.cat_name);
      $('#disp_order').val(data.disp_order);
      if(data.icon_path!=''){
        $('#iconDoc').show();
        $('#iconLink').html('<img src="'+SITEURL+'public/icon_path/'+data.icon_path+'" class="img-fluid" />');
      }

      $('#paramcatsForm .form-control').removeClass("error");
      $('#paramcatsForm label.error').hide();
      $('#paramcatsCrudModal').html("Edit Food Safety Category");
      $('#createParamcat').html('Update Food Safety Category');
      $('#createForm').modal('show');
    })
  });
  $("#paramcatsForm").submit(function(e){
    e.preventDefault()
    var actionType = $('#btn-save').val();
    $('#createParamcat').html('Saving..');


    $.ajax({
      data:new FormData(this),
      url: SITEURL + "paramcats/store",
      type: "POST",
      dataType: 'json',
      contentType:false,
      cache:false,
      processData:false,
      success: function (data) {
        var curredit=$('#paramcats_id').val();
        if(curredit){
          $("#success-alert").html('Category updated successfully!!');
        }else{
          $("#success-alert").html('Category added successfully!!');
        }
        $("#success-alert").fadeTo(500, 2000);
        $("#success-alert").slideDown(1000);
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
          $("#success-alert").slideUp(2000);
        });
        $('#paramcatsForm').trigger("reset");
        $('#createForm').modal('hide');
        $('#createParamcat').html('Save');

        var oTable = $('#paramcatsList').dataTable();
        oTable.fnDraw(false);
      },
      error: function (data) {
        console.log('Error:', data);
        $('#createParamcat').html('Save');
      }
    });
  });

  $('body').on('click', '.changeParamcatStatus', function () {
    var rowID=$(this).data("rowid");
    if (confirm("Are you sure you want to change status of PARAMETER CATEGORY!")) {
      $.get(SITEURL+"paramcats/status/"+rowID, function(data, status){
        $("#success-alert").html('PARAMETER CATEGORY status updated');
        $("#success-alert").fadeTo(500, 2000);
        $("#success-alert").slideDown(1000);
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(2000);
        });
        $('#categoryStatusForm').trigger("reset");
        $('#catStatusChange').modal('hide');
        var oTable = $('#paramcatsList').dataTable();
        oTable.fnDraw(false);
      });
    }
  });

  var formatDate = function(dateString) {
    var datePartsU = dateString.split(" ");
    var dateParts = datePartsU[0].split("-");
    var date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
    return(((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + date.getFullYear());
  };
})
</script>
@endsection
