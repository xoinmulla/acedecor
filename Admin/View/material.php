<?php
include('session.php');
include('materialListNavigation.php');
require_once("../DB Operations/materialOps.php");
require_once("../DB Operations/item_categoryOps.php");
require_once("../DB Operations/item_subcategoryOps.php");
require_once("../Model/materialModel.php");
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<!-- DataTales Example -->
<style>
    /* Modal Polish */
    .modal-content-modern {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .modal-header-modern {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }

    /* Image Box */
    .product-img-frame {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 10px;
    }

    .product-img-frame img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* Info Cards */
    .info-card {
        background-color: #f8f9fc;
        border-radius: 10px;
        padding: 12px 15px;
        height: 100%;
        border-left: 4px solid #e3e6f0;
        transition: transform 0.2s;
    }

    .info-card:hover {
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    /* Card Colors */
    .card-highlight {
        border-left-color: #1cc88a;
        background-color: #f0fdf4;
    }

    /* Green/Money */
    .card-spec {
        border-left-color: #4e73df;
    }

    /* Blue/Specs */
    .card-warn {
        border-left-color: #f6c23e;
    }

    /* Yellow/Units */

    /* Typography */
    .label-text {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        display: block;
        margin-bottom: 4px;
        font-weight: 700;
    }

    .value-text {
        font-size: 1rem;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
    }

    .value-text-lg {
        font-size: 1.4rem;
        color: #1cc88a;
    }

    /* Modern Table */
    .table-modern thead th {
        background-color: #eaecf4;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
        border: none;
    }
</style>
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Material
                    List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#itemdetailsModal">
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered" id="item_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="display:none">Material Id</th>
                        <th>Material Name</th>
                        <th>Thickness</th>
                        <th>Description</th>
                        <th style="display:none">Category Id</th>
                        <th>Category</th>
                        <th style="display:none">SubCategory Id</th>
                        <th>Subcategory</th>
                        <th style="display:none">Brand Id</th>
                        <th>Brand</th>

                        <th style="display:none">Image</th>
                        <th style="display:none">Unit</th>
                        <th style="display:none">UnitFactor</th>
                        <th style="display:none">Material Code</th>
                        <th style="display:none">HSN Code</th>
                        <th style="display:none">SPU</th>
                        <th style="display:none">Qty</th>
                        <th style="display:none">MRP</th>
                        <th style="display:none">PP MRP</th>
                        <th style="display:none">GST</th>
                        <th style="display:none">Total MRP</th>
                        <th style="display:none">Unit ID</th>
                        <th style="display:none">Discount</th>
                        <th style="display:none">Price</th>
                        <th style="display:none">Total Value</th>

                        <th>Inwarded Qty</th>
                        <th>Allocated Qty</th>
                        <th>Available Qty</th>

                        <th style="display:none">Thickness ID</th>
                        <th style="display:none">Grains ID</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $materialdetailslist = DBmaterialdetails::getallMaterialdetails();

                    foreach ($materialdetailslist as $material) {

                        $id = $material->get_MaterialId();

                        // 🔐 DELETE BUTTON LOGIC
                        if ($material->getCanDelete()) {
                            $deleteAction = "
<button type='button' class='dropdown-item'
    data-toggle='modal'
    data-target='#deleteMaterialModal'
    data-id='{$id}'>
    Delete Material
</button>";

                        } else {
                            $deleteAction = "
            <button class='dropdown-item text-muted' disabled
                title='Material is used in Quotation or Purchase Order'>
                Cannot Delete
            </button>";
                        }

                        echo "
    <tr>
        <td style='display:none'>{$id}</td>
        <td>{$material->get_MaterialName()}</td>
        <td>{$material->get_MaterialThickness()}</td>
        <td>{$material->get_MaterialDescription()}</td>

        <td style='display:none'>{$material->get_Category()}</td>
        <td>{$material->get_CategoryName()}</td>

        <td style='display:none'>{$material->get_SubCategory()}</td>
        <td>{$material->get_SubCategoryName()}</td>

        <td style='display:none'>{$material->get_Brand()}</td>
        <td>{$material->get_BrandName()}</td>

        <td style='display:none'>{$material->get_MaterialImage()}</td>
        <td style='display:none'>{$material->get_MaterialUnit()}</td>
        <td style='display:none'>{$material->get_MaterialUnitFactorId()}</td>

        <td style='display:none'>{$material->get_MaterialCode()}</td>
        <td style='display:none'>{$material->get_MaterialHSNcode()}</td>
        <td style='display:none'>{$material->get_MaterialSPU()}</td>
        <td style='display:none'>{$material->get_MaterialQty()}</td>
        <td style='display:none'>{$material->get_MaterialMRP()}</td>
        <td style='display:none'>{$material->get_MaterialPPMRP()}</td>
        <td style='display:none'>{$material->get_MaterialGST()}</td>
        <td style='display:none'>{$material->get_MaterialTotalMRP()}</td>
        <td style='display:none'>{$material->get_MaterialUnitId()}</td>
        <td style='display:none'>{$material->get_MaterialDiscount()}</td>
        <td style='display:none'>{$material->get_MaterialPrice()}</td>
        <td style='display:none'>{$material->get_MaterialTotalValue()}</td>

        <td>{$material->get_ReceivedQty()}</td>
        <td>{$material->getAllocatedQty()}</td>
        <td>{$material->getAvailableQty()}</td>

        <td style='display:none'>{$material->get_MaterialThicknessID()}</td>
        <td style='display:none'>{$material->get_MaterialGrainsId()}</td>

        <td>
            <div class='dropdown'>
                <button class='btn btn-secondary dropdown-toggle'
                    type='button' data-toggle='dropdown'>
                    Actions
                </button>
                <div class='dropdown-menu'>

                    <button class='dropdown-item'
                        data-toggle='modal'
                        data-target='#detailsItemModal'
                        data-id='{$id}'>
                        Material Info
                    </button>

                   <button class='dropdown-item'
                       data-toggle='modal'
                       data-target='#edititemdetailsModal'

    data-id='" . $material->get_MaterialId() . "'
    data-name='" . htmlspecialchars($material->get_MaterialName()) . "'
    data-desc='" . htmlspecialchars($material->get_MaterialDescription()) . "'

    data-cat='" . $material->get_Category() . "'
    data-subcat='" . $material->get_SubCategory() . "'
    data-brand='" . $material->get_Brand() . "'

    data-unit='" . $material->get_MaterialUnitId() . "'
    data-factor='" . $material->get_MaterialUnitFactorId() . "'

    data-code='" . $material->get_MaterialCode() . "'
    data-hsn='" . $material->get_MaterialHSNcode() . "'

    data-qty='" . $material->get_MaterialQty() . "'
    data-spu='" . $material->get_MaterialSPU() . "'
    data-mrp='" . $material->get_MaterialMRP() . "'
    data-gst='" . $material->get_MaterialGST() . "'
    data-discount='" . $material->get_MaterialDiscount() . "'

    data-price='" . $material->get_MaterialPrice() . "'
    data-total='" . $material->get_MaterialTotalValue() . "'

    data-thickness='" . $material->get_MaterialThicknessID() . "'
    data-grains='" . $material->get_MaterialGrainsId() . "'

    data-image='" . $material->get_MaterialImage() . "'>
    Edit Material
</button>


                    {$deleteAction}

                </div>
            </div>
        </td>
    </tr>";
                    }
                    ?>
                </tbody>


            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<div class="modal fade" id="itemdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemdetails_form" enctype="multipart/form-data">
            <input type="hidden" name="from_modal" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Material Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">


                    <!-- Material Name -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialname" id="materialname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="itemcompid" name="itemcompid" value="">
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="materialdescription" id="materialdescription" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Category / Add Category Button-->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right"> Category<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="materialCategory" class="form-select" required
                                    name="materialCategory"></select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#itemcatModal"><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>

                    <!-- Subcategory / Add Subcategory -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right"> Subcategory<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="materialsubCategory" class="form-select" required
                                    name="materialsubCategory"></select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#itemsubcatModal"><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>

                    <!-- Brand (Company) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="company" class="form-select" required name="company">
                                </select>
                            </div>
                            <!-- <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#brandModal'>
                                    <i class="fas fa-plus-circle"></i> Brand
                                </a>
                            </div> -->
                        </div>
                    </div>

                    <!-- Material Code -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Code <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCode" id="materialCode" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- HSN -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSNcode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialhsncode" id="materialhsncode" class="form-control"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- Quantity / Unit / Factor -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialQty" id="materialQty" class="form-control" required
                                    data-parsley-trigger="change" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right ">Unit <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="materialunit" class="form-select" required name="materialunit"></select>
                            </div>

                            <label class="col-md-2 text-right">Factor <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="materialunitFactor" class="form-select" required
                                    name="materialunitFactor"></select>
                            </div>
                        </div>
                    </div>
                    <!-- Extra MATERIAL fields: Thickness & Grains -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="thickness" class="form-select" required name="thickness"></select>
                            </div>

                            <label class="col-md-2 text-right">Grains <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="materialGrains" class="form-select" required name="materialGrains"></select>
                            </div>
                        </div>
                    </div>
                    <!-- SPU / MRP / GST / Discount -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Standard Packing Unit">SPU<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialSPU" id="materialSPU" class="form-control" required
                                    data-parsley-minlength="1" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialMRP" id="materialMRP" class="form-control" required
                                    data-parsley-minlength="1" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Goods and Service Tax">GST <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialGST" id="materialGST" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <!-- Company Discount -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Discount (%)</label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" name="materialDiscount" id="materialDiscount"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <!-- Amount (MRP × Factor) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialAmount" id="materialAmount" class="form-control"
                                    required readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Price (readonly) and Total Value (readonly) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Price <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialPrice" id="materialPrice" class="form-control" required
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total Value <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialTotalValue" id="materialTotalValue"
                                    class="form-control" required readonly />
                            </div>
                        </div>
                    </div>



                    <!-- Upload Image -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="materialimage" id="materialimage" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <span id="form_message"></span>
                    <!-- Hidden created/modified -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="materialcreatedby" id="materialcreatedby"
                                    class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
                                <input type="hidden" name="materialmodifiedby" id="materialmodifiedby"
                                    class="form-control" value="<?php echo $_SESSION['login_user']; ?>" />
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
<div class="modal fade" id="edititemdetailsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" id="editeditemdetails_form" enctype="multipart/form-data"
            action="../Controller/materialController.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Material Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">


                    <!-- Use same fields but with edited* names -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialname" id="editedmaterialname"
                                    class="form-control" required />
                                <input type="hidden" name="materialid" id="materialid" />
                            </div>
                        </div>
                    </div>

                    <!-- other edited fields -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description</label>
                            <div class="col-md-8">
                                <textarea name="editedmaterialdescription" id="editedmaterialdescription"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Category / Subcategory -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category</label>
                            <div class="col-md-5">
                                <select id="editedmaterialCategory" class="form-select"
                                    name="editedmaterialCategory"></select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#itemcatModal"><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Subcategory</label>
                            <div class="col-md-5">
                                <select id="editedsubCategory" class="form-select" name="editedsubCategory"></select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle="modal" data-target="#itemsubcatModal"><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand</label>
                            <div class="col-md-8">
                                <select id="editedmaterialbrand" class="form-select"
                                    name="editedmaterialbrand"></select>
                            </div>
                        </div>
                    </div>

                    <!-- Material Code / HSN -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Material Code</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialCode" id="editedmaterialCode"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSN Code</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialhsncode" id="editedmaterialhsncode"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <!-- Qty / Unit / Factor -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialQty" id="editedmaterialQty"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Unit</label>
                            <div class="col-md-4">
                                <select id="editedunit" class="form-select" name="editedunit"></select>
                            </div>
                            <label class="col-md-2 text-right">Factor</label>
                            <div class="col-md-2">
                                <select id="editedunitFactor" class="form-select" name="editedunitFactor"></select>
                            </div>
                        </div>
                    </div>

                    <!-- SPU / MRP / GST / Discount -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SPU</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialSPU" id="editedmaterialSPU"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialMRP" id="editedmaterialMRP"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">GST</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialGST" id="editedmaterialGST"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Discount (%)</label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" name="editedmaterialDiscount"
                                    id="editedmaterialDiscount" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <!-- Amount (MRP × Factor) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialAmount" id="editedmaterialAmount"
                                    class="form-control" required readonly />
                            </div>
                        </div>
                    </div>
                    <!-- Price & Total for Edited -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Price</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialPrice" id="editedmaterialPrice"
                                    class="form-control" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total Value</label>
                            <div class="col-md-8">
                                <input type="text" name="editedmaterialTotalValue" id="editedmaterialTotalValue"
                                    class="form-control" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Thickness & Grains (edited) -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Thickness</label>
                            <div class="col-md-4">
                                <select id="editedthickness" class="form-select" name="editedthickness"></select>
                            </div>
                            <label class="col-md-2 text-right">Grains</label>
                            <div class="col-md-2">
                                <select id="editedRotation" class="form-select" name="editedRotation"></select>
                            </div>
                        </div>
                    </div>

                    <!-- Upload / Hidden createdby/modifiedby -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image</label>
                            <div class="col-md-8">
                                <input type="file" name="editedmaterialimage" id="editedmaterialimage"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 text-right">Preview</div>
                            <div class="col-md-8">
                                <img id="editedPreviewImage" src="" class="img-thumbnail mb-2" width="150">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="existing_image" id="existing_image">

                    <span id="edit_form_message"></span>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="edited_hidden_id" />
                        <input type="hidden" name="action" id="edit_action" value="Edit" />
                        <input type="submit" name="edit_submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="delete_material_form">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Delete Material</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this Material?</p>

                    <!-- Correct ID -->
                    <input type="hidden" name="id" id="deleteMaterialId">

                    <!-- Required for delete -->
                    <input type="hidden" name="action" value="delete">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteMaterial">
                        Confirm
                    </button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=itemcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="addMaterialCategoryForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend">

                                    <button type="button" class="btn btn-secondary">
                                        Select Brands
                                    </button>
                                    <button type="button"
                                        class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu" id="checkboxes">

                                    </ul>
                                    <div class="col-md-3">
                                        <a class="btn btn-primary" data-toggle='modal' data-target='#brandModal'>
                                            <i class="fas fa-plus-circle"></i> Brand
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatname" id="materialCatname" class="form-control"
                                    required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Category Description <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="materialCatdescription" id="materialCatdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-8">
                                <input type="hidden" name="materialCatcreatedby" id="materialCatcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="materialCatmodifiedby" id="materialCatmodifiedby"
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
<div class="modal fade" id=itemsubcatModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="post" id="addMaterialSubcatForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Material SubCategory</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message_add"></span>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material Category Name <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <select id="materialcatid" name="materialcatid" class="form-select" required></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material SubCategory Name <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <input type="text" name="materialsubcatname" id="materialsubcatname" class="form-control"
                                required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                data-parsley-trigger="keyup" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-5 text-right">Material SubCategory Description <span
                                class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <input type="text" name="materialsubcatdescription" id="materialsubcatdescription"
                                class="form-control" required data-parsley-minlength="3" data-parsley-maxlength="255"
                                data-parsley-trigger="keyup" />
                        </div>
                    </div>

                    <input type="hidden" name="materialsubcatcreatedby" id="materialsubcatcreatedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />
                    <input type="hidden" name="materialsubcatmodifiedby" id="materialsubcatmodifiedby"
                        value="<?php echo $_SESSION['login_user']; ?>" />

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="Add" />
                    <input type="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="detailsItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-modern shadow-lg">

            <div class="modal-header modal-header-modern align-items-center">
                <div>
                    <h5 class="modal-title font-weight-bold text-primary" id="modal_title">
                        <i class="fas fa-info-circle mr-2"></i> Material Information
                    </h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light px-4 py-4">
                <input type="hidden" id="infoitemid">

                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                        <div class="product-img-frame">
                            <img id="itemImage" src="" alt="Item Image">
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-8">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="font-weight-bold text-dark mb-1" id="displayItemName"></h3>
                                <div class="mb-3">
                                    <span class="badge badge-primary px-3 py-2 mr-1" id="displayItemCategory"></span>
                                    <span class="badge badge-light border px-3 py-2 text-muted"
                                        id="displayItemSubCategory"></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <small class="text-muted text-uppercase font-weight-bold">Brand</small>
                                <h5 class="text-dark font-weight-bold" id="displayItemComapny"></h5>
                            </div>
                        </div>

                        <div class="bg-white p-3 rounded shadow-sm border-0 mt-2">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <small class="text-muted font-weight-bold">Description</small>
                                    <p class="mb-0 text-dark" id="displayItemDescription"></p>
                                </div>
                                <div class="col-md-6 border-top pt-2 mt-1">
                                    <small class="text-muted">Item Code: </small>
                                    <span class="font-weight-bold text-dark" id="displayItemArticleNo"></span>
                                </div>
                                <div class="col-md-6 border-top pt-2 mt-1">
                                    <small class="text-muted">HSN Code: </small>
                                    <span class="font-weight-bold text-dark" id="displayItemHSNCode"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold mb-3 pl-1 text-uppercase small ls-1">
                    Product Specifications & Financials
                </h6>

                <!-- ROW 1 -->
                <div class="row mb-2">
                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text">SPU</span>
                            <p class="value-text" id="displayItempu"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit</span>
                            <p class="value-text" id="displayunit"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit Factor</span>
                            <p class="value-text" id="displayunitFactor"></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-spec">
                            <span class="label-text">Thickness</span>
                            <p class="value-text" id="displayItemThickness"></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-spec">
                            <span class="label-text">Grains</span>
                            <p class="value-text" id="displayItemGrains"></p>
                        </div>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="row">
                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text">Quantity</span>
                            <p class="value-text" id="displayItemsize"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">MRP</span>
                            <p class="value-text" id="displayItemMRP"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">GST</span>
                            <p class="value-text" id="displayItemGST"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Discount</span>
                            <p class="value-text" id="displayItemDiscount"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-highlight">
                            <span class="label-text text-success">Net Price</span>
                            <p class="value-text value-text-lg" id="displayItemppMRP"></p>
                        </div>
                    </div>

                    <div class="col-md-2 col-6 mb-3">
                        <div class="info-card card-highlight">
                            <span class="label-text text-success">Total Value</span>
                            <p class="value-text value-text-lg" id="displayItemTotalValue"></p>
                        </div>
                    </div>
                </div>


                <div class="card border-0 shadow-sm mt-3 overflow-hidden rounded-lg">
                    <div class="card-header bg-white border-bottom-0 pt-3">
                        <h6 class="m-0 font-weight-bold text-primary">Price History</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern table-hover mb-0" id="details_table" width="100%">
                            <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th>PO Code</th>
                                    <th>Invoice No</th>
                                    <th>Date of Purchase</th>
                                    <th>Item Price</th>
                                    <th>ReceivedQty</th>
                                    <th>ReceivedQtyAmt</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer bg-white border-top-0">
                <button class="btn btn-light text-secondary font-weight-bold" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" id="brand_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Brand</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <span id="brand_form_message"></span>

                    <!-- Brand Name -->
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Brand Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="brandname" id="brandname" class="form-control" required />
                        </div>
                    </div>

                    <!-- Input Types -->
                    <div class="form-group row">
                        <label class="col-md-4 text-right">Input Type <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <div class="btn-group dropend w-50">
                                <button type="button" class="btn btn-secondary w-100 text-start">
                                    Select Input Types
                                </button>
                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropright</span>
                                </button>
                                <ul class="dropdown-menu w-50" id="brand_inputtypes"></ul>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="brandcreatedby" value="<?php echo $_SESSION['login_user']; ?>">
                    <input type="hidden" name="brandmodifiedby" value="<?php echo $_SESSION['login_user']; ?>">
                    <input type="hidden" name="action" value="Add">

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // ✅ BRAND HANDLER (SINGLE BIND + NO DUPLICATE OPTIONS)
        let isSubmittingBrand = false;

        $('#brandModal').on('show.bs.modal', function () {
            const url = config.developmentPath + "/Admin/Controller/inputTypeController.php";
            $('#brand_inputtypes').empty();

            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#brand_inputtypes').append(
                        `<li class="form-check form-switch px-3">
          <input class="form-check-input me-1" name="inputtype_list[]" value="${value.InputTypeId}" type="checkbox" id="input_${value.InputTypeId}">
          <label class="form-check-label" for="input_${value.InputTypeId}">${value.InputType}</label>
        </li>`
                    );
                });
            });
        });
        // ✅ Add Brand & Return to Item Modal
        // ✅ Add Brand & Return to Item Modal
        $('#brand_form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/brandcontroller.php",
                data: formData,
                processData: false,
                contentType: false,

                success: function (res) {
                    let json;

                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message').html('<div class="alert alert-success">Brand added successfully!</div>');

                        let newBrandId = json.newBrandId || null;

                        setTimeout(function () {
                            $('#brandModal').one('hidden.bs.modal', function () {

                                // AUTO-RELOAD BRAND DROPDOWN
                                reloadBrandList(newBrandId);

                                // REOPEN MATERIAL DETAILS MODAL
                                $('#itemdetailsModal').modal('show');
                            });

                            $('#brandModal').modal('hide');
                            $('#brand_form')[0].reset();

                        }, 600);
                    }

                    else {
                        $('#form_message').html(
                            `<div class='alert alert-danger'>${json.message || "Error while adding brand"}</div>`
                        );
                    }
                },

                error: function (xhr, status, error) {
                    $('#form_message').html(`<div class='alert alert-danger'>AJAX Error: ${error}</div>`);
                }
            });
        });



        function reloadBrandList(selectBrandId = null) {
            const $company = $('#company');
            $company.empty().append('<option hidden disabled selected value>-- select brand --</option>');

            const fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php";
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $company.append(`<option value="${value.brandid}">${value.brandname}</option>`);
                });

                // ✅ Auto-select the newly added brand (if provided)
                if (selectBrandId) {
                    $company.val(selectBrandId);
                }
            });
        }
        function reloadCategoryBrands() {
            $('#checkboxes').empty();

            const InputType = 1;
            const fetchUrl = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;

            $.getJSON(fetchUrl, function (data) {
                $.each(data, function (index, value) {
                    $('#checkboxes').append(
                        `<li class="form-check form-switch px-3">
                    <input class="form-check-input me-1" name="brand_list[]" 
                        value="${value.brandid}" type="checkbox" id="brand_${value.brandid}">
                    <label for="brand_${value.brandid}">${value.brandname}</label>
                </li>`
                    );
                });
            });
        }
        function reloadBrandListSimple() {
            $('#company').empty().append('<option hidden disabled selected value>-- select brand --</option>');
            var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php";
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                });
            });
        }


        // REMOVE these old ones:
        // $('#itemMRP').blur(...)
        // $('#itempu').blur(...)
        // $('#itemsize').blur(...)
        // $('#unitFactor').on('change', ...)

        $('#itemMRP, #itemDiscount, #itemGST, #itempu').on('keyup blur change', function () {
            calculatePriceAndValue();
        });
        var InputType = 1;
        var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + InputType;
        $.getJSON(fetchsubcaturl, function (data) {

            $.each(data, function (index, value) {
                $('#checkboxes').append(
                    $(document.createElement('li')).prop({
                        class: 'form-check form-switch'
                    }).append(
                        $(document.createElement('input')).prop({
                            class: 'form-check-input me-1',
                            id: 'myCheckBox',
                            name: 'brand_list[]',
                            value: value.brandid,
                            type: 'checkbox'
                        })).append(
                            $(document.createElement('label')).prop({
                                for: 'myCheckBox'
                            }).html(value.brandname)
                        ).append(document.createElement('br')));
            });
        });
        /* =========================
           MATERIAL MODAL JS (TOP)
           Namespaced with mat* to avoid collisions
           ========================= */

        // helper to get JSON
        function matGetJSON(url) { return $.getJSON(url); }

        // --- Controller base: use relative paths from your View file ---
        const baseCtrl = "../Controller";

        // URLs (use relative controller paths)
        const matThicknessUrl = baseCtrl + "/thicknessController.php";
        const matRotationUrl = baseCtrl + "/rotationController.php";
        const matCatUrl = baseCtrl + "/material_CategoryController.php";
        const matSubcatBase = baseCtrl + "/material_SubcategoryController.php?catId=";
        const matBrandBase = baseCtrl + "/brandcontroller.php?matcatId=";
        const matUnitsUrl = baseCtrl + "/unitsContoller.php";
        const matUnitFactorBase = baseCtrl + "/unitFactorController.php?unitId=";

        // helper: safe AJAX JSON parse (returns object or throws)
        function parseJsonSafe(res) {
            if (typeof res === "object") return res;
            // detect HTML responses quickly
            const trimmed = (res || "").trim();
            if (trimmed.startsWith("<")) {
                // server returned HTML (likely a full page) — throw with raw response
                const err = new Error("Server returned HTML instead of JSON");
                err.raw = res;
                throw err;
            }
            return JSON.parse(res);
        }

        // safe table reload helper
        function safeReloadTable(tableSelector) {
            try {
                if ($.fn.DataTable && $(tableSelector).length) {
                    const dt = $(tableSelector).DataTable();
                    if (dt && dt.ajax && typeof dt.ajax.reload === "function") {
                        dt.ajax.reload(null, false);
                        return;
                    }
                }
            } catch (e) {
                console.warn("DataTable reload failed, falling back to full reload", e);
            }
            // fallback
            location.reload();
        }

        // ---------- Load thickness & grains ----------
        $.getJSON(matThicknessUrl, function (data) {
            $('#thickness, #editedthickness').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#thickness, #editedthickness').append(`<option value="${v.ThicknessId}">${v.Thickness}</option>`);
            });
        }).fail(function (xhr, status, err) {
            console.error("Failed to load thickness:", status, err);
        });

        $.getJSON(matRotationUrl, function (data) {
            $('#materialGrains, #editedRotation').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialGrains, #editedRotation').append(`<option value="${v.rotationId}">${v.sides}</option>`);
            });
        }).fail(function () { console.error("Failed to load rotation"); });

        // ---------- Categories ----------
        $.getJSON(matCatUrl, function (data) {
            $('#materialCategory, #editedmaterialCategory').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialCategory, #editedmaterialCategory').append(`<option value="${v.materialcatId}">${v.materialCatname}</option>`);
            });
        }).fail(function () { console.error("Failed to load categories"); });

        function matSetSubCategory(selId, catId) {
            const $sel = $(selId);
            $sel.empty().append('<option hidden disabled selected value>-- select an option --</option>');
            if (!catId) return;
            $.getJSON(matSubcatBase + catId, function (data) {
                $.each(data, function (i, v) {
                    $sel.append(`<option value="${v.materialsubcatId}">${v.materialsubcatName}</option>`);
                });
            }).fail(function () { console.error("Failed to load subcategories for cat", catId); });
        }

        function matSetBrand(selId, catId) {
            const $sel = $(selId);
            $sel.empty().append('<option hidden disabled selected value>-- select an option --</option>');
            if (!catId) return;
            $.getJSON(matBrandBase + catId, function (data) {
                $.each(data, function (i, v) {
                    $sel.append(`<option value="${v.brandid}">${v.brandname}</option>`);
                });
            }).fail(function () { console.error("Failed to load brands for cat", catId); });
        }

        $('#materialCategory').on('change', function () {
            $('#materialsubCategory').empty();
            $('#company').empty(); // correct brand dropdown

            matSetSubCategory('#materialsubCategory', this.value);
            matSetBrand('#company', this.value); // FIXED
        });


        $('#editedmaterialCategory').on('change', function () {
            $('#editedsubCategory').empty();
            $('#editedmaterialbrand').empty();
            matSetSubCategory('#editedsubCategory', this.value);
            matSetBrand('#editedmaterialbrand', this.value);
        });

        // ---------- Units & Unit Factors (material) ----------
        $.getJSON(matUnitsUrl, function (data) {
            $('#materialunit').empty().append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (i, v) {
                $('#materialunit').append(`<option value="${v.unitId}">${v.unitName}</option>`);
            });
            if (data.length) matLoadUnitFactor(data[0].unitId);
        }).fail(function () { console.error("Failed to load units"); });

        function matLoadUnitFactor(unitId) {
            $('#materialunitFactor').empty();
            $.getJSON(matUnitFactorBase + unitId, function (data) {
                $('#materialunitFactor').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (i, v) {
                    $('#materialunitFactor').append(`<option value="${v.unitFactorId}">${v.unitFactor}</option>`);
                });
            }).fail(function () { console.error("Failed to load unit factors for", unitId); });
        }

        $('#materialunit').on('change', function () {
            matLoadUnitFactor(this.value);
            matRecalcMaterialPriceAndValue();
        });

        // ---------- Edited units/factors (material edit modal) ----------
        $.getJSON(matUnitsUrl, function (data) {
            $('#editedunit').empty();
            $.each(data, function (i, v) {
                $('#editedunit').append(`<option value="${v.unitId}">${v.unitName}</option>`);
            });
            if (data.length) matLoadEditedUnitFactor(data[0].unitId);
        }).fail(function () { console.error("Failed to load units for edit"); });

        function matLoadEditedUnitFactor(unitId) {
            $('#editedunitFactor').empty();
            $.getJSON(matUnitFactorBase + unitId, function (data) {
                $('#editedunitFactor').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (i, v) {
                    // Use unitFactorId as value, unitFactor as text
                    $('#editedunitFactor').append(`<option value="${v.unitFactorId}">${v.unitFactor}</option>`);
                });
            }).fail(function () { console.error("Failed to load edited unit factors for", unitId); });
        }

        $('#editedunit').on('change', function () {
            matLoadEditedUnitFactor(this.value);
            matCalculateEditedMaterialPriceAndValue();
        });

        // ---------- Calculation logic (material) ----------
        function matRecalcMaterialPriceAndValue() {
            let MRP = parseFloat($('#materialMRP').val()) || 0;
            let Discount = parseFloat($('#materialDiscount').val()) || 0;
            let GST = parseFloat($('#materialGST').val()) || 0;
            let SPU = parseFloat($('#materialSPU').val()) || 0;
            let factor = parseFloat($('#materialunitFactor').find(":selected").text()) || 1; // ✅ read factor text

            let price = MRP * factor; // ✅ NEW CHANGE (MRP × factor)

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100)); // ✅ same GST logic
            }

            let amount = MRP * factor;

            $('#materialAmount').val(amount.toFixed(2));
            $('#materialPrice').val(price.toFixed(2));
            $('#materialTotalValue').val((price * SPU).toFixed(2)); // ✅ same total logic
        }

        // bind event again
        $('#materialMRP, #materialDiscount, #materialGST, #materialSPU, #materialunitFactor')
            .on('keyup blur change', matRecalcMaterialPriceAndValue);

        // Edited calc
        function matCalculateEditedMaterialPriceAndValue() {
            let MRP = parseFloat($('#editedmaterialMRP').val()) || 0;
            let Discount = parseFloat($('#editedmaterialDiscount').val()) || 0;
            let GST = parseFloat($('#editedmaterialGST').val()) || 0;
            let SPU = parseFloat($('#editedmaterialSPU').val()) || 0;
            let factor = parseFloat($('#editedunitFactor').find(":selected").text()) || 1; // ✅ read factor

            let price = MRP * factor; // ✅ NEW CHANGE for edited modal

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100)); // ✅ same GST rule
            }

            let amount = MRP * factor;

            $('#editedmaterialAmount').val((MRP * factor).toFixed(2)); // ✅ amount calc
            $('#editedmaterialPrice').val(price.toFixed(2));
            $('#editedmaterialTotalValue').val((price * SPU).toFixed(2)); // ✅ same final
        }

        // bind edited events
        $('#editedmaterialMRP, #editedmaterialDiscount, #editedmaterialGST, #editedmaterialSPU, #editedunitFactor')
            .on('keyup blur change', matCalculateEditedMaterialPriceAndValue);

        // ---------- Edit modal open handler (material) ----------
        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            debugger; //
            const btn = $(e.relatedTarget); // clicked action button

            $('#materialid').val(btn.data('id'));
            $('#editedmaterialname').val(btn.data('name'));
            $('#editedmaterialdescription').val(btn.data('desc'));

            const catId = btn.data('cat');
            const subcatId = btn.data('subcat');
            const brandId = btn.data('brand');

            const unitId = btn.data('unit');
            const unitFactorId = btn.data('factor');

            const thicknessId = btn.data('thickness');
            const grainsId = btn.data('grains');

            $('#editedmaterialCode').val(btn.data('code'));
            $('#editedmaterialhsncode').val(btn.data('hsn'));
            $('#editedmaterialSPU').val(btn.data('spu'));
            $('#editedmaterialQty').val(btn.data('qty'));
            $('#editedmaterialMRP').val(btn.data('mrp'));
            $('#editedmaterialGST').val(btn.data('gst'));
            $('#editedmaterialDiscount').val(btn.data('discount'));
            $('#editedmaterialPrice').val(btn.data('price'));
            $('#editedmaterialTotalValue').val(btn.data('total'));

            const img = btn.data('image');
            $('#editedPreviewImage').attr("src",
                img ? (baseCtrl + "/../img/materials/" + img) : (baseCtrl + "/../img/default.png")
            );
            $('#existing_image').val(img);


            // Now populate dropdowns
            matPopulateEditedDropdowns({
                catId, subcatId, brandId, unitId, unitFactorId
            }).then(() => {
                $('#editedthickness').val(thicknessId);
                $('#editedRotation').val(grainsId);
            }).catch(err => {
                console.error("Failed populating edited dropdowns:", err);
            });
            setTimeout(() => {
                matCalculateEditedMaterialPriceAndValue();
            }, 300);

        });

        // helpers for edited dropdown population (material)
        function matFillSelect($sel, list, valueKey, textKey, placeholder) {
            $sel.empty();
            if (placeholder) $sel.append(`<option hidden disabled selected value>${placeholder}</option>`);
            list.forEach(v => $sel.append(`<option value="${v[valueKey]}">${v[textKey]}</option>`));
        }

        function matLoadEditedCategories() {
            return $.getJSON(matCatUrl).then(data => {
                matFillSelect($('#editedmaterialCategory'), data, 'materialcatId', 'materialCatname', '-- select --');
                return data;
            });
        }
        function matLoadEditedSubcategories(catId) {
            if (!catId) return Promise.resolve([]);
            return $.getJSON(matSubcatBase + catId).then(data => {
                matFillSelect($('#editedsubCategory'), data, 'materialsubcatId', 'materialsubcatName', '-- select --');
                return data;
            });
        }
        function matLoadEditedBrands(catId) {
            if (!catId) return Promise.resolve([]);
            return $.getJSON(matBrandBase + catId).then(data => {
                matFillSelect($('#editedmaterialbrand'), data, 'brandid', 'brandname', '-- select --');
                return data;
            });
        }
        function matLoadEditedUnits() {
            return $.getJSON(matUnitsUrl).then(data => {
                matFillSelect($('#editedunit'), data, 'unitId', 'unitName', '-- select --');
                return data;
            });
        }

        function matLoadEditedUnitFactors(unitId) {
            if (!unitId) return Promise.resolve([]);
            return $.getJSON(matUnitFactorBase + unitId).then(data => {
                // Use unitFactorId as value, unitFactor as text
                matFillSelect($('#editedunitFactor'), data, 'unitFactorId', 'unitFactor', '-- select --');
                return data;
            });
        }

        function matPopulateEditedDropdowns({ catId, subcatId, brandId, unitId, unitFactorId }) {
            return matLoadEditedCategories()
                .then(() => { if (catId) $('#editedmaterialCategory').val(catId); return $.when(matLoadEditedSubcategories(catId), matLoadEditedBrands(catId)); })
                .then(() => {
                    if (subcatId) $('#editedsubCategory').val(subcatId);
                    if (brandId) $('#editedmaterialbrand').val(brandId);
                    return matLoadEditedUnits();
                })
                .then(() => matLoadEditedUnitFactors(unitId))
                .then(() => {
                    if (unitId) $('#editedunit').val(unitId);
                    if (unitFactorId) $('#editedunitFactor').val(unitFactorId);

                    matCalculateEditedMaterialPriceAndValue();
                });
        }

        // ---------- Material form submit ----------
        $('#itemdetails_form').off('submit').on('submit', function (e) {
            e.preventDefault();

            console.log("Material submit triggered ✔"); // DEBUG

            let formData = new FormData(this);

            $.ajax({
                url: "../Controller/materialController.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",

                beforeSend: function () {
                    $("#submit_button").prop("disabled", true);
                    $("#form_message").html(`<div class="alert alert-info">Saving...</div>`);
                }
            })
                .done(function (res) {
                    console.log("Server JSON ✔", res);

                    if (res.status === "success") {
                        $("#form_message").html(`<div class="alert alert-success">${res.message}</div>`);

                        setTimeout(() => {
                            $("#itemdetailsModal").modal("hide");
                            location.reload();
                        }, 700);
                    } else {
                        $("#form_message").html(`<div class="alert alert-danger">${res.message}</div>`);
                    }
                })
                .fail(function (xhr) {
                    console.error("AJAX FAIL ❌", xhr.responseText);

                    $("#form_message").html(`
                <div class="alert alert-danger">
                    Server Error: Invalid response<br>
                </div>
                <pre>${xhr.responseText}</pre>
            `);
                })
                .always(function () {
                    $("#submit_button").prop("disabled", false);
                });
        });


        // ---------- Edited material submit ----------
        $('#editeditemdetails_form').on('submit', function (e) {
            debugger;
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: baseCtrl + "/materialController.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () { $('#editbutton').prop('disabled', true); $('#edit_form_message').html('<div class="alert alert-info">Saving...</div>'); }
            }).done(function (res) {
                try {
                    debugger;
                    const json = parseJsonSafe(res);
                    if (json.status === "success") {
                        $('#edit_form_message').html('<div class="alert alert-success">' + (json.message || 'Saved') + '</div>');
                        setTimeout(() => {
                            $('#edititemdetailsModal').modal('hide');
                            //safeReloadTable('#item_table');
                        }, 700);
                    } else {
                        $('#edit_form_message').html('<div class="alert alert-danger">' + (json.message || 'Error') + '</div>');
                    }
                } catch (err) {
                    console.error('Unexpected response', err.raw || err, err);
                    $('#edit_form_message').html('<div class="alert alert-danger">Server Error: Invalid response from server.</div>');
                }
                $('#editbutton').prop('disabled', false);
            }).fail(function (xhr, status, error) {
                $('#edit_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                $('#editbutton').prop('disabled', false);
            });
        });

        // ---------- OPTIONAL: reloadMaterialBrandList function ----------
        function reloadMaterialBrandList(selectBrandId = null) {
            const fetchcompany = baseCtrl + "/brandcontroller.php";
            const $sel = $('#materialbrand');
            $sel.empty().append('<option hidden disabled selected value>-- select brand --</option>');
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (i, v) { $sel.append(`<option value="${v.brandid}">${v.brandname}</option>`); });
                if (selectBrandId) $sel.val(selectBrandId);
            }).fail(() => console.error("Failed loading brand list"));
            const $edited = $('#editedmaterialbrand');
            $edited.empty().append('<option hidden disabled selected value>-- select brand --</option>');
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (i, v) { $edited.append(`<option value="${v.brandid}">${v.brandname}</option>`); });
            }).fail(() => console.error("Failed loading brand list for edit"));
        }

        /* =========================
           ITEM MODAL JS (kept after material)
           ========================= */

        // ✅ Load Input Types when Brand Modal opens
        // $('#brandModal').on('show.bs.modal', function () {
        //     const url = baseCtrl + "/inputTypeController.php";
        //     $('#brand_inputtypes').empty();

        //     $.getJSON(url, function (data) {
        //         $.each(data, function (index, value) {
        //             $('#brand_inputtypes').append(
        //                 `<li class="form-check form-switch px-3">
        //     <input class="form-check-input me-1" name="inputtype_list[]" value="${value.InputTypeId}" type="checkbox" id="input_${value.InputTypeId}">
        //     <label class="form-check-label" for="input_${value.InputTypeId}">${value.InputType}</label>
        //   </li>`
        //             );
        //         });
        //     }).fail(() => console.error("Failed loading input types"));
        // });

        // Add Brand & Return to Item Modal
        // $('#brand_form').on('submit', function (e) {
        //     e.preventDefault();
        //     const formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: baseCtrl + "/brandcontroller.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (res) {
        //             try {
        //                 const json = parseJsonSafe(res);
        //                 if (json.status === "success") {
        //                     $('#brand_form_message').html('<div class="alert alert-success">Brand added successfully!</div>');
        //                     setTimeout(() => {
        //                         $('#brandModal').modal('hide');
        //                         $('#brandModal').on('hidden.bs.modal', function () {
        //                             $(this).off('hidden.bs.modal');
        //                             reloadBrandList(json.newBrandId || null);
        //                             $('#itemdetailsModal').modal('show');
        //                         });
        //                         $('#brand_form')[0].reset();
        //                     }, 600);
        //                 } else {
        //                     $('#brand_form_message').html('<div class="alert alert-danger">' + (json.message || 'Error adding brand.') + '</div>');
        //                 }
        //             } catch (err) {
        //                 console.error("Unexpected response:", err.raw || err);
        //                 $('#brand_form_message').html('<div class="alert alert-danger">Server Error.</div>');
        //             }
        //         },
        //         error: function (xhr, status, error) {
        //             $('#brand_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
        //         }
        //     });
        // });

        // function reloadBrandList(selectBrandId = null) {
        //     const $company = $('#company');
        //     $company.empty().append('<option hidden disabled selected value>-- select brand --</option>');
        //     const fetchcompany = baseCtrl + "/brandcontroller.php";
        //     $.getJSON(fetchcompany, function (data) {
        //         $.each(data, function (index, value) {
        //             $company.append(`<option value="${value.brandid}">${value.brandname}</option>`);
        //         });
        //         if (selectBrandId) {
        //             $company.val(selectBrandId);
        //         }
        //     }).fail(() => console.error("Failed to reload brand list"));
        // }

        // Item calculation changes (kept)
        $('#itemMRP, #itemDiscount, #itemGST, #itempu').on('keyup blur change', function () {
            calculatePriceAndValue();
        });

        function calculatePriceAndValue() {
            let MRP = parseFloat($('#itemMRP').val()) || 0;
            let Discount = parseFloat($('#itemDiscount').val()) || 0;
            let GST = parseFloat($('#itemGST').val()) || 0;
            let SPU = parseFloat($('#itempu').val()) || 0;

            let price = 0;

            if (Discount > 0) {
                let discountedPrice = MRP - (MRP * (Discount / 100));
                price = discountedPrice * (1 + (GST / 100));
            } else {
                price = MRP;
            }

            $('#itemPrice').val(price.toFixed(2));
            let totalValue = price * SPU;
            $('#itemTotalValue').val(totalValue.toFixed(2));
        }

        function calculateEditedPriceAndValue() {
            const MRP = parseFloat($('#editeditemMRP').val()) || 0;
            const Discount = parseFloat($('#editeditemDiscount').val()) || 0;
            const GST = parseFloat($('#editeditemGST').val()) || 0;
            const SPU = parseFloat($('#editeditempu').val()) || 0;

            let price = 0;

            if (Discount > 0) {
                let discounted = MRP - (MRP * (Discount / 100));
                price = discounted * (1 + (GST / 100));
            } else {
                price = MRP;
            }

            $('#editeditemPrice').val(price.toFixed(2));
            const totalValue = price * SPU;
            $('#editeditemTotalValue').val(totalValue.toFixed(2));
        }

        $('#editeditemMRP, #editeditemDiscount, #editeditemGST, #editeditempu')
            .on('keyup blur change', calculateEditedPriceAndValue);

        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemid').val(rowid);
        });

        $('#detailsItemModal').on('show.bs.modal', function (e) {

            var matId = $(e.relatedTarget).data('id');

            $.getJSON(baseCtrl + "/materialController.php?matInfoId=" + matId, function (data) {

                if (!data || !data.length) return;

                let m = data[0];

                function safe(v) { return (v === null || v === "" ? "-" : v); }

                $('#displayItemName').text(safe(m.MaterialName));
                $('#displayItemCategory').text(safe(m.CategoryName));
                $('#displayItemSubCategory').text(safe(m.SubCategoryName));
                $('#displayItemDescription').text(safe(m.MaterialDescription));
                $('#displayItemComapny').text(safe(m.BrandName));

                $('#displayItemArticleNo').text(safe(m.MaterialCode));
                $('#displayItemHSNCode').text(safe(m.HSNCode));
                $('#displayItempu').text(safe(m.MaterialSPU));

                $('#displayItemsize').text(safe(m.Qty));

                $('#displayunit').text(safe(m.Unit));
                $('#displayunitFactor').text(safe(m.MaterialUnitFactor));

                $('#displayItemThickness').text(safe(m.Thickness));
                $('#displayItemGrains').text(safe(m.Grains));

                $('#displayItemMRP').text(safe(m.MaterialPPMRP));

                $('#displayItemGST').text(safe(m.MaterialGST) + "%");

                $('#displayItemppMRP').text(safe(m.MaterialCompanyPrice));
                $('#displayItemDiscount').text(
                    safe(m.MaterialDiscount ? m.MaterialDiscount + "%" : "0%")
                );

                $('#displayItemTotalValue').text(
                    safe(parseFloat(m.MaterialTotalValue || 0).toFixed(2))
                );



                // IMAGE
                const img = m.MaterialImage
                    ? ("../img/materials/" + m.MaterialImage)
                    : ("../img/default.png");

                $('#itemImage').attr("src", img);

                // PURCHASE TABLE
                $("#details_table tbody").empty();

                let runningTotal = 0;

                // ✅ Sort by date / id if needed (important)
                data.sort((a, b) => new Date(a.DateofPurchase) - new Date(b.DateofPurchase));

                $.each(data, function (index, r) {

                    let qty = parseFloat(r.ReceivedQty) || 0;
                    let amt = parseFloat(r.ReceivedQtyAmt) || 0;

                    // ✅ DIVIDED VALUE (same as inward modal)
                    let perUnitAmt = qty > 0 ? (amt / qty) : 0;

                    $("#details_table tbody").append(`
<tr>
    <td>${safe(r.SupplierName)}</td>
    <td>${safe(r.POcode)}</td>
    <td>${safe(r.InvoiceNo)}</td>
    <td>${safe(r.DateofPurchase)}</td>
    <td>${safe(r.ItemPrice)}</td>
    <td>${safe(r.ReceivedQty)}</td>
    <td>${perUnitAmt.toFixed(2)}</td>
</tr>
`);

                });

            }).fail(function (xhr, status, err) {
                console.error("Failed to fetch material details:", status, err);
            });

        });

        // units for item modal (kept)
        var uniturl = baseCtrl + "/unitsContoller.php";
        $.getJSON(uniturl, function (data) {
            if (data && data[0]) loadUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
                $('#unit').append('<option hidden disabled selected value>-- select an option --</option>');
                $('#unit').append('<option value="' + value.unitId + '">' + value.unitName + '</option>');
            });
        }).fail(() => console.error("Failed to load units for item modal"));

        function loadUnitFactor(unitId) {
            $('#unitFactor').empty();
            unitFactorurl = baseCtrl + "/unitFactorController.php?unitId=" + unitId;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append('<option hidden disabled selected value>Blank</option>');
                    $('#unitFactor').append('<option value="' + value.unitFactor + '">' + value.unitFactor + '</option>');
                });
            }).fail(() => console.error("Failed to load unit factors for item modal"));
        }

        $('#editeditemdetails_form').on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: baseCtrl + "/item_detailscontroller.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () { $('#editbutton').prop('disabled', true); $('#form_message').html('<div class="alert alert-info">Saving...</div>'); }
            }).done(function (res) {
                try {
                    const json = parseJsonSafe(res);
                    if (json.status === "success") {
                        $('#form_message').html('<div class="alert alert-success">' + json.message + '</div>');
                        setTimeout(() => {
                            try {
                                const modalEl = document.getElementById('edititemdetailsModal');
                                if (window.bootstrap && bootstrap.Modal) {
                                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modalInstance.hide();
                                } else {
                                    $('#edititemdetailsModal').modal('hide');
                                }
                            } catch (e) {
                                $('#edititemdetailsModal').removeClass('show').hide();
                                $('.modal-backdrop').remove();
                                $('body').removeClass('modal-open');
                            }
                            // safeReloadTable('#item_table');
                        }, 800);
                    } else {
                        $('#form_message').html('<div class="alert alert-danger">' + (json.message || 'Error') + '</div>');
                    }
                } catch (e) {
                    console.error("Invalid JSON:", e.raw || e);
                    $('#form_message').html('<div class="alert alert-danger">Unexpected response.</div>');
                }
                $('#editbutton').prop('disabled', false);
            }).fail(function (xhr, status, error) {
                console.error("❌ AJAX Failed:", error);
                $('#form_message').html('<div class="alert alert-danger">Save failed: ' + error + '</div>');
                $('#editbutton').prop('disabled', false);
            });
        });

        // Item categories load
        var url = baseCtrl + "/item_categorycontroller.php";
        let catId = 0;
        $.getJSON(url, function (data) {
            $('#itemCategory').append('<option hidden disabled selected value>-- select an option --</option>');
            $.each(data, function (index, value) {
                $('#itemCategory').append('<option  value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                $('#editeditemCategory').append('<option  value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
            });
        }).fail(() => console.error("Failed to load item categories"));

        function setSubCategory(catId) {
            var fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + catId;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#subCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                    $('#editedsubCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load subcategories for", catId));
        }

        $('#unit').on('change', function () {
            $('#unitFactor').empty();
            unitFactorurl = baseCtrl + "/unitFactorController.php?unitId=" + this.value;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append('<option value="' + value.unitFactor + '">' + value.unitFactor + '</option>');
                });
            }).fail(() => console.error("Failed to load unit factors on unit change"));
        });

        $('#editedunit').on('change', function () {
            $('#editedunitFactor').empty();
            unitFactorurl = baseCtrl + "/unitFactorController.php?unitId=" + this.value;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#editedunitFactor').append('<option value="' + value.unitFactor + '">' + value.unitFactor + '</option>');
                });
            }).fail(() => console.error("Failed to load edited unit factors on change"));
        });

        $('#itemCategory').on('change', function () {
            $('#subCategory').empty();
            $('#company').empty();
            fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + this.value;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    $('#subCategory').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load subcategories for itemCategory"));

            var fetchcompany = baseCtrl + "/brandcontroller.php?categoryId=" + this.value;
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                    $('#editedcompany').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                });
            }).fail(() => console.error("Failed to load companies for category", this.value));
        });

        $('#editeditemCategory').on('change', function () {
            $('#editedsubCategory').empty();
            fetchsubcaturl = baseCtrl + "/item_subcategorycontroller.php?catId=" + this.value;
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    $('#editedsubCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                });
            }).fail(() => console.error("Failed to load edited subcategories for", this.value));

            var fetchcompany = baseCtrl + "/brandcontroller.php?categoryId=" + this.value;
            $.getJSON(fetchcompany, function (data) {
                $.each(data, function (index, value) {
                    $('#company').append('<option hidden disabled selected value>-- select an option --</option>');
                    $('#company').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                    $('#editedcompany').append('<option value="' + value.brandid + '">' + value.brandname + '</option>');
                });
            }).fail(() => console.error("Failed to load edited companies for category", this.value));
        });

        $('#itemsubcatModal').on('show.bs.modal', function (e) {
            $('#additemCategory').empty();
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#additemCategory').append('<option value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                });
            }).fail(() => console.error("Failed to populate additemCategory"));
        });

        // $('#deleteItemModal').on('show.bs.modal', function (e) {
        //     var rowid = $(e.relatedTarget).data('id');
        //     $('#deleteitemid').val(rowid);
        // });

        // $('#deletebutton').click(function () {
        //     $.ajax({
        //         url: baseCtrl + "/item_detailscontroller.php",
        //         method: "POST",
        //         data: { id: $('#deleteitemid').val(), action: 'delete' },
        //         success: function (data) {
        //             $('#message').html(data);
        //             // safeReloadTable('#item_table');
        //             setTimeout(function () { $('#message').html(''); }, 5000);
        //         },
        //         error: function (xhr, status, err) {
        //             console.error("Delete item failed:", status, err);
        //         }
        //     });
        // });

        $('#addMaterialCategoryForm').on('submit', function (event) {
            debugger;
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_CategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {
                        $('#form_message').html('<div class="alert alert-success">Category added successfully!</div>');

                        let newCategoryId = json.newCategoryId || null;

                        setTimeout(() => {

                            $('#itemcatmodal').one('hidden.bs.modal', function () {

                                // 1️⃣ RELOAD CATEGORY LIST
                                $.getJSON(config.developmentPath + "/Admin/Controller/material_CategoryController.php", function (data) {

                                    $('#materialCategory').empty()
                                        .append('<option hidden disabled selected value>-- select category --</option>');

                                    $.each(data, function (i, v) {
                                        $('#materialCategory').append(
                                            `<option value="${v.materialcatId}">${v.materialCatname}</option>`
                                        );
                                    });

                                    // 2️⃣ AUTO SELECT NEW CATEGORY
                                    if (newCategoryId) {
                                        $('#materialCategory').val(newCategoryId).trigger("change");
                                    }
                                });

                                // 3️⃣ REOPEN DETAILS MODAL  
                                $('#itemdetailsModal').modal('show');

                            });

                            $('#itemcatmodal').modal('hide');
                            $('#addMaterialCategoryForm')[0].reset();

                        }, 600);
                    }
                    else {
                        $('#form_message').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding category.'}</div>`
                        );
                    }
                },
                error: function (xhr, status, error) {
                    $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });

        $('#addMaterialSubcatForm').on('submit', function (event) {
            debugger;
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/material_SubcategoryController.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    var json;
                    try {
                        json = (typeof res === "string") ? JSON.parse(res) : res;
                    } catch (e) {

                        $('#form_message_add').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        $('#form_message_add').html(
                            '<div class="alert alert-success">' + (json.message || 'SubCategory added!') + '</div>'
                        );

                        let newSubcatId = json.newSubcatId || null;

                        setTimeout(function () {

                            $('#itemsubcatModal').one('hidden.bs.modal', function () {

                                // 1️⃣ RELOAD SUBCATEGORY LIST
                                const catId = $('#materialCategory').val();

                                $.getJSON(
                                    config.developmentPath + "/Admin/Controller/material_SubcategoryController.php?catId=" + catId,
                                    function (data) {

                                        $('#materialsubCategory').empty()
                                            .append('<option hidden disabled selected value>-- select subcategory --</option>');

                                        $.each(data, function (i, v) {
                                            $('#materialsubCategory').append(
                                                `<option value="${v.materialsubcatId}">${v.materialsubcatName}</option>`
                                            );
                                        });

                                        // 2️⃣ AUTO-SELECT NEW SUBCATEGORY
                                        if (newSubcatId) {
                                            $('#materialsubCategory').val(newSubcatId);
                                        }
                                    }
                                );

                                // 3️⃣ REOPEN MATERIAL DETAILS MODAL
                                $('#itemdetailsModal').modal('show');

                            });

                            $('#itemsubcatModal').modal('hide');
                            $('#addMaterialSubcatForm')[0].reset();

                        }, 600);
                    }
                    else {
                        $('#form_message_add').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding subcategory.'}</div>`
                        );
                    }

                },
                error: function (xhr, status, error) {
                    $('#form_message_add').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });
        $('#itemsubcatModal').on('show.bs.modal', function () {

            $('#materialcatid').empty()
                .append('<option hidden disabled selected value>-- select category --</option>');

            $.getJSON("../Controller/material_CategoryController.php", function (data) {
                $.each(data, function (index, value) {
                    $('#materialcatid').append(
                        `<option value="${value.materialcatId}">${value.materialCatname}</option>`
                    );
                });
            }).fail(function () {
                console.error("Failed to load material categories!");
            });
        });

        function reloadCategoryList() {
            $('#itemCategory').empty();
            $.getJSON(url, function (data) {
                $.each(data, function (index, value) {
                    $('#itemCategory').append('<option value="' + value.itemcatid + '">' + value.itemcatname + '</option>');
                });
            }).fail(() => console.error("Failed to reload category list"));
        }

        function reloadSubCategoryList() {
            var selectedCategory = $('#itemCategory').val();
            fetchcompany = baseCtrl + "/item_compdetailscontroller.php?catId=" + selectedCategory;

            $('#subCategory').empty();
            if (typeof fetchsubcaturl !== 'undefined') {
                $.getJSON(fetchsubcaturl, function (data) {
                    $.each(data, function (index, value) {
                        $('#subCategory').append('<option value="' + value.itemsubcatid + '">' + value.itemsubcatname + '</option>');
                    });
                }).fail(() => console.error("Failed to reload subcategory list"));
            }
        }

        // brand_form submit refresh
        // $('#brand_form').on('submit', function (event) {
        //     event.preventDefault();
        //     var formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: baseCtrl + "/brandcontroller.php",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (res) {
        //             try {
        //                 const json = parseJsonSafe(res);
        //                 if (json.status === "success") {
        //                     $('#brandModal').modal('hide');
        //                     reloadBrandList();
        //                 }
        //             } catch (e) {
        //                 console.log("Unexpected response:", e.raw || e);
        //             }
        //         },
        //         error: function (xhr, status, err) {
        //             console.error("Failed brand_form submit:", status, err);
        //         }
        //     });
        // });

        // initialize DataTable (no ajax source here)
        $('#item_table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        $('#deleteMaterialModal').on('show.bs.modal', function (e) {

            const matId = $(e.relatedTarget).data('id');
            $('#deleteMaterialId').val(matId);

            const $confirmBtn = $(this).find("button[type='submit']");
            const $msg = $(this).find(".modal-body .text-danger");

            // reset
            $confirmBtn.prop("disabled", false);
            $msg.remove();

            $.getJSON(
                "../Controller/materialController.php?checkDelete=1&id=" + matId,
                function (res) {

                    if (res.blocked) {
                        $confirmBtn.prop("disabled", true);
                        $('.modal-body').append(
                            `<p class="text-danger mt-2">${res.message}</p>`
                        );
                    }
                }
            );
        });


        $('#confirmDeleteMaterial').off('click').on('click', function () {

            const $btn = $(this);
            $btn.prop('disabled', true);

            $.ajax({
                url: baseCtrl + "/materialController.php",
                type: "POST",
                data: $('#delete_material_form').serialize(),
                dataType: "json",
                success: function (json) {
                    if (json.status === "success") {
                        alert("Material deleted successfully!");
                        location.reload();
                    } else {
                        alert(json.message || "Delete failed");
                        $btn.prop('disabled', false);
                    }
                },
                error: function () {
                    alert("Server error during delete");
                    $btn.prop('disabled', false);
                }
            });
        });
        const MATERIAL_INPUT_TYPE = 2;

        $.getJSON(
            config.developmentPath + "/Admin/Controller/brandcontroller.php?InputId=" + MATERIAL_INPUT_TYPE,
            function (data) {
                $('#checkboxes').empty();

                $.each(data, function (index, value) {
                    $('#checkboxes').append(`
        <li class="form-check form-switch px-3">
          <input class="form-check-input me-1"
                 name="brand_list[]"
                 value="${value.brandid}"
                 type="checkbox"
                 id="brand_${value.brandid}">
          <label for="brand_${value.brandid}">
            ${value.brandname}
          </label>
        </li>
      `);
                });
            }
        );


    }); // end document ready
</script>