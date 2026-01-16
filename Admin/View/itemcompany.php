<?php 
include('session.php');
include('channelpartnerheader.php');
require_once("../DB Operations/item_compdetailsOps.php");
require_once("../Model/item_companydetailsmodel.php");
?>
<style>
.form-switch .form-check-input {
    margin-left: 0 !important;
}

.form-check .form-check-input {
    margin-left: 0 !important;
    float: none;
}

.form-check-input {
    position: static;
    margin-top: .3em;
    margin-left: 0;
}

fieldset {
    border: 1px solid lightgray !important;
}

legend {
    float: none;
    width: inherit !important;
    max-width: none !important;
    padding: 0;
    margin-bottom: .5rem;
    font-size: 16px;
    line-height: inherit;
}

.accordion-body {
    padding: 0rem 0.25rem;
}

button.accordion-button {
    padding: 7px;
    background-color: lightgrey !important;
    color: #858796 !important;
}
</style>
<h1 class="h3 mb-4 text-gray-800">Channel Partners</h1>
<!-- DataTales Example -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.2rem; font-weight: bolder;">Suppliers List</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle=modal data-target=#itemcompdetailsModal>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="itemcompdetails_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>GSTIN</th>
                        <th style='display:none'>Contact Name</th>
                        <th style='display:none'>Contact #</th>
                        <th style='display:none'>Address</th>
                        <th style='display:none'>Account no</th>
                        <th style='display:none'>Account name</th>
                        <th style='display:none'>Account IFSCcode</th>
                        <th style='display:none'>Account MICR code</th>
                        <th style='display:none'>Description</th>
                        <th style='display:none'>logo</th>
                        <th>Bank Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $itemcompdetailslist = DBitemcompdetails::getallitemcompdetails();
                    foreach ($itemcompdetailslist as $itemcompdetails) {
                        echo "<tr><td>" . $itemcompdetails->get_itemcompname() . "</td>
                        <td>" . $itemcompdetails->get_itemcompgstin() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompcontactname() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompcontactno() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompaddress() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompaccno() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompaccname() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompaccifsc() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompaccmicr() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcompdescription() . "</td>
                        <td style='display:none'>" . $itemcompdetails->get_itemcomplogo() . "</td>
                        <td><div class='accordion' id='accordionExample'>
                        <div class='accordion-item'>
                          <h2 class='accordion-header' id='headingOne'>
                            <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse-" . $itemcompdetails->get_itemcompid() . "' aria-expanded='true' aria-controls='collapseOne'>
                              Bank Details
                            </button>
                          </h2>
                          <div id='collapse-" . $itemcompdetails->get_itemcompid() . "' class='accordion-collapse collapse' aria-labelledby='headingOne' data-bs-parent='#accordionExample'>
                            <div class='accordion-body'>
                            <ul style='margin:0px; list-style:none;padding:0px'>
                            <li>Account Name :". $itemcompdetails->get_itemcompaccname()  . "</li>
                            <li>Account Number : ". $itemcompdetails->get_itemcompaccno() ."</li>
                            <li>IFSC Code :" . $itemcompdetails->get_itemcompaccifsc() . "</li>
                            <li>MICR Code :" . $itemcompdetails->get_itemcompaccmicr() . "</li>
                            </ul>
                            </div>
                          </div>
                        </div>
                        </div>
                        
                     
                      </td>
                        <td>
                        <div class='dropdown'>
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
                            data-target='#edititemcompdetailsModal' 
                            role='button' 
                            data-id='" . $itemcompdetails->get_itemcompid() . "'> 
                            <i class='fas fa-user-edit'></i>
                                Edit Supplier
                           </button>
                           <a class='btn btn-primary dropdown-item' href='supplierContactView.php?id=".$itemcompdetails->get_itemcompid()."' role='button'>
                           <i class='fas fa-phone-alt'></i>
                            Supplier Contact
                            </a>
                           <button class='btn btn-primary dropdown-item'
                            data-toggle='modal' 
                            data-target='#detailsCompanyModal' 
                            role='button' data-id='" . $itemcompdetails->get_itemcompid() . "'> 
                            <i class='fas fa-info-circle'></i>
                               Supplier Info
                            </button>
                           <button class='btn btn-primary dropdown-item'
                           data-toggle='modal' 
                           data-target='#deleteCompanyModal' 
                           name='delete_button' 
                           role='button' data-id='" . $itemcompdetails->get_itemcompid() . "'>
                            <i class='fas fa-trash-alt'></i>
                              Delete Supplier
                          </button>
                        </div>
                    </div>
                </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
<div class="modal fade" id=itemcompdetailsModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemcompdetails_form" enctype="multipart/form-data"
            action="../Controller/item_compdetailscontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <fieldset>
                        <legend>General:</legend>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompname" id="itemcompname" class="form-control"
                                        required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Description <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompdescription" id="itemcompdescription"
                                        class="form-control" required data-parsley-type="integer"
                                        data-parsley-minlength="10" data-parsley-maxlength="250"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">GSTIN <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompgstin" id="itemcompgstin" class="form-control"
                                        maxlength="15" placeholder="22AAAAA0000A0AA"
                                        pattern="^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Address<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <textarea name="itemcompaddress" id="itemcompaddress" class="form-control"
                                        data-parsley-maxlength="150" data-parsley-trigger="keyup"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Upload Logo <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="file" name="itemcomplogo" id="itemcomplogo" class="form-control"
                                        data-parsley-minlength="6" data-parsley-maxlength="16"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Bank Details:</legend>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Account Name<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccname" id="itemcompaccname" class="form-control"
                                        data-parsley-type="text" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Account Number<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccno" id="itemcompaccno" class="form-control"
                                        data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">IFSC Code<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccifsc" id="itemcompaccifsc" class="form-control"
                                        data-parsley-type="email" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">MICR code<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccmicr" id="itemcompaccmicr" class="form-control"
                                        data-parsley-type="email" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcontactname" id="itemcontactname" class="form-control"
                                    data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Contact Number <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcontactno" id="itemcompcontactno" class="form-control"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails CreatedBy <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcreatedby" id="itemcompcreatedby" class="form-control"
                                    required value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails Modified By <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompmodifiedby" id="itemcompmodifiedby"
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
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edititemcompdetailsModal" tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="edititemcompdetails_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Edit Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <fieldset>
                        <legend>General:</legend>
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
                                            data-bs-toggle="dropdown" aria-expanded="false" id="editedBrand">
                                            <span class="visually-hidden">Toggle Dropright</span>
                                        </button>
                                        <ul class="dropdown-menu" id="editedcheckboxes">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompname" id="editeditemcompname" class="form-control"
                                        required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                                <input type="hidden" name="itemcompid" id="itemcompid" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Description <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompdescription" id="editeditemcompdescription"
                                        class="form-control" required data-parsley-type="integer"
                                        data-parsley-minlength="10" data-parsley-maxlength="250"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">GSTIN <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompgstin" id="editeditemcompgstin"
                                        class="form-control" required data-parsley-minlength="6"
                                        data-parsley-maxlength="16" data-parsley-trigger="keyup"
                                        pattern="^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Address<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <textarea type="text" name="itemcompaddress" id="editeditemcompaddress"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Upload Logo</label>
                                <div class="col-md-8">
                                    <input type="file" name="itemcomplogo" id="editeditemcomplogo"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Bank Details:</legend>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-4 text-right">Account Number<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="itemcompaccno" id="editeditemcompaccno"
                                            class="form-control" data-parsley-type="email" data-parsley-maxlength="150"
                                            data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-4 text-right">Account Name<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccname" id="editeditemcompaccname"
                                        class="form-control" data-parsley-type="email" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">IFSC code<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccifsc" id="editeditemcompaccifsc"
                                        class="form-control" data-parsley-type="email" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">MICR code<span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="itemcompaccmicr" id="editeditemcompaccmicr"
                                        class="form-control" data-parsley-type="email" data-parsley-maxlength="150"
                                        data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcompcreatedby" id="editeditemcompcreatedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="hidden" name="itemcompmodifiedby" id="editeditemcompmodifiedby"
                                    class="form-control" required data-parsley-type="integer"
                                    data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup"
                                    value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Contact Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcontactname" id="editeditemcontactname"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Company Contact Number <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcontactno" id="editeditemcontactno"
                                    class="form-control" data-parsley-type="email" data-parsley-maxlength="150"
                                    data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="submit" id="editbutton" class="btn btn-success" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id=deleteCompanyModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog">
        <form method="POST" id="delete_company_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Delete Company</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        Are you sure. Would you like to delete this company record.
                    </p>
                    <input type="hidden" name="itemcompid" id="itemcompid" value="">
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
<div class="modal fade" id=detailsCompanyModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Supplier Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="" alt="..." id="companyLogo" width="200px" height="200px">
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemName">Name</label>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title" id="displayItemName"></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displayItemDescription">Description</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displayItemDescription"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompaddress">Address</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompaddress"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompaccno">Account Number</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompaccno"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompaccname">Account Name</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompaccname"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompaccifsc">IFSC Code</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompaccifsc"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompaccmicr">MICR Code</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompaccmicr"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompgstin">GSTIN</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="displaycompgstin"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="displaycompgstin">Brand</label>
                                    </div>
                                    <div class="col-8">
                                        <p class="card-title" id="mappedBrands"></p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered" id="contact_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
<div class="modal fade" id=addContactModal tabindex=-1 role=dialog aria-hidden=true>
    <div class="modal-dialog modal-lg">
        <form method="post" id="itemcompdetails_form" enctype="multipart/form-data"
            action="../Controller/item_compdetailscontroller.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add Contact</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="contactName" id="contactName" class="form-control" required />
                                <input type="hidden" name="supplierId" id="supplierId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Desgination <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="contactDesignation" id="contactDesignation"
                                    class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Phone<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="phone" id="phone" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="email" name="email" id="email" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails CreatedBy <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompcreatedby" id="itemcompcreatedby" class="form-control"
                                    required value="<?php echo $_SESSION['login_user']; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group visually-hidden">
                        <div class="row">
                            <label class="col-md-4 text-right">Item CompanyDetails Modified By <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="itemcompmodifiedby" id="itemcompmodifiedby"
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
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {
    var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php";
    $.getJSON(fetchsubcaturl, function(data) {
        $.each(data, function(index, value) {
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

    $('#detailsCompanyModal').on('show.bs.modal', function(e) {
        debugger;
        var rowid = $(e.relatedTarget).data('id');
        $("#mappedBrands").find("ul").remove();
        var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?id=" +
            rowid;
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                if (value.isMapped) {
                    $('#mappedBrands').append(
                        $(document.createElement('ul')).prop({
                            class: 'list-group list-group-flush'
                        }).append(
                            $(document.createElement('li')).prop({
                                class: 'list-group-item'
                            })).html(value.brandname).append(
                            document.createElement('br')));
                }
            });
        });
        var contactUrl = config.developmentPath +
            "/Admin/Controller/supplierContactController.php?id=" + rowid;
        debugger;
        $.getJSON(contactUrl, function(data) {
            $("#contact_table").find("tr:gt(0)").remove();
            $.each(data, function(index, value) {
                $('#contact_table tbody').
                append($(document.createElement('tr')).prop({
                    id: value.contactId
                }));

                $('#contact_table tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.contactName
                }));
                $('#contact_table tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.contactDesignation
                }));
                $('#contact_table tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.phone
                }));
                $('#contact_table tr:last').
                append($(document.createElement('td')).prop({
                    innerHTML: value.email
                }));
            });
        });
    });
    $('#addContactModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#supplierId').val(rowid);
    });

    $('#edititemcompdetailsModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $('#itemcompid').val(rowid);
        $('#editedcheckboxes').empty();
        var fetchsubcaturl = config.developmentPath + "/Admin/Controller/brandcontroller.php?id=" + $(
            '#itemcompid').val();
        $.getJSON(fetchsubcaturl, function(data) {
            $.each(data, function(index, value) {
                if (value.isMapped == 0){
                    checked= false;
                }else{
                    checked=true;
                }
                $('#editedcheckboxes').append(
                    $(document.createElement('li')).prop({
                        class: 'form-check form-switch'
                    }).append(
                        $(document.createElement('input')).prop({
                            class: 'form-check-input me-1',
                            id: 'editedmyCheckBox',
                            name: 'brand_list[]',
                            checked:checked,
                            value: value.brandid,
                            type: 'checkbox',
                            checked: value.isMapped ? "checked" : ""

                        })).append(
                        $(document.createElement('label')).prop({
                            for: 'myCheckBox'
                        }).html(value.brandname)
                    ).append(document.createElement('br')));
            });
        });
    });

    var dataTable = $('#itemcompdetails_table').DataTable({});
    var nEditing = null;
    $('#itemcompdetails_table tbody').on('click', 'tr', function() {
        /* Get the row as a parent of the link that was clicked on */
        $('#editeditemcompname').val(this.cells[0].innerHTML);
        $('#displayItemName').text(this.cells[0].innerHTML);
        $('#editeditemcompdescription').val(this.cells[9].innerHTML.replace('&amp;', '&'));
        $('#displayItemDescription').text(this.cells[9].innerHTML.replace('&amp;', '&'));
        $('#editeditemcontactname').val(this.cells[2].innerHTML);
        $('#displaycontactname').text(this.cells[2].innerHTML);
        $('#editeditemcontactno').val(this.cells[3].innerHTML);
        $('#displaycontactno').text(this.cells[3].innerHTML);
        $('#editeditemcompaddress').val(this.cells[4].innerHTML);
        $('#displaycompaddress').text(this.cells[4].innerHTML);
        $('#editeditemcompaccno').val(this.cells[5].innerHTML);
        $('#displaycompaccno').text(this.cells[5].innerHTML);
        $('#editeditemcompaccname').val(this.cells[6].innerHTML);
        $('#displaycompaccname').text(this.cells[6].innerHTML);
        $('#editeditemcompaccifsc').val(this.cells[7].innerHTML);
        $('#displaycompaccifsc').text(this.cells[7].innerHTML);
        $('#editeditemcompaccmicr').val(this.cells[8].innerHTML);
        $('#displaycompaccmicr').text(this.cells[8].innerHTML);
        $('#editeditemcompgstin').val(this.cells[1].innerHTML);
        $('#displaycompgstin').text(this.cells[1].innerHTML);
        $('#companyLogo').attr('src', config.developmentPath +
            "/Admin/img/companylogo/" + this.cells[10].innerHTML)
    });

    $('#edititemcompdetails_form').submit(function(event) {

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: config.developmentPath +
                "/Admin/Controller/item_compdetailscontroller.php/",
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            console.log(data);
        });
        $('#edititemcompdetailsModal').dispose();
        event.preventDefault();
    });

    $('#deleteCompanyModal').on('show.bs.modal', function(e) {

        var rowid = $(e.relatedTarget).data('id');
        $('#itemcompid').val(rowid);
    });
    $('#deletebutton').click(function() {

        $.ajax({
            url: config.developmentPath + "/Admin/Controller/item_compdetailscontroller.php/",
            method: "POST",
            data: {
                id: $('#itemcompid').val(),
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