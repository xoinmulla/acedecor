<?php
include('session.php');
include('productNavigation.php');
require_once("../DB Operations/productsOps.php");
require_once("../DB Operations/product_categoryOps.php");
require_once("../DB Operations/product_subcategoryOps.php");
require_once("../DB Operations/productDefinitionOps.php");
require_once("../Model/item_detailsmodel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Products Definition</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#productDefinitionModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="productDefinition_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>Product Definition Id</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th style='display:none' >RotationId</th>
                        <th>Rotation</th>
                        <th>Override</th>
                        <th style='display:none' >TypeId</th>
                        <th>Type </th>
                        <th style='display:none' >FinishId</th>
                        <th>Finish</th>
                        <th style='display:none' >Prod_CategoryId</th>
                        <th>Prod_Category</th>
                        <th style='display:none' >Prod_SubCategoryId</th>
                        <th>Prod_SubCategory</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $productDefinitionlist = DBProductDefinition::getallproductdefinition();
                    foreach ($productDefinitionlist as $productDefinition) {
                        echo "<tr><td style='display:none'>" . $productDefinition->getProdDefinition_Id() . "</td>
                        <td>" . $productDefinition->getProd_Name() . "</td>
                        <td>" . $productDefinition->getProd_Description() . "</td>
                        <td style='display:none'>" . $productDefinition->getRotation() . "</td>
                        <td>" . $productDefinition->getRotationSide() . "</td>
                        <td>" . $productDefinition->getOverride() . "</td>
                        <td style='display:none'>" . $productDefinition->getType() . "</td>
                        <td>" . $productDefinition->getCabinetType() . "</td>
                        <td style='display:none'>" . $productDefinition->getFinish() . "</td>
                        <td>" . $productDefinition->getFinishtype() . "</td>
                        <td style='display:none'>" . $productDefinition->getProd_Category() . "</td>
                        <td>" . $productDefinition->getProd_CategoryName() . "</td>
                        <td style='display:none'>" . $productDefinition->getProd_SubCategory() . "</td>
                        <td>" . $productDefinition->getProd_SubCategoryName() . "</td>
                        <td>  <div class='dropdown'>
                        <button class='btn btn-secondary dropdown-toggle' 
                        type='button' 
                        id='dropdownMenu2' 
                        data-toggle='dropdown' 
                       
                        aria-expanded='false'>
                        Actions
                        </button>
                        <div class='dropdown-menu' 
                        aria-labelledby='dropdownMenu2'>
                            <button class='btn btn-primary dropdown-item'
                            data-toggle='modal' 
                            data-target='#prodDefinitionModal' id='proddefinitioninfo'
                            role='button' data-id='" . $productDefinition->getProdDefinition_Id() . "'> 
                            <i class='fas fa-info-circle'></i>
                               Info
                            </button>
                            <button class='btn btn-primary dropdown-item'
                            data-toggle='modal' 
                            data-target='#editprodDefinitionModal' 
                            role='button' data-id='" . $productDefinition->getProdDefinition_Id() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit 
                           </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteprodDefinitionModal' 
                           role='button' 
                           data-id='" . $productDefinition->getProdDefinition_Id() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete 
                          </button>
                        </div>
                    </div>

                       </td></tr>
                        </span></td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=productDefinitionModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="productdetails_form" enctype="multipart/form-data"
            action="../Controller/productDefinitionController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Product Definition</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-4" tabindex="1">
                                <input type="text" name="productName" id="productName" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                            <label class="col-md-2 text-right">Product Description<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4" tabindex="2">
                                <input type="text" name="productDescription" id="productDescription"
                                    class="form-control" data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <label class="col-md-2 text-right">Grains <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Grains" class="form-select" required name="Grains">

                                </select>
                            </div>

                            <label class="col-md-2 text-right">Override <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="override" class="form-select" required name="override">
                                    <option>--Select an option--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">CabinetType <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="CabinetType" class="form-select" required name="CabinetType">

                                </select>
                            </div>

                            <label class="col-md-2 text-right"> Finish <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Finish" class="form-select" required name="Finish">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="productCategory" class="form-select" required name="productCategory">

                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div> -->

                            <label class="col-md-2 text-right"> Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="productSubCategory" class="form-select" required name="productSubCategory">

                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productsubcatModal'><i
                                        class="fas fa-plus-circle"></i>SubCategory</a>
                            </div> -->
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="Quantity" id="Quantity" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> CL <span class="text-danger">*</span></label>
                            <div class="input-group col-md-3">
                                <input type="text" name="Lengthvalue" id="Lengthvalue" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="Dimension1" class="form-select" required name="Dimension1">

                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="Widthvalue" id="Widthvalue" class="form-control" data-parsley-type="text"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="Dimension2" class="form-select" required name="Dimension2">

                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="Depthvalue" id="Depthvalue" class="form-control" data-parsley-type="text"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="Dimension3" class="form-select" required name="Dimension3">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> CW <span class="text-danger">*</span></label>
                            <div class="input-group col-md-3">
                                <input type="text" name="CWLength" id="CWLength" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="CWDimension1" class="form-select" required name="CWDimension1">

                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="CWWidth" id="CWWidth" class="form-control" data-parsley-type="text"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="CWDimension2" class="form-select" required
                                        name="CWDimension2">

                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="CWDepth" id="CWDepth" class="form-control" data-parsley-type="text"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="CWDimension3" class="form-select" required
                                        name="CWDimension3">

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">GL-W <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="GL" class="form-select" required name="GL">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">FL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="FL" class="form-select" required name="FL">
                                    <option>--select an option--</option>
                                    <option value="PEB Thickness">PEB Thickness</option>
                                    <option value="SEB Thickness">SEB Thickness</option>
                                </select>
                            </div>
                            <label class="col-md-2 text-right">BL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="BL" class="form-select" required name="BL">
                                    <option>--select an option--</option>
                                    <option value="PEB Thickness">PEB Thickness</option>
                                    <option value="SEB Thickness">SEB Thickness</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">RL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="RL" class="form-select" required name="RL">
                                    <option>--select an option--</option>
                                    <option value="PEB Thickness">PEB Thickness</option>
                                    <option value="SEB Thickness">SEB Thickness</option>
                                </select>
                            </div>
                            <label class="col-md-2 text-right"> RW <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="RW" class="form-select" required name="RW">
                                    <option>--select an option--</option>
                                    <option value="PEB Thickness">PEB Thickness</option>
                                    <option value="SEB Thickness">SEB Thickness</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">EB-LW <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="EB_LW" class="form-select" required name="EB_LW">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="productcreatedby" id="productcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="productmodifiedby" id="productmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=editproductDefinitionModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="editproductDefinition_form" enctype="multipart/form-data" action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Product Definition</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedproductName" id="editedproductName" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" name="prodDefinition_Id" id="prodDefinition_Id" value="">
                            </div>

                            <label class="col-md-2 text-right">Product Description<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedproductDescription" id="editedproductDescription"
                                    class="form-control" data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Grains <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedGrains" class="form-select" required name="editedGrains">

                                </select>
                            </div>

                            <label class="col-md-2 text-right">Override <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedoverride" class="form-select" required name="editedoverride">
                                    <option>--Select an option--</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Type <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedType" class="form-select" required name="editedType">

                                </select>
                            </div>

                            <label class="col-md-2 text-right"> Finish <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedFinish" class="form-select" required name="editedFinish">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedproductCategory" class="form-select" required
                                    name="editedproductCategory">

                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div> -->

                            <label class="col-md-2 text-right"> Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedproductSubCategory" class="form-select" required
                                    name="editedproductSubCategory">

                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productsubcatModal'><i
                                        class="fas fa-plus-circle"></i>SubCategory</a>
                            </div> -->
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedQuantity" id="editedQuantity" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> CL <span class="text-danger">*</span></label>
                            <div class="input-group col-md-3">
                                <input type="text" name="editedLength" id="editedLength" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="editedLengthDimension" class="form-select" required name="Dimensions">
                                        <option>--Select an option--</option>
                                        <option>Length</option>
                                        <option>Width</option>
                                        <option>Depth</option>
                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="editedWidth" id="editedWidth" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="editedWidthDimension" class="form-select" required name="Dimensions">
                                        <option>--Select an option--</option>
                                        <option>Length</option>
                                        <option>Width</option>
                                        <option>Depth</option>
                                    </select>
                                </div>
                            </div>
                            -
                            <div class="input-group col-md-3">
                                <input type="text" name="editedDepth" id="editedDepth" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <div class="input-group-append ">
                                    <select id="editedDepthDimension" class="form-select" required name="Dimensions">
                                        <option>--Select an option--</option>
                                        <option>Length</option>
                                        <option>Width</option>
                                        <option>Depth</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> CW <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedCW" id="editedCW" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">GL-W<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedGLW" id="editedGLW" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">FL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedFL" class="form-select" required name="editedFL">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">BL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedBL" class="form-select" required name="editedBL">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">RL <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedRL" class="form-select" required name="editedRL">

                                </select>
                            </div>
                            <label class="col-md-2 text-right"> RW <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedRW" class="form-select" required name="editedRW">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">EB-LW <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedEB_LW" class="form-select" required name="editedEB_LW">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedproductcreatedby" id="editedproductcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="editedproductmodifiedby" id="editedproductmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=deleteproductDefinitionModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_product_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Product.
                    </p>
                    <input type="hidden" name="delprodDefinition_Id" id="delprodDefinition_Id" value="">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script>
$(document).ready(function() {

    var dataTable = $('#productDefinition_table').DataTable({});
    var nEditing = null;

    $('#productDefinition_table tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#prodDefinition_Id').val(this.cells[0].innerHTML);
        $('#editedproductName').val(this.cells[0].innerHTML);
        $('#displayproductName').text(this.cells[0].innerHTML);

        $('#editedproductDescription').val(this.cells[1].innerHTML);
        $('#displayproductDescription').text(this.cells[1].innerHTML);

        $('#editedGrains').val(this.cells[2].innerHTML);
        $('#displayGrains').text(this.cells[3].innerHTML);

        $('#editedoverride').val(this.cells[4].innerHTML);
        $('#displayoverride').text(this.cells[5].innerHTML);

        $('#editedType').val(this.cells[6].innerHTML);
        $('#displayType').text(this.cells[7].innerHTML);

        $('#editedFinish').val(this.cell[11].innerhtml);
        $('#displayFinish').text(this.cell[11].innerhtml);

        $('#editedproductCategory').val(this.cells[8].innerHTML);
        $('#displayproductCategory').text(this.cells[9].innerHTML);

        $('#editedproductSubCategory').val(this.cell[10].innerhtml);
        $('#displayproductSubCategory').text(this.cells[10].innerHTML);

        $('#editedQuantity').val(this.cells[12].innerHTML);
        $('#displayQuantity').text(this.cells[12].innerHTML);

        $('#editedLength').val(this.cells[13].innerHTML);
        $('#displayLength').text(this.cells[13].innerHTML);

        $('#editedWidth').val(this.cells[14].innerHTML);
        $('#displayWidth').text(this.cells[14].innerHTML);

        $('#editedDepth').val(this.cells[15].innerHTML);
        $('#displayDepth').text(this.cells[15].innerHTML);

        $('#editedCW').val(this.cells[16].innerHTML);
        $('#displayCW').text(this.cells[16].innerHTML);

        $('#editedGL').val(this.cells[17].innerHTML);
        $('#displayGL').text(this.cells[17].innerHTML);

        $('#editedGW').val(this.cells[16].innerHTML);
        $('#displayGW').text(this.cells[17].innerHTML);

        $('#editedFL').val(this.cells[16].innerHTML);
        $('#displayFL').text(this.cells[17].innerHTML);

        $('#editedBL').val(this.cells[16].innerHTML);
        $('#displayBL').text(this.cells[17].innerHTML);

        $('#editedRL').val(this.cells[16].innerHTML);
        $('#displayRL').text(this.cells[17].innerHTML);

        $('#editedRW').val(this.cells[16].innerHTML);
        $('#displayRW').text(this.cells[17].innerHTML);

        $('#editedEB-L').val(this.cells[16].innerHTML);
        $('#displayEB-L').text(this.cells[17].innerHTML);

        $('#editedEB-W').val(this.cells[16].innerHTML);
        $('#displayEB-W').text(this.cells[17].innerHTML);

        var fetchsubcaturl = window.location.origin +
            "/acedecor/Admin/Controller/product_subcategorycontroller.php/?productcatid=" + $(
                '#editedproductCategory').val();
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#editedproductSubCategory').append('<option value="' + value
                    .productsubcatid +
                    '">' + value
                    .productsubcatname + '</option>');
            });
        });
    });

    fetchCLurl =
        config.developmentPath +
        "/Admin/Controller/CLDimensionController.php/";
    $.getJSON(fetchCLurl, function(data) {
        $('#Dimension1').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#Dimension2').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#Dimension3').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#CWDimension1').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#CWDimension2').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#CWDimension3').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#Dimension1').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');
            $('#Dimension2').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');
            $('#Dimension3').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');

            $('#CWDimension1').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');
            $('#CWDimension2').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');
            $('#CWDimension3').append('<option value="' + value.CL_Dimensions +
                '">' +
                value
                .CL_Dimensions + '</option>');

        });
    });



    fetchFinishurl =
        config.developmentPath +
        "/Admin/Controller/FinishController.php/";
    $.getJSON(fetchFinishurl, function(data) {
        $('#Finish').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#Finish').append('<option value="' + value.FinishId +
                '">' +
                value
                .Finish + '</option>');
        });
    });

    fetchGrainsurl =
        config.developmentPath +
        "/Admin/Controller/rotationController.php/";
    $.getJSON(fetchGrainsurl, function(data) {
        $('#Grains').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#Grains').append('<option value="' + value.rotationId +
                '">' +
                value
                .sides + '</option>');
        });
    });

    fetchGLurl =
        config.developmentPath +
        "/Admin/Controller/GLController.php/";
    console.log(fetchGLurl);
    $.getJSON(fetchGLurl, function(data) {
        $('#GL').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#GL').append('<option value="' + value.GL_Id +
                '">' +
                value
                .GL + '</option>');
        });
    });

    fetchCabinetTypeurl =
        config.developmentPath +
        "/Admin/Controller/CabinetTypeController.php/";
    $.getJSON(fetchCabinetTypeurl, function(data) {
        $('#CabinetType').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#CabinetType').append('<option value="' + value.CabinetType_Id +
                '">' +
                value
                .CabinetType + '</option>');
        });
    });

    debugger;

    fetchEBLWurl =
        config.developmentPath +
        "/Admin/Controller/EB_LWController.php/";
    console.log(fetchEBLWurl);
    $.getJSON(fetchEBLWurl, function(data) {
        $('#EB_LW').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#EB_LW').append('<option value="' + value.EBLW_Id +
                '">' +
                value
                .EB_LW + '</option>');
        });
    });


    var url = config.developmentPath + "/Admin/Controller/product_categorycontroller.php";
    let productcatid = 0;
    $.getJSON(url, function(data) {
        $('#productCategory').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {

            $('#productCategory').append('<option  value="' + value
                .productcatid +
                '">' +
                value
                .productcatname + '</option>');
            $('#editedproductcategory').append('<option  value="' +
                value
                .productcatid +
                '">' + value
                .productcatname + '</option>');

            // setproductSubCategory(value.productcatid);

        });
    });

    function setproductSubCategory(productcatid) {
        debugger;
        var fetchsubcaturl = window.location.origin +
            "/Acedecor/Admin/Controller/product_SubcategoryController.php/?productcatid=" +
            productcatid;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#productSubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#productSubCategory').append('<option value="' + value
                    .productsubcatid +
                    '">' +
                    value
                    .productsubcatname + '</option>');
                $('#editedproductSubCategory').append('<option value="' +
                    value
                    .productsubcatid +
                    '">' +
                    value
                    .productsubcatname + '</option>');
            });
        });
    }

    $('#productCategory').on('change', function() {
        debugger;
        $('#productSubCategory').empty();
        setproductSubCategory(this.value);

    });

    $('#editproductDefinition_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/productDefinitionController.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        $('#editproductDefinitionModal').dispose();
        event.preventDefault();
    });

    $('#deleteproductDefinitionModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#delprodDefinition_Id').val(rowid);
    });
    $('#deletebutton').click(function() {
        $.ajax({
            url: "http://localhost/acedecor/Admin/Controller/productDefinitionController.php/",
            method: "POST",
            data: {
                id: $('#delprodDefinition_Id').val(),
                action: 'delete'
            },
            success: function(data) {
                $('#message').html(data);
                dataTable.ajax.reload();
                setTimeout(function() {
                    $('#message').html('');
                }, 5000);
            }
        });
    });

});
</script>