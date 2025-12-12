@extends('layouts.app', ['pagetitle'=>'Dashboard'])


<style type="text/css">
    .error {
    color: red;
    margin: 10px 0px;
}
</style>
@section('content')
@include('admin.popups.nutrilator.addmeasurementunit')
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">                              
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-bs-toggle="pill" href="#Measurement-Unit" role="tab" aria-selected="true">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Measurement Unit</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Add-Serving-Area-Name" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Serving Area Name</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Data-Refrence-Name" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Data Refrence Name</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Product-Symbol" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Product Symbol</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Allergen-Datails" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Allergen Datails</div>
                                                </div>
                                            </a>
                                        </li>
                                        
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Ingredients" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Ingredients</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-bs-toggle="pill" href="#Add-Recipe" role="tab" aria-selected="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="tab-title">Add Recipe</div>
                                                </div>
                                            </a>
                                        </li>
                        
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="Measurement-Unit" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col-2 d-flex align-self-end justify-content-start">
													
													      <button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addmeasurementunit">+ Add New</button>
													
													</div>
                                            </div>     
                     @include('admin.popups.nutrilator.measurementunitlist') 
                                       </div>
                                       <div class="tab-pane fade" id="Add-Serving-Area-Name" role="tabpanel">
                                        <div class="row row-cols-auto g-3">
                                            <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewData-Refrence-Name">+ Add New</button></div>
                                        </div>     
                                        <table class="table table-bordered table-striped mt-4">
                                            <thead>
                                              <tr>                             
                                                <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                <th width="30">No.</th>
                                                <th>Add Serving Area Name</th>
                                                <th width="80">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              
                                            </tbody>
                                          </table>  
                                       </div>
                                       <div class="tab-pane fade" id="Data-Refrence-Name" role="tabpanel">
                                        <div class="row row-cols-auto g-3">
                                            <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewData-Refrence-Name">+ Add New</button></div>
                                        </div>     
                                        <table class="table table-bordered table-striped mt-4">
                                            <thead>
                                              <tr>                             
                                                <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                <th width="30">No.</th>
                                                <th>Data Refrence Name</th>
                                                <th width="80">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              <tr>
                                                <td><input class="form-check-input" type="checkbox" value=""></td>
                                                <td>---</td>
                                                <td>---</td>
                                                <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                              </tr>
                                              
                                            </tbody>
                                          </table>  
                                       </div>
                                       <div class="tab-pane fade" id="Product-Symbol" role="tabpanel">
                                    <div class="row row-cols-auto g-3">
                                        <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewProduct-Symbol">+ Add New</button></div>
                                    </div>     
                                    <table class="table table-bordered table-striped mt-4">
                                        <thead>
                                          <tr>                             
                                            <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                            <th width="30">No.</th>
                                            <th>Name</th>
                                            <th>Symbol</th>
                                            <th width="80">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td><input class="form-check-input" type="checkbox" value=""></td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                          </tr>
                                          <tr>
                                            <td><input class="form-check-input" type="checkbox" value=""></td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                          </tr>
                                          <tr>
                                            <td><input class="form-check-input" type="checkbox" value=""></td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                          </tr>
                                          
                                        </tbody>
                                      </table>  
                                       </div>
                                       <div class="tab-pane fade" id="Allergen-Datails" role="tabpanel">
                                <div class="row row-cols-auto g-3">
                                    <div class="col-2 d-flex align-self-end justify-content-start"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewAllergen-Datails">+ Add New</button></div>
                                </div>     
                                <table class="table table-bordered table-striped mt-4">
                                    <thead>
                                      <tr>                             
                                        <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                        <th width="30">No.</th>
                                        <th>Allergen Ingredients Name</th>
                                        <th>Symbol</th>
                                        <th width="80">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                      </tr>
                                      <tr>
                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                      </tr>
                                      <tr>
                                        <td><input class="form-check-input" type="checkbox" value=""></td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td><i class="font-20 bx bxs-pencil me-2"></i><i class="font-20 bx bxs-trash"></i></td>
                                      </tr>
                                      
                                    </tbody>
                                  </table> 
                                        </div>
                                       
                                        <div class="tab-pane fade" id="Ingredients" role="tabpanel">
                                            <div class="row row-cols-auto g-3">
                                                <div class="col-4">Food Name
                                                    <input type="search" class="form-control" placeholder="Search Food Name">
                                                </div>
                                                
                                                <div class="col-md-3">From: <input type="date" class="form-control"></div>
                                                        <div class="col-md-3">To: <input type="date" class="form-control"></div>
                                                <div class="col-2 d-flex align-self-end justify-content-end"><button type="button" class="btn btn-outline-dark px-3" data-bs-toggle="modal" data-bs-target="#addnewingredient">+ Add New</button></div>
                                            </div>     
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>                             
                                                    <td width="30"><input class="form-check-input" type="checkbox" value=""></td>
                                                    <th width="30">No.</th>
                                                    <th>Ingredients Symbol</th>
                                                    <th>Ingredients Name</th>
                                                    <th>Ingredients Specification</th>
                                                    <th>Refrence</th>
                                                    <th>Allergen</th>
                                                    <th>Energy (K Cal)</th>
                                                    <th>Protein (gm)</th>
                                                    <th>Carbohydrates(gm)</th>
                                                    <th>Fat (gm)</th>
                                                    <th>Created on</th>
                                                    <th width="50">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>1</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td><i class="font-20 bx bxs-trash"></i></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>1</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td><i class="font-20 bx bxs-trash"></i></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>1</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td><i class="font-20 bx bxs-trash"></i></td>
                                                  </tr>
                                                  
                                                </tbody>
                                              </table>  
                                       </div>
                                        <div class="tab-pane fade" id="Add-Recipe" role="tabpanel">
                                            <div class="row row-cols-auto g-3 mb-3">
                                                <div class="col d-flex align-items-center"> Create Recipe </div>
                                                <div class="col">
                                                    <input type="search" class="form-control" placeholder="Enter new recipe name then click create">
                                                </div>
                                                <div class="col">
                                                    <a href="edit-recipe.html" type="button" class="btn btn-outline-dark px-3">+ Create</a>
                                                </div>
                                                <div class="col d-flex align-items-center"> </div>
                                                <div class="col">
                                                    <input type="search" class="form-control" placeholder="Enter keyword">
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-dark px-3">Search</button>
                                                </div>
                                            </div> 
                                            <div class="row row-cols-auto g-3">
                                                <div class="col d-flex align-items-center"> Recipe </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Select Option</option>
                                                        <option value="1">Serve per portion </option>
                                                        <option value="2">Serve per 100gm</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Outlate All</option>
                                                        <option value="1"></option>
                                                        <option value="2"></option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Select any one </option>
                                                        <option value="1">Select by Recipe</option>
                                                        <option value="2">Select by Creation Date</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Nutrion Table Filter</option>
                                                        <option value="1"></option>
                                                        <option value="2"></option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected="">Select Export</option>
                                                        <option value="1">PDF</option>
                                                        <option value="2">Excel</option>
                                                        <option value="2">Buffet Tag</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <a href="pdf/pdf-1 - Copy.html" type="button" class="btn btn-outline-dark px-3">Export</a>
                                                </div>
                                            </div> 
                                            <table class="table table-bordered table-striped mt-4">
                                                <thead>
                                                  <tr>
                                                    <th width="30"><input class="form-check-input" type="checkbox" value=""></th>
                                                    <th width="30">No.</th>
                                                    <th>Created On</th>
                                                    <th>Product Nature</th>
                                                    <th>Per Portion</th>
                                                    <th>Product Name</th>
                                                    <th>Ingredients Details</th>
                                                    <th>Allergen Ingredients</th>
                                                    <th>Energy (kcal)</th>
                                                    <th>Protien (g)</th>
                                                    <th>Carb (g)</th>
                                                    <th>Fat (g)</th>
                                                    <th width="30">Action</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <tr>
                                                    <td><input class="form-check-input" type="checkbox" value=""></td>
                                                    <td>1</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                    <td>
                                                        <div class="dropdown">
<i class="font-20 bx bx-menu" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>                                                          
                                                          
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                              <li><a class="dropdown-item" href="edit-recipe.html">Edit</a></li>
                                                              <li><a class="dropdown-item" href="#">Delete</a></li>
                                                              <li><a class="dropdown-item" href="pdf/pdf-1.html">Export</a></li>
                                                              <li><a class="dropdown-item" href="#">Duplicate Icon</a></li>
                                                              <li><a class="dropdown-item" href="#">Generate</a></li>
                                                              <li><a class="dropdown-item" href="#">Buffet Tag</a></li>
                                                            </ul>
                                                          </div>
                                                    </td>
                                                  </tr>
                                                  
                                                  
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
@endsection

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>