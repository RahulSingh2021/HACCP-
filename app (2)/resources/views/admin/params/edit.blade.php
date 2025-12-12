@extends('layouts.app', ['pagetitle'=>'Training Calendar Management'])


<style>
    .select2-container {
    display: block !important;
    z-index: 0 !important; 
}

.buttonabsent {
    border: 0px;
 padding: 9px 25px;
    background: #DD1144 ;
    color: #fff;
    cursor: pointer;
       border-radius: 50px !important;
}

.buttonpresent {
    border: 0px;
   padding: 9px 25px;
    background: #000;
    color: #fff;
    cursor: pointer;
       border-radius: 50px !important;
}

a.print {
    border: 1px solid #ddd;
    padding: 10px 43px;
    font-size: 16px;
    text-align: right;
    float: right;
    margin-top: 20px;
}

</style>
@section('content')
<div class="content-body">
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <div class="flex-grow-1">
            <ol class="breadcrumb df-breadcrumbs mg-b-10">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Food Safety Category
</li>
            </ol>
            <h4 class="pagetitle">Create Food Safety Category
</h4>
        </div>
        <div class="mg-l-auto">
            <div class="text-right">
                
              
                <a class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5" title="Back" href="{{ route('prodparams') }}">Back</a>
              
            </div>
        </div>
    </div>
    
              
  

    <div class=" pd-x-0">
        <div class="row row-xs">
            <!--<div class="col-sm-12 col-lg-12">-->
            <!--    <div class="alert alert-success" style="display: none;" role="alert" id="success-alert"></div>-->
            <!--</div>-->
        </div>
        <div class="row row-xs">
            <div class="col-sm-12 col-lg-12 mg-t-20">
                <div data-label="" class="df-example demo-forms">
                    
         <?php 
         
                 $id = $_GET['id'];
                
                   $details = DB::table('prodparams')->where('id',$id)->First();
                   
     ?>
                    <form  action="{{route('prodparams_add')}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        
                        
                        <input type="hidden" name="prodparams_id" value="<?php echo $_GET['id']; ?>">
                
                        <div class="row row-sm">
                            
                           
                         <div class="col-sm-4 mg-t-10">
                                    <label>Parent Product Category <span class="text-danger">*</span></label>
              <select class="form-control" name="parentcat" id="disparentcat" required="required">
                <option value="">Select category</option>
                <?php
                foreach ($parcatlist as $cat) {?>
                  <option <?php if($details->parentcats_id==$cat->id){echo "selected";} ?> value="{{$cat->id}}">{{$cat->cat_name}}</option>;
                <?php }
                ?>
              </select>
                            </div>
                         
                           
                    
                            
                             <div class="col-sm-4 mg-t-10">
           <label>Product <span class="text-danger">*</span></label>
              <select class="form-control" name="regproducts_id" id="regproducts_id" required="required">
                <option value="0">Product</option>
                <?php
                foreach ($prolist as $key=>$cat) {?>
                    
                <option <?php if($details->regproducts_id==$key){echo "selected";} ?> value="{{$key}}" class="allSubCats Sub_{{$cat['parent']}}">{{$cat['prod_name']}}</option>
                <?php }
                ?>
              </select>
                            </div> 

        

             <div class="col-sm-4 mg-t-10">
            <label>Category <span class="text-danger">*</span></label>
              <select class="form-control" name="paramcats_id" id="paramcats_id" required="required">
                <option value="0">Category</option>
                <?php
                foreach ($catlist as $key=>$cat) {?>
                
                               

                  <option value="{{$cat->id}}" <?php if($details->paramcats_id==$cat->id){echo "selected";} ?>  class="allSubCats Sub_{{$cat->parentcategory}}">{{$cat->cat_name}}</option>
               <?php  }
                ?>
              </select>
                            </div> 

      


    <div class="col-sm-12 mg-t-10">
              <label>Parameter Description</label>
              <textarea class="form-control" name="perm_desc" id="perm_desc" >{{$details->perm_desc}}</textarea>
            </div>
                <button type="submit"  class="btn btn-success" value="create">Save Food Safety Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
 
</div>


            <script src="https://nightly.ckeditor.com/latest/full/ckeditor/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'perm_desc', {
	extraPlugins: 'colorbutton,font',
	on: {
		afterPasteFromWord: function( evt ) {
			// Clone the filter, so that it's based on current editor filter settings.
			// Note that this function is added in CKE 4.7.3.
			var filter = evt.editor.filter.clone(),
				fragment = CKEDITOR.htmlParser.fragment.fromHtml( evt.data.dataValue ),
				writer = new CKEDITOR.htmlParser.basicWriter();

			// Disallow certain styles.
			filter.disallow( 'span{font-family,color}' );

			// Process, and overwrite evt.data.dataValue.
			filter.applyTo( fragment );
			fragment.writeHtml( writer );
			evt.data.dataValue = writer.getHtml();
		}
	}
} );
                </script>



<!--<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>-->

<!--<script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>-->

<!--  <script>-->
<!--                        CKEDITOR.replace( 'perm_desc' );-->
<!--                </script>-->

@endsection
@section('footerscript')
@endsection