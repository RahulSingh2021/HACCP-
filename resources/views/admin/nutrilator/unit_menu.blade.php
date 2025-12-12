
<div class="row">
                         <div class="col">
                            <div class="card">
                                <div class="card-body">                              
                                    <ul class="nav nav-pills nav-pills-success mb-3" role="tablist">
                                  
                                        
                         
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
										 @include('admin.nutrilator.Ingredients')  
                                       @include('admin.nutrilator.Recipe.recipe')  
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>



