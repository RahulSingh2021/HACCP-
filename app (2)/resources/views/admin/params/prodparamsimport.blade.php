@extends('layouts.app', ['pagetitle'=>'Regulation Product Parameter Management'])
@section('content')
<div class="content-body">
  <div class="d-sm-flex align-items-center justify-content-between mb-3">
    <div class="flex-grow-1">
      <ol class="breadcrumb df-breadcrumbs mg-b-10">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"> Regulation Parameter Category</li>
      </ol>
      <h4 class="pagetitle">Regulation Parameter Category</h4>
    </div>
    <div class="mg-l-auto">
      <div class="col-3 text-right">
        <a class="text-primary" href="{{asset('public/importparameter.csv')}}" target="_new"><i title="Download Template" class="fas fa-file-excel fa-3x"></i></a>
      </div>
    </div>
  </div>
  <div class=" pd-x-0">

    <!-- <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30 row">
      <div class="col-sm-12 col-lg-12">
        <div class="row">
          <div class="col-9">
            <a href="{{route('home')}}">Dashboard</a> / <a href="{{route('prodparams')}}">Regulation Product Parameter</a> / Import Regulation Product Parameter
          </div>

          <div class="col-3 text-right">
            <a class="text-primary" href="{{asset('public/importparameter.csv')}}" target="_new">Download Template <i class="fa fa-file-excel"></i></a>
          </div>
          
        </div>
      </div>
    </div> -->

    @if(session()->has('message'))
      <div class="row row-xs">
        <div class="col-sm-12 col-lg-12">
          <div class="alert alert-success" role="alert">{{ session()->get('message') }}</div>
        </div>
      </div>
    @endif

      <form id="importData" name="importData" class="form-horizontal" enctype="multipart/form-data" method="post">
        @csrf

          <div class="row row-sm">
            <div class="col-sm-6">
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
            
            <div class="col-sm-6">
              <label>Product <span class="text-danger">*</span></label>
              <select class="form-control" name="regproducts_id" id="regproducts_id">
                <option value="0">Product</option>
                <?php
                foreach ($prolist as $key=>$cat) {
                  echo '<option value="'.$key.'" class="allSubCats Sub_'.$cat['parent'].'">'.$cat['prod_name'].'</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-sm-6">
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

            <div class="col-sm-6" >
              <label>Document Upload <span class="text-danger">*</span></label>
              <input type="file" class="form-control" required="required" accept="csv,.csv" name="uploaddoc" id="uploaddoc" oninvalid="this.setCustomValidity('Please Browse for document to upload')" oninput="setCustomValidity('')">
            </div>
            <input type="hidden" class="form-control" name="action" id="action" value="import">
            <div class="col-sm-12 pt-2">
              <button type="submit" class="btn btn-success" id="btn-save" value="create">Import Regulation Product Parameter</button>
              <button type="reset" class="btn btn-info">Cancel</button>
          </div>
          </div>
          
      </form>



  </div>
</div>

@endsection
