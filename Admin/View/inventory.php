<?php
include('session.php');
include('itemListNavigation.php');
require_once("../DB Operations/item_detailsOps.php");
require_once("../DB Operations/item_categoryOps.php");
require_once("../DB Operations/item_subcategoryOps.php");
require_once("../Model/item_detailsmodel.php");
?>
<h1 class="h3 mb-4 text-gray-800">Inventory Management</h1>
<style>
    /* Soft, modern shadows and rounding */
    .modal-content-modern {
        border-radius: 1rem;
        /* 16px */
        border: none;
        overflow: hidden;
    }

    .modal-header-modern {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }

    /* The Image container */
    .product-img-frame {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        padding: 10px;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .product-img-frame img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }

    /* Data Cards */
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

    /* Specific colors for specific cards */
    .card-highlight {
        border-left-color: #1cc88a;
        background-color: #f0fdf4;
    }

    /* Green for money */
    .card-info {
        border-left-color: #36b9cc;
    }

    /* Blue for codes */
    .card-warn {
        border-left-color: #f6c23e;
    }

    /* Yellow for units */

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
        font-size: 1.25rem;
        color: #1cc88a;
    }

    /* Large price text */

    /* Table Polish */
    .table-modern thead th {
        background-color: #eaecf4;
        color: #4e73df;
        font-size: 0.8rem;
        text-transform: uppercase;
        border-top: none;
        border-bottom: none;
    }
</style>

<!-- DataTales Example -->

