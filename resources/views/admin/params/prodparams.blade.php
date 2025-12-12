@extends('layouts.app', ['pagetitle'=>'Regulation Product Parameter Management'])
@section('content')

<style>
    .modal-dialog {
    max-width: 840px;
    margin: 1.75rem auto;
}

td.perm_desc_div {
    max-width: 645px;
}
</style>
<div class="content-body">
  <div class="d-sm-flex align-items-center justify-content-between mb-3">
    <div class="flex-grow-1">
      <ol class="breadcrumb df-breadcrumbs mg-b-10">
            <li class="breadcrumb-item active"> Regulation Product Parameter</li>
      </ol>
      <h4 class="pagetitle">Regulation Parameter Category</h4>
    </div>
    <div class="mg-l-auto">
      <div class="text-right">

        <a class="btn btn-success btn-xs" href="{{route('prodparamsimport')}}">Import Regulation Product Parameter</a>

        <!--<a class="btn btn-primary btn-xs" title="Add Inspection" href="javascript:void(0);" id="btnaddinspection">Add Regulation Product Parameter</a>-->
        <a class="btn btn-primary btn-xs" title="Add Inspection" href="{{route('add_prodparams')}}">Add Regulation Product Parameter</a>
      </div>
    </div>
  </div>
  <div class=" pd-x-0">




<div class="row row-xs">
  <div class="col-sm-12 col-lg-12">
    <div class="alert alert-success" style="display: none;" role="alert" id="success-alert"></div>
  </div>
</div>
    <form name="deldata" class="form-horizontal" method="post" action="{{route('prodparamsdelete')}}">
      @csrf
    <div class="row row-xs">
      <div class="col-sm-12 col-lg-12">
          
          <div class="table-responsive Hscrolldesign">
                                        <div class="employeeData">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tbody>
                                                    <tr>
                                                        <th class="headcol" style="width: 90px;">
                                                            <table border="0" cellpadding="0" cellspacing="0" class="employdetail" style="width: 90px;">
                                                                <tbody>
                                                                    <tr style="width: 90px;">
                                                                        <th style="width: 16.66%"><strong>Sr No.</strong></th>
                                                                        <th style="width: 16.66%"><strong>PRODUCT</strong></th>
                                                                    </tr>
                                                                    @php $i=1; @endphp
                                                                     @foreach($parcatlist as $parcatlists)
                                                                <tr>                                                                                                                                  <tr>
                                                                <td style="width: 90px;">
                                                                <strong>{{$i}}.</strong> 
                                                                </td>
                                                                <td style="width: 90px;">
                                                                <strong class="empName">{{$parcatlists->cat_name ?? ''}}</strong>
                                                                
                                                                </td>
                                                                </tr>
                                                                @php $i++; @endphp
                                                                @endforeach
                                                                
                                                                 </tbody>                                                                                                                                           <tr>
                                                      
                                                                                                                                                                                                        </tbody>
                                                            </table>
                                                        </th>
                                                        <td>
                                                            <table border="0" cellpadding="0" cellspacing="0" class="monthwise">
                                                                <tbody>
                                                                    <tr>
                                                                        
                                                                        @foreach($catlist as $catlists)
                                                                        <th><strong>{{$catlists->cat_name ?? ''}}</strong></th>
                                                                        @endforeach
                                                                       


                                                                    </tr>
                                                                                                                                        <tr>
                                                                        <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                  <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                          <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                           <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                        <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>

                                                                          <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>
                                                                              <td>
                                                                            <span class="traininghrsbg" title="Training Hrs">12:05:25</span>
                                                                        
                                                                        </td>
                                                                    </tr>
                                            
                                         
                                              
                                                          
                                           
                                                  
                                                                                                                                        
                                                                </tbody>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

               <div class="col-sm-12 col-lg-12 mg-b-20">
          <button type="submit" id="delbutton" class="btn btn-danger btn-xs" value="delete">Delete Selected</button>
        </div>
         </div>
  
      </div>
    </form>
  </div>
</div>
<div id="createForm" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="prodparamsCrudModal">Create Regulation Product Parameter</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="prodparamsForm" name="prodparamsForm" class="form-horizontal">
        <div class="modal-body">


          <div class="row row-sm">
            <div class="col-sm-12">
              <label>Parent Product Category <span class="text-danger">*</span></label>
              <select class="form-control" name="parentcat" id="disparentcat" required="required">
                <option value="">Select category</option>
                <?php
                foreach ($parcatlist as $cat) {
                  echo '<option value="'.$cat->id.'">'.$cat->cat_name.'</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <div class="row row-sm">
            
            <div class="col-sm-12">
              <label>Product <span class="text-danger">*</span></label>
              <select class="form-control" name="regproducts_id" id="regproducts_id" required="required">
                <option value="0">Product</option>
                <?php
                foreach ($prolist as $key=>$cat) {
                  echo '<option value="'.$key.'" class="allSubCats Sub_'.$cat['parent'].'">'.$cat['prod_name'].'</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-sm-12">
              <label>Category <span class="text-danger">*</span></label>
              <select class="form-control" name="paramcats_id" id="paramcats_id" required="required">
                <option value="0">Category</option>
                <?php
                foreach ($catlist as $key=>$cat) {
                  echo '<option value="'.$cat->id.'" class="allSubCats Sub_'.$cat->parentcategory.'">'.$cat->cat_name.'</option>';
                }
                ?>
              </select>
            </div>
            <!--<div class="col-sm-12 mg-t-10">-->
            <!--  <label>Parameter</label>-->
            <!--  <input type="text" class="form-control" name="parameter" id="parameter"  oninvalid="this.setCustomValidity('Please Enter Parameter')" oninput="setCustomValidity('')">-->
            <!--</div>-->
            <!--<div class="col-sm-12 mg-t-10">-->
            <!--  <label>Parameter Limit</label>-->
            <!--  <input type="text" class="form-control" name="perm_limit" id="perm_limit"  oninvalid="this.setCustomValidity('Please Enter Parameter Limit')" oninput="setCustomValidity('')">-->
            <!--</div>-->

            <div class="col-sm-12 mg-t-10">
              <label>Parameter Description</label>
              <textarea class="form-control" oninvalid="this.setCustomValidity('Please Enter Parameter Description')" oninput="setCustomValidity('')" name="perm_desc" id="perm_desc" ></textarea>
            </div>

            <input type="hidden" class="form-control" name="prodparams_id" id="prodparams_id" value="">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="createProdparam" class="btn btn-success" id="btn-save" value="create">Save Regulation Product Parameter</button>
          <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footerscript')



<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>

  <script>
                        CKEDITOR.replace( 'perm_desc' );
                </script>
@endsection
