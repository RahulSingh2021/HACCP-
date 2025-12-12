
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">                              
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                       
                                                         <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 1) active @else  @endif" data-bs-toggle="pill" href="#Measurement-Unit" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Measurement Unit</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 2) active @else  @endif" data-bs-toggle="pill" href="#Add-Serving-Area-Name" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Serving Area Name</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 3) active @else  @endif" data-bs-toggle="pill" href="#Data-Refrence-Name" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Data Refrence Name</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 4) active @else  @endif" data-bs-toggle="pill" href="#Product-Symbol" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Product Symbol</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 5) active @else  @endif" data-bs-toggle="pill" href="#Allergen-Datails" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Allergen Datails</div>
                                                </div>
                                            </a>
                                        </li>
                       
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 6) active @endif" data-bs-toggle="pill"  href="#Ingredients" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Ingredients</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link @if($_GET['tab_name'] == 7) active @endif" data-bs-toggle="pill" href="#Add-Recipe" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Recipe</div>
                                                </div>
                                            </a>
                                        </li>
                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade @if($_GET['tab_name'] == 1) active show @else  @endif" id="Measurement-Unit" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col-2 d-flex align-self-end justify-content-start">
													
													      <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addmeasurementunit">+ Add New</button>
													
													</div>
                                            </div>     
                     @include('admin.popups.nutrilator.measurementunitlist') 
                                       </div>

                                       <div class="tab-pane fade @if($_GET['tab_name'] == 2) active show @else  @endif" id="Add-Serving-Area-Name" role="tabpanel">
                                        <div class="row row-cols-auto g-3">
                                            <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addservingarea">+ Add New</button></div>
                                        </div>     
                                 @include('admin.popups.nutrilator.servingarealist') 
                                       </div>
                                       <div class="tab-pane fade @if($_GET['tab_name'] == 3) active show @else  @endif" id="Data-Refrence-Name" role="tabpanel">
                                        <div class="row row-cols-auto g-3">
                                            <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#DataRefrenceName">+ Add New</button></div>
                                        </div>     
                      @include('admin.popups.nutrilator.datarefrencelist') 
										   
										   
                                       </div>
                                       <div class="tab-pane fade @if($_GET['tab_name']  == 4) active show @else  @endif" id="Product-Symbol" role="tabpanel">
                                    <div class="row row-cols-auto g-3">
                                        <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#DataRefrenceName1">+ Add New</button></div>
                                    </div>     
                                   @include('admin.popups.nutrilator.productsybbulelist') 
                                       </div>
                                       <div class="tab-pane fade @if($_GET['tab_name'] == 5) active show @else  @endif" id="Allergen-Datails" role="tabpanel">
                                <div class="row row-cols-auto g-3">
                                    <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#DataRefrenceName2">+ Add New</button></div>
                                </div>     
                            @include('admin.popups.nutrilator.allergenlist')  
                                        </div>
                                      
										 @include('admin.nutrilator.Ingredients')  
             
                                       @include('admin.nutrilator.Recipe.recipe')  
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>



