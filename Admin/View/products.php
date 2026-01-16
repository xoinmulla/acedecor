<?php
include('session.php');
include('productNavigation.php');
require_once("../DB Operations/productsOps.php");
require_once("../DB Operations/product_categoryOps.php");
require_once("../DB Operations/product_subcategoryOps.php");
require_once("../Model/item_detailsmodel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>

<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Products List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#productdetailsModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="product_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style='display:none'>Product Id</th>
                        <th>CL-Id</th>
                        <th>Product Name</th>
                        <th style='display:none'>Dimensions ID</th>
                        <th>Dimensions</th>
                        <th style='display:none'>MaterialId</th>
                        <th>Material</th>
                        <th style='display:none'>Brandid</th>
                        <th>Brand</th>
                        <th style='display:none'>Unit Id</th>
                        <th style='display:none'>Unit</th>
                        <th style='display:none'>Item Category Id</th>
                        <th> Category</th>
                        <th style='display:none'>Item Sub Category ID</th>
                        <th> Sub Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $productdetailslist = DBproductdetails::getallproductdetails();
                    foreach ($productdetailslist as $productdetails) {
                        echo "<tr><td>" . $productdetails->get_productCode() . "</td>
                        <td>" . $productdetails->get_productname() . "</td>
                        <td style='display:none'>" . $productdetails->get_productdimensionsid() . "</td>
                        <td>" . $productdetails->get_productdimensions() . "</td>

                        <td style='display:none'>" . $productdetails->get_productmaterial() . "</td>
                        <td>" . $productdetails->get_productmaterialName() . "</td>

                        <td style='display:none'>" . $productdetails->get_productbrandid() . "</td>
                        <td>" . $productdetails->get_productbrand() . "</td>

                        <td style='display:none'>" . $productdetails->get_productcategoryid() . "</td>
                        <td>" . $productdetails->get_productcategoryname() . "</td>

                        <td style='display:none'>" . $productdetails->get_productmaterialSubCategoryid() . "</td>
                        <td>" . $productdetails->get_productmaterialSubCategory() . "</td>

                        <td style='display:none'>" . $productdetails->get_productunitid() . "</td>
                        <td style='display:none'>" . $productdetails->get_productunit() . "</td>
                       
                        <td>
                        <a class='' data-toggle='modal' data-target='#detailsProductModal' name='delete_button' role='button' data-id='" . $productdetails->get_productid() . "'>
                        <i class='fas fa-info-circle'></i></a>
                        <a class='' data-toggle='modal' data-target='#editproductdetailsModal' role='button' data-id='" . $productdetails->get_productid() . "'> 
                        <i class='fas fa-user-edit'></i> </a>
                        <a class='' data-toggle='modal' data-target='#deleteProductModal' name='delete_button' role='button' data-id='" . $productdetails->get_productid() . "'>
                        <i class='fas fa-trash-alt'></i></a>
                        "
                            . "</td></tr>
                        </span></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=productdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-xl">
        <form method="post" id="productdetails_form" enctype="multipart/form-data"
            action="../Controller/productcontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Item Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">CL-ID <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="CLID" id="CLID" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                            <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="productquantity" id="productquantity" class="form-control"
                                    data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Cabinet Dimensions<span
                                    class="text-danger"></span></label>
                        </div>
                        <div class="row">
                            <label class="col-md-2 text-right">Length<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="Length" id="Length" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                            <label class="col-md-2 text-right">Width<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="Width" id="Width" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="productcategoryname" class="form-select" required
                                    name="productcategoryname">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="productmaterialSubCategory" class="form-select" required
                                    name="productmaterialSubCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Finish <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Finish" class="form-select" required name="Finish">

                                </select>
                            </div>
                            <label class="col-md-2 text-right"> Cabinet Type <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="CabinetType" class="form-select" required name="CabinetType">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="productname" id="productname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="productId" name="productId" value="">
                                <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="productcategoryid" name="productcategoryid" value="">
                                <input type="hidden" id="productmaterialSubCategoryid"
                                    name="productmaterialSubCategoryid" value="">
                                <input type="hidden" id="productdimensionsid" name="productdimensionsid" value="">
                                <input type="hidden" id="productunitid" name="productunitid" value="">
                                <input type="hidden" id="productbrandid" name="productbrandid" value="">

                            </div>
                            <label class="col-md-2 text-right">Product Code<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="ProductCode" id="ProductCode" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Mat Brand <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="matBrand" class="form-select" required name="matBrand">

                                </select>
                            </div>

                            <label class="col-md-2 text-right">Grains <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Grains" class="form-select" required name="Grains">

                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Material Category <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="materialCategory" class="form-select" required name="materialCategory">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">Material Sub Category <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="materialSubCategory" class="form-select" required
                                    name="materialSubCategory">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Thickness" class="form-select" required name="Thickness">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">Material <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="Material" class="form-select" required name="Material">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">PEB <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="PEB" id="PEB" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                            <label class="col-md-2 text-right">PEB Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="PEBthickness" class="form-select" required name="PEBthickness">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">SEB <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="SEB" id="SEB" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                            <label class="col-md-2 text-right">SEB Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="SEBthickness" class="form-select" required name="SEBthickness">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Comments <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="Comments" id="Comments" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
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
<div class="modal fade " id=editproductdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="editedproductdetails_form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Product Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">CL-ID <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedCLID" id="editedCLID" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                            <label class="col-md-2 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedproductquantity" id="editedproductquantity"
                                    class="form-control" data-parsley-type="text" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 text-right">Cabinet Dimensions<span
                                    class="text-danger"></span></label>
                        </div>
                        <div class="row">
                            <label class="col-md-2 text-right">Length<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedLength" id="editedLength" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>

                            <label class="col-md-2 text-right">Width<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedWidth" id="editedWidth" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedproductcategory" class="form-select" required
                                    name="editedproductcategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Sub Category <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedproductSubCategory" class="form-select" required
                                    name="editedproductSubCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#productsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right"> Finish <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedFinish" class="form-select" required name="Finish">

                                </select>
                            </div>
                            <label class="col-md-2 text-right"> Cabinet Type <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedCabinetType" class="form-select" required name="CabinetType">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Product Name <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedproductname" id="editedproductname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="productId" name="productId" value="">

                            </div>
                            <label class="col-md-2 text-right">Product Code<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedProductCode" id="editedProductCode" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Mat Brand <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedmatBrand" class="form-select" required name="matBrand">

                                </select>
                            </div>

                            <label class="col-md-2 text-right">Grains <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedGrains" class="form-select" required name="Grains">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Material Category <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedmaterialCategory" class="form-select" required
                                    name="materialCategory">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">Material Sub Category <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedmaterialSubCategory" class="form-select" required
                                    name="editedmaterialSubCategory">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedThickness" class="form-select" required name="Thickness">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">Material <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedMaterial" class="form-select" required name="Material">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 text-right">PEB <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="editedPEB" id="editedPEB" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                            <label class="col-md-2 text-right">PEB Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedPEBthickness" class="form-select" required name="editedPEBthickness">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 text-right">SEB <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                <input type="text" name="editedSEB" id="editedSEB" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                </div>
                                <label class="col-md-2 text-right">SEB Thickness <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <select id="editedSEBthickness" class="form-select" required name="SEBthickness">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 text-right">Comments <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="editedComments" id="editedComments" class="form-control"
                                        required data-parsley-minlength="6" data-parsley-maxlength="16"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="hidden" name="productcreatedby" id="productcreatedby"
                                        class="form-control" required data-parsley-type="integer"
                                        data-parsley-minlength="10" data-parsley-maxlength="12"
                                        data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="hidden" name="productmodifiedby" id="productmodifiedby"
                                        class="form-control" required data-parsley-type="integer"
                                        data-parsley-minlength="10" data-parsley-maxlength="12"
                                        data-parsley-trigger="keyup" value="<?php echo $_SESSION['login_user']; ?>" />
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
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteproductModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_item_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Product.
                    </p>
                    <input type="hidden" name="productid" id="deleteproductid" value="">
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

<div class="modal fade" id=itemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="addCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatname" id="itemcatname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcatdescription" id="itemcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemcatcreatedby" id="itemcatcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcatmodifiedby" id="itemcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addCategorybtn" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=itemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="materialSubCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="addmaterialCategory" class="form-select" required name="itemcatid">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">materialSubCategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatname" id="itemsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">materialSubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemsubcatdescription" id="itemsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatcreatedby" id="itemsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="itemsubcatmodifiedby" id="itemsubcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addmaterialSubCategorybtn" class="btn btn-success"
                        value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id=productcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="addProductCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productcatname" id="productcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productcatdescription" id="productcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productcatcreatedby" id="productcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="productcatmodifiedby" id="productcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addCategorybtn" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=productsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="addProductmaterialSubCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product Category Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="addproductCategory" class="form-select" required name="productcatid">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product materialSubCategory Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatname" id="productsubcatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Product materialSubCategory Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="productsubcatdescription" id="productsubcatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatcreatedby" id="productsubcatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="productsubcatmodifiedby" id="productsubcatmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="addmaterialSubCategorybtn" class="btn btn-success"
                        value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=detailsProductModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Product Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="" alt="..." id="itemImage" width="200px" height="200px">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayCLID">CL-ID</label>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title" id="displayCLID"></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayProductQty">Product Quantity</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayProductQty"></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayProductLength">Product Length</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayProductLength"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayProductWidth">Product Width</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayProductWidth"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayCabinetType">Cabinet Type</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayCabinetType"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayproductname">Product Name</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayproductname"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayproductcategory">Product Category</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayproductcategory"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayproductSubCategory">Product Sub Category</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayproductSubCategory"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayFinish">Finish</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayFinish"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayProductCode">Product Code</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayProductCode"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaymatBrand">Material Brand</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaymatBrand"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayGrains">Grains</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayGrains"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaymaterialCategory">Material Category</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaymaterialCategory"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaymaterialSubCategory">Material SubCategory</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaymaterialSubCategory"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayThickness">Thickness</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayThickness"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayMaterial">Material</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayMaterial"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayPEB">PEB</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayPEB"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayPEBthickness">PEB Thickness </label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayPEBthickness"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaySEB">SEB</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaySEB"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaySEBthickness">SEB Thickness </label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaySEBthickness"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // debugger;
    // $("#IDgenerate").click(function() {
    //             var str = $('#productname').val();
    //             var res = str.slice(0, 2);
    //             $("#IDgenerate").val(res);
    //         });
    $('#editproductdetailsModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#productId').val(rowid);


    });

    var dataTable = $('#product_table').DataTable({});
    var nEditing = null;
    $('#product_table tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#productId').val(this.cells[0].innerHTML);
        $('#editedCLID').val(this.cells[0].innerHTML);
        $('#displayCLID').text(this.cells[0].innerHTML);
        $('#editedproductquantity').val(this.cells[1].innerHTML);
        $('#displayProductQty').text(this.cells[1].innerHTML);
        $('#editedLength').val(this.cells[2].innerHTML);
        $('#displayProductLength').text(this.cells[3].innerHTML)
        $('#editedWidth').val(this.cells[4].innerHTML);
        $('#displayProductWidth').text(this.cells[5].innerHTML)
        $('#editedproductcategory').val(this.cells[6].innerHTML);
        $('#displayproductcategory').text(this.cells[7].innerHTML)
        $('#editedproductSubCategory').val(this.cells[8].innerHTML);
        $('#displayproductSubCategory').text(this.cells[9].innerHTML)
        $('#editedFinish').val(this.cell[10].innerhtml)
        $('#displayFinish').text(this.cells[10].innerHTML)
        $('#editedCabinetType').val(this.cell[11].innerhtml)
        $('#displayCabinetType').text(this.cell[11].innerhtml)
        $('#editedproductname').val(this.cells[12].innerHTML);
        $('#displayproductname').text(this.cells[12].innerHTML)
        $('#editedProductCode').val(this.cells[13].innerHTML);
        $('#displayProductCode').text(this.cells[13].innerHTML)
        $('#editedmatBrand').val(this.cells[14].innerHTML);
        $('#displaymatBrand').text(this.cells[14].innerHTML)
        $('#editedGrains').val(this.cells[15].innerHTML);
        $('#displayGrains').text(this.cells[15].innerHTML)
        $('#editedmaterialCategory').val(this.cells[16].innerHTML);
        $('#displaymaterialCategory').text(this.cells[16].innerHTML);
        $('#editedmaterialSubCategory').val(this.cells[17].innerHTML);
        $('#displaymaterialSubCategory').text(this.cells[17].innerHTML);
        $('#editedThickness').val(this.cells[16].innerHTML);
        $('#displayThickness').text(this.cells[17].innerHTML);
        $('#editedMaterial').val(this.cells[16].innerHTML);
        $('#displayMaterial').text(this.cells[17].innerHTML);
        $('#editedPEB').val(this.cells[16].innerHTML);
        $('#displayPEB').text(this.cells[17].innerHTML);
        $('#editedPEBthickness').val(this.cells[16].innerHTML);
        $('#displayPEBthickness').text(this.cells[17].innerHTML);
        $('#editedSEB').val(this.cells[16].innerHTML);
        $('#displaySEB').text(this.cells[17].innerHTML);
        $('#editedSEBthickness').val(this.cells[16].innerHTML);
        $('#displaySEBthickness').text(this.cells[17].innerHTML);
        $('#editedComments').val(this.cells[16].innerHTML);
        $('#displayComments').text(this.cells[17].innerHTML);

        var fetchsubcaturl = window.location.origin +
            "/acedecor/Admin/Controller/material_SubcategoryController.php/?catId=" + $(
                '#editedmaterialCategory').val();
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.

                $('#editedmaterialSubCategory').append('<option value="' + value
                    .materialsubcatId +
                    '">' + value
                    .materialsubcatName + '</option>');
            });
        });
    });


    $('#editedproductdetails_form').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/productcontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        $('#editproductdetailsModal').dispose();
        event.preventDefault();
    });

    $('#matBrand').on('change', function() {
        debugger;
        $('#materialCategory').empty();
        var url = config.developmentPath +
            "/Admin/Controller/material_CategoryController.php/?brandId=" +
            this.value;
        let isSelectedSet = false;
        let catId = 0;
        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                $('#materialCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#materialCategory').append('<option value="' + value.materialcatId +
                    '">' + value
                    .materialCatname + '</option>');
                $('#editedmaterialCategory').append('<option value="' + value
                    .materialcatId + '">' +
                    value
                    .materialCatname + '</option>');
                isSelectedSet = true;
                // setMatSubCategory(value.materialcatId);
            });
        });

    });

    function setmaterialSubCategory(catId) {
        var fetchsubcaturl = window.location.origin +
            "/Acedecor/Admin/Controller/material_SubcategoryController.php/?catId=" +
            catId;
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                $('#materialSubCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>'
                );
                $('#materialSubCategory').append('<option value="' + value
                    .materialsubcatId +
                    '">' +
                    value
                    .materialsubcatName + '</option>');
                $('#editedmaterialSubCategory').append('<option value="' + value
                    .materialsubcatId +
                    '">' +
                    value
                    .materialsubcatName + '</option>');
            });
        });
    }

    function setmaterial(catId, subcatId, brandId) {
        debugger;
        var fetchMaterialListurl = config.developmentPath +
            "/Admin/Controller/materialController.php/?catId=" + catId + "&subcatId=" +
            subcatId +
            "&brandId=" + brandId;
        $.getJSON(fetchMaterialListurl, function(data) {

            $.each(data, function(index, value) {

                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#Material').append('<option value="' + value.MaterialId + '">' +
                    value
                    .MaterialName + '</option>');
                $('#editedMaterial').append('<option value="' + value.MaterialId + '">' +
                    value
                    .MaterialName + '</option>');

            });
        });
    }


    $('#itemsubcatModal').on('show.bs.modal', function(e) {
        $('#addmaterialCategory').empty();
        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#addmaterialCategory').append('<option value="' + value
                    .itemcatid +
                    '">' + value
                    .itemcatname + '</option>');
            });
        });
    });


    let InputType = 2;
    fetchbrandurl =
        config.developmentPath +
        "/Admin/Controller/brandcontroller.php?InputId=" + InputType;
    $.getJSON(fetchbrandurl, function(data) {
        $('#matBrand').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#matBrand').append('<option value="' + value.brandid +
                '">' +
                value
                .brandname + '</option>');
        });
    });

    var url = window.location.origin + "/Acedecor/Admin/Controller/product_categorycontroller.php";
    let isSelectedSet1 = false;
    let productcatid = 0;
    $.getJSON(url, function(data) {
        $('#productcategoryname').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            if (isSelectedSet1 === false) {
                $('#productcategoryname').append('<option  value="' + value
                    .productcatid +
                    '">' +
                    value
                    .productcatname + '</option>');
                $('#editedproductcategory').append('<option  value="' +
                    value
                    .productcatid +
                    '">' + value
                    .productcatname + '</option>');
                isSelectedSet1 = true;
                setProductmaterialSubCategory(value.productcatid);
            } else {
                $('#productcategoryname').append('<option value="' + value
                    .productcatid + '">' +
                    value
                    .productcatname + '</option>');
                $('#editedproductcategory').append('<option value="' + value
                    .productcatid +
                    '">' +
                    value
                    .productcatname + '</option>');
            }
        });
    });

    function setProductmaterialSubCategory(productcatid) {
        debugger;
        var fetchsubcaturl = window.location.origin +
            "/Acedecor/Admin/Controller/product_SubcategoryController.php/?productcatid=" +
            productcatid;
        $.getJSON(fetchsubcaturl, function(data) {
            $('#productmaterialSubCategory').append(
                '<option hidden disabled selected value>-- select an option --</option>'
            );
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#productmaterialSubCategory').append('<option value="' + value
                    .productsubcatid +
                    '">' +
                    value
                    .productsubcatname + '</option>');
                $('#editedproductmaterialSubCategory').append('<option value="' +
                    value
                    .productsubcatid +
                    '">' +
                    value
                    .productsubcatname + '</option>');
            });
        });
    }

    $('#productsubcatModal').on('show.bs.modal', function(e) {
        $('#addproductCategory').empty();
        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#addproductCategory').append('<option value="' + value
                    .productcatid +
                    '">' + value
                    .productcatname + '</option>');
            });
        });
    });


    $('#productcategoryname').on('change', function() {
        debugger;
        $('#productmaterialSubCategory').empty();
        setProductmaterialSubCategory(this.value);

    });


    $('#materialCategory').on('change', function() {
        $('#materialSubCategory').empty();
        $('#Material').empty();
        setmaterialSubCategory(this.value);

    });
    $('#materialSubCategory').on('change', function() {
        $('#Material').empty();
        setmaterial($('#materialCategory').val(), this.value, $('#matBrand').val());

    });

    $('#editedmaterialCategory').on('change', function() {
        $('#editedmaterialSubCategory').empty();
        fetchsubcaturl =
            window.location.origin +
            "/acedecor/Admin/Controller/item_materialSubCategorycontroller.php/?catId=" +
            this
            .value;
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#editedmaterialSubCategory').append('<option value="' +
                    value
                    .itemsubcatid +
                    '">' +
                    value
                    .itemsubcatname + '</option>');
            });
        });
    });

    fetchThicknessurl =
        config.developmentPath +
        "/Admin/Controller/thicknessController.php/";
    $.getJSON(fetchThicknessurl, function(data) {
        $('#Thickness').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#Thickness').append('<option value="' + value.ThicknessId +
                '">' +
                value
                .Thickness + '</option>');
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
            $('#Grains').append('<option value="' + value.GrainsId +
                '">' +
                value
                .sides + '</option>');
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
    fetchEBurl =
        config.developmentPath +
        "/Admin/Controller/EBController.php/";
    console.log(fetchEBurl);
    $.getJSON(fetchEBurl, function(data) {
        $('#PEBthickness').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $('#SEBthickness').append(
            '<option hidden disabled selected value>-- select an option --</option>'
        );
        $.each(data, function(index, value) {
            // APPEND OR INSERT DATA TO SELECT ELEMENT.
            $('#PEBthickness').append('<option value="' + value.EB_Id +
                '">' +
                value
                .EB + '</option>');
            $('#SEBthickness').append('<option value="' + value.EB_Id +
                '">' +
                value
                .EB + '</option>');
        });
    });


    $('#deleteItemModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#deleteproductid').val(rowid);
    });
    $('#deletebutton').click(function() {
        $.ajax({
            url: "http://localhost/acedecor/Admin/Controller/productcontroller.php/",
            method: "POST",
            data: {
                id: $('#deleteproductid').val(),
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

    $('#addProductCategoryForm').submit(function(event) {

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/product_categorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadProductCategoryList();
        $('#productcatModal').hide();
    });

    $('#addProductmaterialSubCategoryForm').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/product_materialSubCategorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadProductmaterialSubCategoryList();
        $('#productsubcatModal').hide();
    });

    $('#addCategoryForm').submit(function(event) {

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/item_categorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadCategoryList();
        $('#itemcatModal').hide();
    });
    $('#materialSubCategoryForm').submit(function(event) {
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: window.location.origin +
                "/acedecor/Admin/Controller/item_materialSubCategorycontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        reloadmaterialSubCategoryList();
        $('#itemsubcatModal').hide();
    });

    function reloadCategoryList() {
        $('#materialCategory').empty();
        $.getJSON(url, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#materialCategory').append('<option value="' + value.itemcatid +
                    '">' +
                    value
                    .itemcatname + '</option>');
            });
        });
    }

    function reloadmaterialSubCategoryList() {
        var selectedCategory = $('#materialCategory').val();
        fetchcompany = window.location.origin +
            "/Acedecor/Admin/Controller/item_compdetailscontroller.php/?catId=" + selectedCategory;

        $('#materialSubCategory').empty();
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.

                $('#materialSubCategory').append('<option value="' + value
                    .itemsubcatid + '">' +
                    value.itemsubcatname + '</option>');
            });
        });
    }


});
</script>