<span id="message"></span>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bold;">Item List
                </h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#itemdetailsModal>
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
                        <th>Item Name</th>
                        <th>Item Description</th>
                        <th style='display:none'>Category Id</th>
                        <th>Item Category</th>
                        <th style='display:none'>SubCategory Id</th>
                        <th>Item Subcategory</th>
                        <th style='display:none'>Comapny Id</th>
                        <th>Brand</th>
                        <th style='display:none'>HSNCode</th>
                        <th style='display:none'>Article no</th>
                        <th style='display:none'>SPU</th>
                        <th style='display:none'>Size</th>
                        <th style='display:none'>MRP</th>
                        <th style='display:none'>PP MRP</th>
                        <th style='display:none'>GST</th>
                        <th style='display:none'>image</th>

                        <th style='display:none'>unit</th>
                        <th style='display:none'>unitFactor</th>
                        <th style='display:none'>unitId</th>
                        <th style='display:none'>unitFactorId</th>
                        <th style='display:none'>totalMRP</th>
                        <th style='display:none'>Company Discount</th>
                        <th>Price</th>
                        <th>Inwarded Qty</th>
                        <th>Allocated Qty</th>
                        <th>Available Qty</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemdetailslist = DBitemdetails::getallItemdetails();
                    foreach ($itemdetailslist as $itemdetails) {
                        ?>
                        <tr>
                            <td><?= $itemdetails->get_itemname(); ?></td>
                            <td><?= $itemdetails->get_itemdescription(); ?></td>

                            <td style="display:none"><?= $itemdetails->get_itemcatid(); ?></td>
                            <td><?= $itemdetails->get_itemcategoryname(); ?></td>

                            <td style="display:none"><?= $itemdetails->get_itemsubcatid(); ?></td>
                            <td><?= $itemdetails->get_itemsubcategoryname(); ?></td>

                            <td style="display:none"><?= $itemdetails->get_itemcompid(); ?></td>
                            <td><?= $itemdetails->get_itemCompanyname(); ?></td>

                            <td style="display:none"><?= $itemdetails->get_itemhsncode(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemarticleno(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_packingunit(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_size(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_MRP(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_ppMRP(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemGST(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemimage(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemunit(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemunitFactor(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemunitId(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemunitFactorId(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemtotalMRP(); ?></td>
                            <td style="display:none"><?= $itemdetails->get_itemDiscount(); ?></td>

                            <td><?= $itemdetails->get_itemPrice(); ?></td>
                            <td><?= $itemdetails->get_ReceivedQty(); ?></td>
                            <td><?= $itemdetails->get_AllocatedQty(); ?></td>
                            <td><?= $itemdetails->get_AvailableQty(); ?></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                    </button>

                                    <div class="dropdown-menu">
                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#detailsItemModal" data-id="<?= $itemdetails->get_itemid(); ?>">
                                            <i class="fas fa-info-circle"></i> Item Info
                                        </button>

                                        <button class="btn btn-primary dropdown-item" data-toggle="modal"
                                            data-target="#edititemdetailsModal"
                                            data-id="<?= $itemdetails->get_itemid(); ?>">
                                            <i class="fas fa-user-edit"></i> Edit Item
                                        </button>

                                        <?php if ($itemdetails->isUsedAnywhere()) { ?>
                                            <button class="btn btn-secondary dropdown-item" disabled
                                                title="Item is used in Quotation or Purchase Order">
                                                <i class="fas fa-lock"></i> Delete Item
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger dropdown-item" data-toggle="modal"
                                                data-target="#deleteItemModal" data-id="<?= $itemdetails->get_itemid(); ?>">
                                                <i class="fas fa-trash-alt"></i> Delete Item
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<!-- Item Details Modal -->
<div class="modal fade" id=itemdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemdetails_form" enctype="multipart/form-data"
            action="../Controller/item_detailscontroller.php">
            <input type="hidden" name="from_modal" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Item Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemname" id="itemname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="itemcatid" name="itemcatid" value="">
                                <input type="hidden" id="itemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="itemcompid" name="itemcompid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
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
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Category<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="itemCategory" class="form-select" required name="itemCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Subcategory<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="subCategory" class="form-select" required name="subCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="itemdescription" id="itemdescription" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Code <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemarticleNo" id="itemarticleNo" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSNcode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemhsncode" id="itemhsncode" class="form-control"
                                    data-parsley-type="email" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Order Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemOrderNo" id="itemOrderNo" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type='text' name="itemsize" id="itemsize" class="form-control" required
                                    data-parsley-trigger="change" />

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="unit" class="form-select" required name="unit">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">factor <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="unitFactor" class="form-select" required name="unitFactor">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Standard Packing Unit">SPU<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itempu" id="itempu" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemMRP" id="itemMRP" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Goods and Service Tax">GST <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemGST" id="itemGST" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Discount (%)</label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" name="itemDiscount" id="itemDiscount"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount</label>
                            <div class="col-md-8">
                                <input type="text" name="itemAmount" id="itemAmount" class="form-control" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Price <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemPrice" id="itemPrice" class="form-control" required
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total Value <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemTotalValue" id="itemTotalValue" class="form-control"
                                    required readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="itemimage" id="itemimage" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div id="item_form_message"></div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcreatedby" id="itemcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemmodifiedby" id="itemmodifiedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
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
<div class="modal fade " id=edititemdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="editeditemdetails_form" enctype="multipart/form-data" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Item Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemname" id="editeditemname" class="form-control" required
                                    data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                                <input type="hidden" id="itemid" name="itemid" value="">
                                <input type="hidden" id="editeditemcatid" name="itemcatid" value="">
                                <input type="hidden" id="editeditemsubcatid" name="itemsubcatid" value="">
                                <input type="hidden" id="editeditemcompid" name="itemcompid" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Category<span class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="editeditemCategory" class="form-select" required name="itemCategory">

                                </select>

                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemcatModal'><i
                                        class="fas fa-plus-circle"></i> Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Subcategory <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-5">
                                <select id="editedsubCategory" class="form-select" required name="subCategory">

                                </select>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-primary" data-toggle='modal' data-target='#itemsubcatModal'><i
                                        class="fas fa-plus-circle"></i> SubCategory</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Description<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemdescription" id="editeditemdescription"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Brand<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select id="editedcompany" class="form-select" required name="company">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Item Code<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemarticleNo" id="editeditemarticleNo" class="form-control"
                                    required data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">HSNcode <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemhsncode" id="editeditemhsncode" class="form-control"
                                    data-parsley-type="email" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Order Number <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemOrderNo" id="editeditemOrderNo" class="form-control"
                                    required data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Quantity <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type='text' name="itemsize" id="editeditemsize" class="form-control" required
                                    data-parsley-trigger="change" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">unit <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select id="editedunit" class="form-select" required name="unit">

                                </select>
                            </div>
                            <label class="col-md-2 text-right">factor <span class="text-danger">*</span></label>
                            <div class="col-md-2">
                                <select id="editedunitFactor" class="form-select" required name="unitFactor">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Standard Packing Unit">SPU<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itempu" id="editeditempu" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">MRP <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemMRP" id="editeditemMRP" class="form-control" required
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right" title="Goods and Service Tax">GST <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemGST" id="editeditemGST" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Discount (%) <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="number" step="0.01" name="itemDiscount" id="editeditemDiscount"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Amount</label>
                            <div class="col-md-8">
                                <input type="text" name="itemAmount" id="editeditemAmount" class="form-control"
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Price <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemPrice" id="editeditemPrice" class="form-control" required
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Total Value<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemTotalValue" id="editeditemTotalValue" class="form-control"
                                    required readonly />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Upload Item Image <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="itemimage" id="editeditemimage" class="form-control"
                                    data-parsley-minlength="6" data-parsley-maxlength="16"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcreatedby" id="editeditemcreatedby" class="form-control"
                                    required data-parsley-type="integer" data-parsley-minlength="10"
                                    data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemmodifiedby" id="editeditemmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Add success message container here -->
                    <div id="edit-success-message" class="text-center mb-2"></div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteItemModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_item_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this Item.
                    </p>
                    <input type="hidden" name="itemid" id="deleteitemid" value="">
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
                            <label class="col-md-4 text-right">Brand <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="btn-group dropend col-md-12 ">

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
        <form method="POST" id="subCategoryForm" enctype="multipart/form-data">
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
                                <select id="additemCategory" class="form-select" required name="itemcatid">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">SubCategory Name <span
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
                            <label class="col-md-4 text-right">SubCategory Description <span
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
                    <input type="submit" name="submit" id="addSubCategorybtn" class="btn btn-success" value="Add" />
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
                        <i class="fas fa-cube mr-2"></i> Item Information
                    </h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light px-4 py-4">
                <input type="hidden" id="infoitemid" name="infoitemid">

                <div class="row mb-4">
                    <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                        <div class="product-img-frame">
                            <img src="" id="itemImage" alt="Item Preview">
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
                                <div class="col-md-12 mb-2">
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

                <h6 class="text-primary font-weight-bold mb-3 pl-1 text-uppercase small ls-1">Specifications &
                    Financials</h6>
                <div class="row">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text"><i class="fas fa-layer-group mr-1"></i> SPU</span>
                            <p class="value-text" id="displayItempu"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-warn">
                            <span class="label-text"><i class="fas fa-cubes mr-1"></i> Quantity</span>
                            <p class="value-text" id="displayItemsize"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit</span>
                            <p class="value-text" id="displayunit"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">Unit Factor</span>
                            <p class="value-text" id="displayunitFactor"></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">MRP</span>
                            <p class="value-text" id="displayItemMRP"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card">
                            <span class="label-text">GST %</span>
                            <p class="value-text" id="displayItemGST"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-card card-highlight">
                            <span class="label-text text-success">Net Price</span>
                            <p class="value-text value-text-lg" id="displayItemppMRP"></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
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
                        <table class="table table-modern table-hover mb-0" id="details_table" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>PO Code</th>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Price</th>
                                    <th>Rcvd Qty</th>
                                    <th>Received Qty Amt</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-white border-top-0">
                <button type="button" class="btn btn-light text-secondary font-weight-bold"
                    data-dismiss="modal">Close</button>
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
<script>
    $(document).ready(function () {
        if (window.location.hash === '#itemdetailsModal') {
            $('#itemdetailsModal').modal('show');
        }
    });
</script>


<script>
    $(document).ready(function () {

        // ✅ Load Input Types when Brand Modal opens
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
                        // SHOW SUCCESS MESSAGE INSIDE MODAL
                        $('#form_message').html(
                            '<div class="alert alert-success">Brand added successfully!</div>'
                        );

                        // WAIT FOR USER TO READ THE MESSAGE
                        setTimeout(function () {

                            // CLOSE MODAL
                            $('#brandModal').modal('hide');

                            // FIX BACKDROP GHOST BUG
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // RESET FORM
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

        // ✅ For Add Modal
        function calculatePriceAndValue() {

            let MRP = parseFloat($('#itemMRP').val()) || 0;
            let Discount = parseFloat($('#itemDiscount').val()) || 0;
            let GST = parseFloat($('#itemGST').val()) || 0;
            let SPU = parseFloat($('#itempu').val()) || 0;

            // ✅ Read factor from TEXT of selected option (same as material)
            let factor = parseFloat($('#unitFactor').find(":selected").text()) || 1;

            let price = MRP * factor; // ✅ same formula as material calculation

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100)); // same GST logic
            }
            let amount = MRP * factor;

            $('#itemAmount').val(amount.toFixed(2));
            $('#itemPrice').val(price.toFixed(2));
            $('#itemTotalValue').val((price * SPU).toFixed(2));
        }



        // ✅ Trigger auto update for Add modal inputs
        $('#itemMRP, #itemDiscount, #itemGST, #itempu, #unitFactor')
            .on('keyup blur change', calculatePriceAndValue);

        // ✅ Auto update when factor changes explicitly
        $('#unitFactor').on('change', function () {
            calculatePriceAndValue();
        });


        // ✅ For Edit Modal
        function calculateEditedPriceAndValue() {

            let MRP = parseFloat($('#editeditemMRP').val()) || 0;
            let Discount = parseFloat($('#editeditemDiscount').val()) || 0;
            let GST = parseFloat($('#editeditemGST').val()) || 0;
            let SPU = parseFloat($('#editeditempu').val()) || 0;

            // ✅ Read factor from TEXT (not ID)
            let factor = parseFloat($('#editedunitFactor').find(":selected").text()) || 1;

            let price = MRP * factor;

            if (Discount > 0) {
                let discounted = price - (price * (Discount / 100));
                price = discounted * (1 + (GST / 100));
            }
            let amount = MRP * factor;

            $('#editeditemAmount').val(amount.toFixed(2));
            $('#editeditemPrice').val(price.toFixed(2));
            $('#editeditemTotalValue').val((price * SPU).toFixed(2));
        }



        // ✅ Auto trigger for Edit modal inputs
        $('#editeditemMRP, #editeditemDiscount, #editeditemGST, #editeditempu, #editedunitFactor')
            .on('keyup blur change', calculateEditedPriceAndValue);

        // ✅ Auto update when factor dropdown changes
        $('#editedunitFactor').on('change', function () {
            calculateEditedPriceAndValue();
        });

        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#itemid').val(rowid);
        });

        $('#detailsItemModal').on('show.bs.modal', function (e) {

            var rowid = $(e.relatedTarget).data('id');

            let url = config.developmentPath +
                "/Admin/Controller/item_detailscontroller.php?infoitemid=" + rowid;

            $.getJSON(url, function (data) {

                console.log("ITEM JSON:", data);

                if (!data || data.length === 0) return;

                const i = data[0];

                function safe(v) { return (v === null || v === "" || v === undefined) ? "-" : v; }

                // FIXED FIELD NAMES ↓↓↓
                $('#displayItemName').text(safe(i.itemname));
                $('#displayItemCategory').text(safe(i.categoryname));
                $('#displayItemSubCategory').text(safe(i.subcategoryname));
                $('#displayItemDescription').text(safe(i.itemdescription));
                $('#displayItemComapny').text(safe(i.brandname));
                $('#displayItemArticleNo').text(safe(i.itemcode));
                $('#displayItemHSNCode').text(safe(i.hsncode));
                $('#displayItempu').text(safe(i.spu));
                $('#displayItemsize').text(safe(i.qty));
                $('#displayunit').text(safe(i.unitname));
                $('#displayunitFactor').text(safe(i.unitfactor));
                $('#displayItemMRP').text(safe(i.itemMRP));
                $('#displayItemGST').text(safe(i.itemGST) + "%");
                $('#displayItemppMRP').text(safe(i.itemPrice));
                $('#displayItemTotalValue').text(
                    safe(parseFloat(i.itemTotalValue).toFixed(2))
                );


                // IMAGE FIX
                let img = i.itemimage
                    ? config.developmentPath + "/Admin/img/items/" + i.itemimage
                    : config.developmentPath + "/Admin/img/no-image.png";

                $('#itemImage').attr('src', img);

                // PURCHASE TABLE
                // PURCHASE HISTORY TABLE (FIXED)
                $("#details_table tbody").empty();

                let runningTotal = 0;

                // ✅ Sort by date / id if needed (important)
                data.sort((a, b) => new Date(a.DateofPurchase) - new Date(b.DateofPurchase));

                $.each(data, function (index, r) {

                    let perUnitAmt = 0;

                    if (parseFloat(r.ReceivedQty) > 0) {
                        perUnitAmt = (
                            parseFloat(r.ReceivedQtyAmt) /
                            parseFloat(r.ReceivedQty)
                        ).toFixed(2);
                    }

                    $("#details_table tbody").append(`
        <tr>
            <td>${safe(r.SupplierName)}</td>
            <td>${safe(r.POcode)}</td>
            <td>${safe(r.InvoiceNo)}</td>
            <td>${safe(r.DateofPurchase)}</td>
            <td>${safe(r.ItemPrice)}</td>
            <td>${safe(r.ReceivedQty)}</td>
            <td>${safe(perUnitAmt)}</td>
        </tr>
    `);
                });


            });
        });

        // =====================================
        //   ADD ITEM FORM (AJAX SUBMISSION)
        // =====================================
        $('#itemdetails_form').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#item_form_message').html('<div class="alert alert-info">Saving...</div>');
                },
                success: function (res) {

                    let json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        $('#item_form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    // ❌ DUPLICATE ITEM MESSAGE FROM PHP
                    if (json.status === "error") {
                        $('#item_form_message').html(
                            `<div class="alert alert-danger">${json.message}</div>`
                        );
                        return;
                    }

                    // ✔ SUCCESS
                    $('#item_form_message').html(
                        `<div class="alert alert-success">${json.message || "Item added successfully!"}</div>`
                    );

                    setTimeout(() => {
                        $('#itemdetailsModal').modal('hide');
                        location.reload();
                    }, 700);
                },

                error: function (xhr, status, error) {
                    $('#item_form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });
        });



        // $('#iteminfo').click(function() {
        //     debugger;
        //     var rowid = $('#infoitemid').val()

        // });


        var uniturl = config.developmentPath +
            "/Admin/Controller/unitsContoller.php"
        $.getJSON(uniturl, function (data) {
            loadEditedUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
                // APPEND OR INSERT DATA TO SELECT ELEMENT.
                $('#editedunit').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
            });

        });

        function loadEditedUnitFactor(unitId) {

            $('#editedunitFactor').empty();
            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#editedunitFactor').append('<option value="' + value.unitFactorId +
                        '">' + value.unitFactor + '</option>');
                });
            });
        }

        var dataTable = $('#item_table').DataTable({});
        var nEditing = null;

        // $('#item_table tbody').on('click', 'tr', function () {
        //     debugger;
        //     /* Get the row as a parent of the link that was clicked on */

        //     $('#editeditemname').val(this.cells[0].innerHTML.replace('&amp;', '&'));
        //     $('#displayItemName').text(this.cells[0].innerHTML.replace('&amp;', '&'));
        //     $('#editeditemdescription').val(this.cells[1].innerHTML);
        //     $('#displayItemDescription').text(this.cells[1].innerHTML);
        //     $('#editeditemCategory').val(this.cells[2].innerHTML);
        //     $('#displayItemCategory').text(this.cells[3].innerHTML)

        //     $('#displayItemSubCategory').text(this.cells[5].innerHTML)
        //     $('#editedcompany').val(this.cells[6].innerHTML);
        //     $('#displayItemComapny').text(this.cells[7].innerHTML)
        //     $('#editeditemhsncode').val(this.cells[8].innerHTML);
        //     $('#displayItemHSNCode').text(this.cells[8].innerHTML)
        //     $('#editeditemarticleNo').val(this.cells[9].innerHTML);
        //     $('#displayItemArticleNo').text(this.cells[9].innerHTML)
        //     $('#editeditempu').val(this.cells[10].innerHTML);
        //     $('#displayItempu').text(this.cells[10].innerHTML);
        //     $('#editeditemsize').val(this.cells[11].innerHTML);
        //     $('#displayItemsize').text(this.cells[11].innerHTML);
        //     $('#editeditemMRP').val(this.cells[12].innerHTML);
        //     $('#displayItemMRP').text(this.cells[12].innerHTML);
        //     $('#editeditemppMRP').val(this.cells[13].innerHTML);
        //     $('#displayItemppMRP').text(this.cells[13].innerHTML);
        //     $('#editeditemGST').val(this.cells[14].innerHTML);
        //     $('#displayItemGST').text(this.cells[14].innerHTML + '%');
        //     $('#editeditemdescriptionforcust').val(this.cells[16].innerHTML);
        //     $('#displayitemdescriptionforcust').text(this.cells[16].innerHTML);
        //     $('#editedunit').val(this.cells[17].innerHTML);
        //     $('#displayunit').text(this.cells[20].innerHTML);
        //     $('#editedunitFactor').val(this.cells[21].innerHTML);
        //     $('#displayunitFactor').text(this.cells[21].innerHTML);
        //     $('#editedtotalMRP').val(this.cells[19].innerHTML);
        //     $('#displaytotalMRP').text(this.cells[19].innerHTML);
        //     loadEditedUnitFactor(this.cells[17].innerHTML);
        //     $('#editedsubCategory').empty();
        //     $('#itemImage').attr('src', config.developmentPath +
        //         "/Admin/img/items/" + this.cells[15].innerHTML)
        //     var fetchsubcaturl = config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + $(
        //             '#editeditemCategory').val();
        //     var subcatid = this.cells[4].innerHTML;
        //     $.getJSON(fetchsubcaturl, function (data) {
        //         $.each(data, function (index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.

        //             if (value.itemsubcatid == subcatid) {
        //                 $('#editedsubCategory').append('<option selected value="' + value
        //                     .itemsubcatid +
        //                     '">' + value
        //                         .itemsubcatname + '</option>');
        //             } else {
        //                 $('#editedsubCategory').append('<option value="' + value
        //                     .itemsubcatid +
        //                     '">' + value
        //                         .itemsubcatname + '</option>');
        //             }

        //         });
        //     });

        // });
        $('#edititemdetailsModal').on('show.bs.modal', function (e) {
            const $btn = $(e.relatedTarget);     // the Edit button clicked
            const $tr = $btn.closest('tr');      // the table row
            const tds = $tr.find('td');          // all <td> cells inside the row

            // Set hidden item ID
            $('#itemid').val($btn.data('id'));

            // ✅ Basic fields
            $('#editeditemname').val($(tds[0]).text().trim());          // Item Name
            $('#editeditemdescription').val($(tds[1]).text().trim());   // Description
            $('#editeditemarticleNo').val($(tds[9]).text().trim());     // Item Code
            $('#editeditemhsncode').val($(tds[8]).text().trim());       // HSN
            $('#editeditemsize').val($(tds[11]).text().trim());         // Quantity
            $('#editeditempu').val($(tds[10]).text().trim());           // SPU
            $('#editeditemMRP').val($(tds[12]).text().trim());          // MRP
            $('#editeditemGST').val($(tds[14]).text().trim());          // GST

            // ✅ Discount & Price (fixed indexes)
            $('#editeditemDiscount').val($(tds[21]).text().trim());     // Company Discount
            $('#editeditemPrice').val($(tds[22]).text().trim());        // Price
            $('#editeditemAmount').val($(tds[23]).text().trim());



            // ✅ IDs for dropdowns
            const catId = $(tds[2]).text().trim();
            const subcatId = $(tds[4]).text().trim();
            const companyId = $(tds[6]).text().trim();
            const unitId = $(tds[18]).text().trim();
            const unitFactorId = $(tds[19]).text().trim();

            // ✅ Image preview (show placeholder if missing)
            const imgFile = $(tds[15]).text().trim();
            const imagePath = imgFile
                ? config.developmentPath + "/Admin/img/items/" + imgFile
                : config.developmentPath + "/Admin/img/no-image.png";
            $('#itemImage').attr('src', imagePath);

            // ✅ Load dropdowns and recalculate
            populateEditDropdowns({ catId, subcatId, companyId, unitId, unitFactorId })
                .then(() => calculateEditedPriceAndValue());
        });


        function getJSONp(url) { return $.getJSON(url); }
        function fillSelect($sel, list, valueKey, textKey, placeholder) {
            $sel.empty();
            if (placeholder) $sel.append(`<option hidden disabled selected value>${placeholder}</option>`);
            list.forEach(v => $sel.append(`<option value="${v[valueKey]}">${v[textKey]}</option>`));
        }

        function loadCategories() {
            const url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
            return getJSONp(url).then(data => { fillSelect($('#editeditemCategory'), data, 'itemcatid', 'itemcatname', '-- select --'); return data; });
        }
        function loadSubcategories(catId) {
            const url = config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;
            return getJSONp(url).then(data => { fillSelect($('#editedsubCategory'), data, 'itemsubcatid', 'itemsubcatname', '-- select --'); return data; });
        }
        function loadBrands(catId) {
            const url = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + catId;
            return getJSONp(url).then(data => { fillSelect($('#editedcompany'), data, 'brandid', 'brandname', '-- select --'); return data; });
        }
        function loadUnits() {
            const url = config.developmentPath + "/Admin/Controller/unitsContoller.php";
            return getJSONp(url).then(data => { fillSelect($('#editedunit'), data, 'unitId', 'unitName', '-- select --'); return data; });
        }
        function loadUnitFactors(unitId) {
            const url = config.developmentPath + "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;
            return getJSONp(url).then(data => { fillSelect($('#editedunitFactor'), data, 'unitFactorId', 'unitFactor', '-- select --'); return data; });
        }

        // Orchestrator
        function populateEditDropdowns({ catId, subcatId, companyId, unitId, unitFactorId }) {
            return loadCategories()
                .then(() => { $('#editeditemCategory').val(catId); return $.when(loadSubcategories(catId), loadBrands(catId)); })
                .then(() => {
                    if (subcatId) $('#editedsubCategory').val(subcatId);
                    if (companyId) $('#editedcompany').val(companyId);
                    return loadUnits();
                })
                .then(() => loadUnitFactors(unitId))
                .then(() => {
                    if (unitId) $('#editedunit').val(unitId);
                    if (unitFactorId) $('#editedunitFactor').val(unitFactorId);
                });
        }

        var uniturl = config.developmentPath +
            "/Admin/Controller/unitsContoller.php"
        $.getJSON(uniturl, function (data) {
            loadUnitFactor(data[0].unitId);
            $.each(data, function (index, value) {
                $('#unit').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $('#unit').append('<option value="' + value.unitId + '">' + value
                    .unitName + '</option>');
            });

        });

        function loadUnitFactor(unitId) {

            $('#unitFactor').empty();
            $('#unitFactor').append('<option hidden disabled selected value>-- select factor --</option>');

            let unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" + unitId;

            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    $('#unitFactor').append(
                        `<option value="${value.unitFactorId}" data-factor="${value.unitFactor}">
                    ${value.unitFactor}
                </option>`
                    );
                });
            });
        }


        $('#editeditemdetails_form').on('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php/",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#editbutton').prop('disabled', true);
                    $('#form_message').html('<div class="alert alert-info">Saving...</div>');
                }
            })
                .done(function (res) {
                    console.log("🔍 Response:", res);

                    let json;
                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.error("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Unexpected response.</div>');
                        $('#editbutton').prop('disabled', false);
                        return;
                    }

                    if (json.status === "success") {

                        // Show success message in green box inside modal
                        $("#edit-success-message").html(`
        <div class="alert alert-success">
            ${json.message || "Updated Successfully!"}
        </div>
    `);

                        // Wait 1 second → close modal → reload page
                        setTimeout(() => {

                            // Close modal (Bootstrap 4 & 5 compatible)
                            try {
                                const modalEl = document.getElementById("edititemdetailsModal");
                                if (window.bootstrap && bootstrap.Modal) {
                                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    modal.hide();
                                } else {
                                    $("#edititemdetailsModal").modal("hide");
                                }
                            } catch (err) {
                                $("#edititemdetailsModal").removeClass("show").hide();
                                $(".modal-backdrop").remove();
                                $("body").removeClass("modal-open");
                            }

                            // Reload table / page
                            location.reload();

                        }, 1200); // 1.2 seconds delay
                    }



                    $('#editbutton').prop('disabled', false);
                })
                .fail(function (xhr, status, error) {
                    console.error("❌ AJAX Failed:", error);
                    $('#form_message').html('<div class="alert alert-danger">Save failed: ' + error + '</div>');
                    $('#editbutton').prop('disabled', false);
                });
        });




        // var url = config.developmentPath + "/Admin/Controller/item_categorycontroller.php";
        // let catId = 0;
        // $.getJSON(url, function (data) {
        //     $('#itemCategory').append(
        //         '<option hidden disabled selected value>-- select an option --</option>'
        //     );
        //     $.each(data, function (index, value) {

        //         $('#itemCategory').append('<option  value="' + value.itemcatid +
        //             '">' +
        //             value
        //                 .itemcatname + '</option>');
        //         $('#editeditemCategory').append('<option  value="' + value
        //             .itemcatid +
        //             '">' + value
        //                 .itemcatname + '</option>');

        //     });
        // });

        function setSubCategory(catId) {
            var fetchsubcaturl = config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" +
                catId;
            $.getJSON(fetchsubcaturl, function (data) {
                $('#subCategory').append(
                    '<option hidden disabled selected value>-- select an option --</option>');
                $.each(data, function (index, value) {
                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' +
                        value
                            .itemsubcatname + '</option>');
                    $('#editedsubCategory').append('<option value="' + value.itemsubcatid +
                        '">' +
                        value
                            .itemsubcatname + '</option>');
                });
            });
        }


        $('#unit').on('change', function () {
            $('#unitFactor').empty();
            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" + this
                    .value;
            $.getJSON(unitFactorurl, function (data) {

                $.each(data, function (index, value) {

                    $('#unitFactor').append('<option value="' + value.unitFactorId +
                        '">' +
                        value
                            .unitFactor + '</option>');
                });
            });
        });

        $('#editedunit').on('change', function () {
            $('#editedunitFactor').empty();
            unitFactorurl =
                config.developmentPath +
                "/Admin/Controller/unitFactorController.php/?unitId=" + this
                    .value;
            $.getJSON(unitFactorurl, function (data) {
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#editedunitFactor').append(
                        `<option value="${value.unitFactorId}" data-factor="${value.unitFactor}">
        ${value.unitFactor}
     </option>`
                    );

                });
            });
        });

        // $('#itemCategory').on('change', function () {

        //     debugger;
        //     $('#subCategory').empty();
        //     $('#company').empty();
        //     fetchsubcaturl =
        //         config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
        //             .value;
        //     $.getJSON(fetchsubcaturl, function (data) {
        //         $.each(data, function (index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
        //             $('#subCategory').append(
        //                 '<option hidden disabled selected value>-- select an option --</option>'
        //             );
        //             $('#subCategory').append('<option value="' + value.itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //         });
        //     });
        //     var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + this
        //         .value;
        //     $.getJSON(fetchcompany, function (data) {
        //         $.each(data, function (index, value) {
        //             $('#company').append(
        //                 '<option hidden disabled selected value>-- select an option --</option>'
        //             );
        //             $('#company').append('<option value="' + value.brandid + '">' + value
        //                 .brandname + '</option>');
        //             $('#editedcompany').append('<option value="' + value.brandid + '">' + value
        //                 .brandname + '</option>');
        //         });
        //     });
        // });
        // =======================================
        // BRAND → LOAD CATEGORIES
        // =======================================
        $('#company').on('change', function () {

            let brandId = this.value;

            $('#itemCategory').empty();
            $('#subCategory').empty();

            if (!brandId) return;

            let url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php?brandId=" + brandId;

            $.getJSON(url, function (data) {

                $('#itemCategory')
                    .append('<option hidden disabled selected value>-- select category --</option>');

                if (!data || data.length === 0) {
                    alert("No categories mapped to this brand.");
                    return;
                }

                $.each(data, function (index, value) {
                    $('#itemCategory').append(
                        `<option value="${value.itemcatid}">
                    ${value.itemcatname}
                 </option>`
                    );
                });

            });
        });
        // =======================================
        // LOAD BRANDS WHEN ITEM MODAL OPENS
        // =======================================
        $('#itemdetailsModal').on('show.bs.modal', function () {
            reloadBrandListSimple();   // Load all brands first
        });
        // =======================================
        // CATEGORY → LOAD SUBCATEGORY (ADD MODAL)
        // =======================================
        $('#itemCategory').on('change', function () {

            let catId = this.value;

            $('#subCategory').empty();

            if (!catId) return;

            let fetchsubcaturl =
                config.developmentPath +
                "/Admin/Controller/item_subcategorycontroller.php/?catId=" + catId;

            $.getJSON(fetchsubcaturl, function (data) {

                $('#subCategory')
                    .append('<option hidden disabled selected value>-- select subcategory --</option>');

                if (!data || data.length === 0) {
                    alert("No subcategories found.");
                    return;
                }

                $.each(data, function (index, value) {
                    $('#subCategory').append(
                        `<option value="${value.itemsubcatid}">
                    ${value.itemsubcatname}
                 </option>`
                    );
                });

            });
        });

        // $('#editeditemCategory').on('change', function () {
        //     debugger;
        //     $('#editedsubCategory').empty();
        //     fetchsubcaturl =
        //         config.developmentPath +
        //         "/Admin/Controller/item_subcategorycontroller.php/?catId=" + this
        //             .value;

        //     $.getJSON(fetchsubcaturl, function (data) {
        //         $.each(data, function (index, value) {
        //             // APPEND OR INSERT DATA TO SELECT ELEMENT.
        //             $('#editedsubCategory').append('<option value="' + value
        //                 .itemsubcatid +
        //                 '">' +
        //                 value
        //                     .itemsubcatname + '</option>');
        //         });
        //     });
        //     var fetchcompany = config.developmentPath + "/Admin/Controller/brandcontroller.php?categoryId=" + this
        //         .value;
        //     $.getJSON(fetchcompany, function (data) {
        //         $.each(data, function (index, value) {
        //             $('#company').append(
        //                 '<option hidden disabled selected value>-- select an option --</option>'
        //             );
        //             $('#company').append('<option value="' + value.brandid + '">' + value
        //                 .brandname + '</option>');
        //             $('#editedcompany').append('<option value="' + value.brandid + '">' + value
        //                 .brandname + '</option>');
        //         });
        //     });
        // });

        $('#itemsubcatModal').on('show.bs.modal', function () {

            $('#additemCategory').empty();

            const url = config.developmentPath +
                "/Admin/Controller/item_categorycontroller.php";

            $.getJSON(url, function (data) {

                $('#additemCategory')
                    .append('<option hidden disabled selected value>-- select category --</option>');

                $.each(data, function (index, value) {
                    $('#additemCategory').append(
                        `<option value="${value.itemcatid}">
                    ${value.itemcatname}
                 </option>`
                    );
                });

            });
        });

        $('#deleteItemModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#deleteitemid').val(rowid);
        });

        $('#deletebutton').click(function () {
            $.ajax({
                url: config.developmentPath + "/Admin/Controller/item_detailscontroller.php/",
                method: "POST",
                data: {
                    id: $('#deleteitemid').val(),
                    action: 'delete'
                },
                success: function (data) {
                    $('#message').html(data);
                    dataTable.ajax.reload();
                    setTimeout(function () {
                        $('#message').html('');
                    }, 5000);
                }
            });
        });

        $('#addCategoryForm').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_categorycontroller.php/",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    let json;

                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        // ✅ Success Message (same style as brand form)
                        $('#form_message').html(
                            '<div class="alert alert-success">Category added successfully!</div>'
                        );

                        // Small delay to let user read the message
                        setTimeout(() => {
                            // Close modal
                            $('#itemcatModal').modal('hide');

                            // Remove ghost backdrop (Bootstrap bug fix)
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reload categories inside item modal
                            reloadCategoryList(() => {
                                $('#itemCategory').val(json.newCategoryId);
                            });

                            // Reopen the Item Modal
                            setTimeout(() => {
                                $('#itemdetailsModal').modal('show');
                            }, 200);

                            // Reset category form
                            $('#addCategoryForm')[0].reset();

                        }, 600);
                    } else {
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

        $('#subCategoryForm').on('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: config.developmentPath + "/Admin/Controller/item_subcategorycontroller.php",
                data: formData,
                processData: false,
                contentType: false,

                success: function (res) {
                    let json;

                    try {
                        json = typeof res === "string" ? JSON.parse(res) : res;
                    } catch (e) {
                        console.log("Invalid JSON:", res);
                        $('#form_message').html('<div class="alert alert-danger">Invalid server response.</div>');
                        return;
                    }

                    if (json.status === "success") {

                        // SUCCESS MESSAGE
                        $('#form_message').html(
                            '<div class="alert alert-success">SubCategory added successfully!</div>'
                        );

                        setTimeout(() => {
                            // Close modal
                            $('#itemsubcatModal').modal('hide');

                            // Remove backdrop
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');

                            // Reset form fields
                            $('#user_form')[0].reset();

                            // Reload table (if required)
                            // dataTable.ajax.reload();

                        }, 600);

                    } else {
                        $('#form_message').html(
                            `<div class="alert alert-danger">${json.message || 'Error adding subcategory.'}</div>`
                        );
                    }
                },

                error: function (xhr, status, error) {
                    $('#form_message').html('<div class="alert alert-danger">AJAX Error: ' + error + '</div>');
                }
            });

        });


        // $('#subCategoryForm').submit(function (event) {
        //     var formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: config.developmentPath +
        //             "/Admin/Controller/item_subcategorycontroller.php/",
        //         data: formData,
        //         processData: false,
        //         contentType: false
        //     }).done(function (data) {
        //         console.log(data);
        //     });
        //     reloadSubCategoryList();
        //     $('#itemsubcatModal').hide();
        // });

        function reloadCategoryList(callback = null) {
            $('#itemCategory').empty();

            $.getJSON(config.developmentPath + "/Admin/Controller/item_categorycontroller.php", function (data) {
                $('#itemCategory').append('<option hidden disabled selected value>-- select an option --</option>');

                $.each(data, function (index, value) {
                    $('#itemCategory').append(`<option value="${value.itemcatid}">${value.itemcatname}</option>`);
                });

                if (callback) callback();
            });
        }


        function reloadSubCategoryList() {
            var selectedCategory = $('#itemCategory').val();
            fetchcompany = config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/?catId=" + selectedCategory;

            $('#subCategory').empty();
            $.getJSON(fetchsubcaturl, function (data) {
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.

                    $('#subCategory').append('<option value="' + value.itemsubcatid + '">' +
                        value.itemsubcatname + '</option>');
                });
            });
        }
        // ✅ Refresh Brand Dropdown after adding new brand
        // $('#brand_form').on('submit', function (event) {
        //     event.preventDefault();
        //     var formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: config.developmentPath + "/Admin/Controller/brandcontroller.php/",
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function (res) {
        //             try {
        //                 const json = typeof res === "string" ? JSON.parse(res) : res;
        //                 if (json.status === "success") {
        //                     // Hide modal
        //                     $('#brandModal').modal('hide');

        //                     // Refresh Brand list
        //                     reloadBrandList();
        //                 }
        //             } catch (e) {
        //                 console.log("Unexpected response:", res);
        //             }
        //         }
        //     });
        // });

        // ✅ Function to reload brand list
        function reloadBrandListSimple() {

            const InputType = 1;   // 🔥 Confirm: 1 = Item in your inputtype table

            $('#company')
                .empty()
                .append('<option hidden disabled selected value>-- select brand --</option>');

            const fetchcompany =
                config.developmentPath +
                "/Admin/Controller/brandcontroller.php?InputId=" + InputType;

            $.getJSON(fetchcompany, function (data) {

                if (!data || data.length === 0) {
                    alert("No brands mapped to Item.");
                    return;
                }

                $.each(data, function (index, value) {
                    $('#company').append(
                        `<option value="${value.brandid}">
                    ${value.brandname}
                </option>`
                    );
                });
            });
        }



    });
</script>