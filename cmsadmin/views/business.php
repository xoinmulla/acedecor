<?php
include "session.php";
include "header.php";
include "../dblayer/dbconnection.php";
require_once "../dblayer/businessOps.php";
require_once "../dblayer/socialMediaHandleOps.php";
?>
<!-- Outer Row -->
<html>

<body>
    <style type="text/css">
        body {
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        img {
            width: 100%;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        <?php
        $business = DBbusiness::getBusinessDetails();
        ?>
    </style>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Business Info</h6>
                </div>
                <div class="col" align="right">
                    <span data-toggle=modal data-target=#addModal>
                        <button type="button" + class="btn btn-warning btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                    </span>
                    <span data-toggle=modal data-target=#editModal>
                        <button type="button" + class="btn btn-success btn-circle btn-sm"><i class="fas fa-pencil-alt"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="../img/<?php echo htmlspecialchars($business->getBusinessLogoImage() ?? ''); ?>" alt="Admin" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4><?php echo htmlspecialchars($business->getBusinessName() ?? ''); ?></h4>
                                        <p class="text-secondary mb-1"><?php echo htmlspecialchars($business->getBusinessTag() ?? ''); ?></p>
                                        <p class="text-muted font-size-sm"><?php echo htmlspecialchars($business->getBusinessAddress() ?? ''); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Social Handles</h6>
                                    <span data-toggle=modal data-target=#addSocialMediaModal>
                                        <button type="button" + class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-plus"></i></button>
                                    </span>
                                </li>
                                <?php
                                $socialMediaHandles = DBsocialMediaHandle::read();
                                foreach ($socialMediaHandles as $handle) {
                                    echo '<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><a href="' . htmlspecialchars($handle->getHandle() ?? '') . '">' . $handle->getIcon() . ' ' . htmlspecialchars($handle->getname() ?? '') . '</a></h6>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" + class="btn btn-danger btn-circle btn-sm" data-toggle=modal data-target=#deleteSocialMediaModal data-id="' . htmlspecialchars($handle->getId() ?? '') . '">
                                        <i class="fas fa-trash-alt"></i></button>
                                        </div>
                                </li>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessName() ?? ''); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessEmail() ?? ''); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mobile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessContact() ?? ''); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Alternate Mobile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessContact2() ?? ''); ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessAddress() ?? ''); ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">GSTIN</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getBusinessGSTIN() ?? ''); ?>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">About Header</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getAboutHeader() ?? ''); ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">About Title</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getAboutSubheading() ?? ''); ?>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">About SubTitle</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo htmlspecialchars($business->getAboutTitle() ?? ''); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Existing About Business Section -->
<div class="row gutters-sm">
    <div class="col-sm-12 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">About</h5>
                <?php echo $business->getBusinessAboutBusiness() ?>
            </div>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>

        <!-- 🔥 New Business About Media Slider Section (Full-width, below everything) -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">About Page Slider Media</h6>
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#addMediaModal">
                    <i class="fas fa-plus"></i> Add Media
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    $mediaItems = DBbusiness::getBusinessMedia($business->getBusinessId());
                    if (count($mediaItems) > 0) {
                        foreach ($mediaItems as $m) {
                            echo '<div class="col-md-4 mb-3">';
                            if ($m['mediaType'] === 'image') {
                                echo '<img src="../img/Slider/' . htmlspecialchars($m['fileName'] ?? '') . '" class="img-fluid rounded">';
                            } elseif ($m['mediaType'] === 'video' && !empty($m['videoUrl'])) {
                                echo '<iframe width="100%" height="200" src="' . htmlspecialchars($m['videoUrl'] ?? '') . '" frameborder="0" allowfullscreen></iframe>';
                            } else {
                                echo '<video width="100%" controls><source src="../img/Slider/' . htmlspecialchars($m['fileName'] ?? '') . '" type="video/mp4"></video>';
                            }
                            echo '<p class="mt-2">' . htmlspecialchars($m['caption'] ?? '') . '</p>';
                            echo '<a href="../controller/businessInfoController.php?deleteMediaId=' . htmlspecialchars($m['id'] ?? '') . '" class="btn btn-sm btn-danger">Delete</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No media added yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal to Add Media -->
        <div class="modal fade" id="addMediaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="../controller/businessInfoController.php" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Slider Media</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="businessId" value="<?php echo htmlspecialchars($business->getBusinessId() ?? ''); ?>">
                            <div class="form-group">
                                <label>Media Type</label>
                                <select name="mediaType" id="mediaType" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="image">Image</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>

                            <div class="form-group media-file d-none">
                                <label>Upload File (optional for video)</label>
                                <input type="file" name="mediaFile" class="form-control">
                            </div>

                            <div class="form-group video-url d-none">
                                <label>Video URL (YouTube, Vimeo, etc.)</label>
                                <input type="text" name="videoUrl" class="form-control">
                            </div>

                            <!-- <div class="form-group">
                                <label>Caption</label>
                                <input type="text" name="caption" class="form-control">
                            </div> -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="action" value="AddMedia" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id=addModal tabindex=-1 role=dialog aria-hidden=true>
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Business Info</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="POST" action="../controller/businessInfoController.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="companyname" id="companyname" class="form-control" required />
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="companyaddress" id="companyaddress" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="text" name="companycontact" id="companycontact" class="form-control" required />
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Business Tag Line</label>
                                    <input type="text" name="companytag" id="companytag" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" name="companyemail" id="companyemail" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GSTIN</label>
                                    <input type="text" name="companyGSTIN" id="companyGSTIN" class="form-control" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Business Logo</label>
                                    <input type="file" name="logoImage" id="logoImage" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label>About Header</label>
                                    <input type="text" name="aboutHeader" id="aboutHeader" class="form-control" value="<?php echo htmlspecialchars($business->getAboutHeader() ?? ''); ?>" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>About Subheading</label>
                                    <input type="text" name="aboutSubheading" id="aboutSubheading" class="form-control" value="<?php echo htmlspecialchars($business->getAboutSubheading() ?? ''); ?>" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>About Title</label>
                                    <input type="text" name="aboutTitle" id="aboutTitle" class="form-control" value="<?php echo htmlspecialchars($business->getAboutTitle() ?? ''); ?>" />
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label>About Image</label>
                                    <input type="file" name="aboutImage" id="aboutImage" class="form-control" />
                                    <?php if($business->getAboutImage()) { ?>
                                        <img src="../../img/<?php echo htmlspecialchars($business->getAboutImage() ?? ''); ?>" width="120" style="margin-top:10px;">
                                    <?php } ?>
                                </div>
                            </div> -->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>About Business</label>
                                    <div id="editor-container"></div>
                                    <input type="text" name="hidden_element" id="hidden_element" hidden />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="submit" name="register_button" id="register_button" class="btn btn-primary btn-user">Set Up</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id=addSocialMediaModal tabindex=-1 role=dialog aria-hidden=true>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Social Media Handles</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="../controller/socialMediaHandleController.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <select class="form-select" name="name" id="name" required>
                                            <option value="https://www.facebook.com/">Facebook</option>
                                            <option value="https://www.twitter.com/">Twitter</option>
                                            <option value="https://www.instagram.com/">Instagram</option>
                                            <option value="https://www.pinterest.com/">Pintrest</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Handle</label>
                                    <input type="text" name="handle" id="handle" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="createdby" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['login_user'] ?? ''); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['login_user'] ?? ''); ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="submit" name="register_button" id="register_button" class="btn btn-primary btn-user">Set Up</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id=editSocialMediaModal tabindex=-1 role=dialog aria-hidden=true>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Social Media Handles</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="../controller/socialMediaHandleController.php" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <select class="form-select" name="name" id="name" required>
                                            <option value="https://www.facebook.com/">Facebook</option>
                                            <option value="https://www.twitter.com/">Twitter</option>
                                            <option value="https://www.instagram.com/">Instagram</option>
                                            <option value="https://www.pininterest.com/">Pinintrest</option>
                                            <option value="https://www.linkedin.com/">Linked In</option>
                                            <option value="https://www.google.com/">Google My Business</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Handle</label>
                                    <input type="text" name="handle" id="handle" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="createdby" id="createdby" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['login_user'] ?? ''); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" name="modifiedby" id="modifiedby" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['login_user'] ?? ''); ?>" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="submit" name="register_button" id="register_button" class="btn btn-primary btn-user">Set Up</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id=editModal tabindex=-1 role=dialog aria-hidden=true>
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form method="POST" action="../controller/businessInfoController.php" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Business Info</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="companyname" id="editedcompanyname" class="form-control" required value="<?php echo htmlspecialchars($business->getBusinessName() ?? ''); ?>" />
                                        <input type="text" name="companyId" id="editedcompanyId" class="form-control" hidden value="<?php echo htmlspecialchars($business->getBusinessId() ?? ''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="companyaddress" id="editedcompanyaddress" class="form-control"><?php echo htmlspecialchars($business->getBusinessAddress() ?? ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input type="text" name="companycontact" id="editedcompanycontact"
                                               class="form-control" required pattern="^\d{10}$"
                                               value="<?php echo htmlspecialchars($business->getBusinessContact() ?? ''); ?>" />
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alternate Contact No.</label>
                                        <input type="text" name="companycontact2" id="editedcompanycontact2"
                                               class="form-control" required pattern="^\d{10}$"
                                               value="<?php echo htmlspecialchars($business->getBusinessContact2() ?? ''); ?>" />
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Tag Line</label>
                                        <input type="text" name="companytag" id="editedcompanytag" class="form-control" required value="<?php echo htmlspecialchars($business->getBusinessTag() ?? ''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" name="companyemail" id="editedcompanyemail" class="form-control" required value="<?php echo htmlspecialchars($business->getBusinessEmail() ?? ''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>GSTIN</label>
                                        <input type="text" name="companyGSTIN" id="editedcompanyGSTIN" class="form-control" value="<?php echo htmlspecialchars($business->getBusinessGSTIN() ?? ''); ?>" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Logo</label>
                                        <input type="file" name="logoImage" id="editedlogoImage" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                        <label>About Header</label>
                                        <input type="text" name="aboutHeader" id="aboutHeader" class="form-control" value="<?php echo htmlspecialchars($business->getAboutHeader() ?? ''); ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>About Subheading</label>
                                        <input type="text" name="aboutSubheading" id="aboutSubheading" class="form-control" value="<?php echo htmlspecialchars($business->getAboutSubheading() ?? ''); ?>" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>About Title</label>
                                        <input type="text" name="aboutTitle" id="aboutTitle" class="form-control" value="<?php echo htmlspecialchars($business->getAboutTitle() ?? ''); ?>" />
                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>About Image</label>
                                        <input type="file" name="aboutImage" id="aboutImage" class="form-control" />
                                        <?php if($business->getAboutImage()) { ?>
                                            <img src="../img/<?php echo htmlspecialchars($business->getAboutImage() ?? ''); ?>" width="120" style="margin-top:10px;">
                                        <?php } ?>
                                    </div>
                                </div> -->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>About Business</label>

                                        <div id="editededitor-container">
                                            <?php echo $business->getBusinessAboutBusiness() ?>
                                        </div>
                                        <input type="text" name="hidden_element" id="editedhidden_element" hidden />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        </br>
                        </br>
                        <div class="modal-footer">
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="action" id="action" value="Add" />
                            <button type="submit" name="register_button" id="register_button" class="btn btn-primary btn-user">Set Up</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id=deleteSocialMediaModal tabindex=-1 role=dialog aria-hidden=true>
            <div class="modal-dialog">
                <form method="POST" id="delete_category_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal_title">Delete</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p class="lead">
                                Are you sure. Would you like to delete.
                            </p>
                            <input type="hidden" name="socialMediaId" id="socialMediaId" value="">
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
        </br>
        <?php include('footer.php'); ?>
        <script>
            $(document).ready(function() {
                $("#companybranches").change(function() {
                    if (parseInt($(this).val()) > 0) {
                        $("#branch").show();
                        $("#branchaddress").show();
                    }
                });
                var toolbarOptions = [
                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }], // custom button values
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }], // superscript/subscript
                    [{ 'indent': '-1' }, { 'indent': '+1' }], // outdent/indent
                    [{ 'direction': 'rtl' }], // text direction

                    [{ 'size': ['small', false, 'large', 'huge'] }], // custom dropdown
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }], // dropdown with defaults from theme
                    [{ 'font': [] }],
                    [{ 'align': [] }],

                    ['clean'] // remove formatting button
                ];
                var quill = new Quill('#editor-container', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow'
                });

                var editedquill = new Quill('#editededitor-container', {
                    modules: {
                        toolbar: toolbarOptions
                    },
                    placeholder: 'Compose an epic...',
                    theme: 'snow'
                });
                $('#deleteSocialMediaModal').on('show.bs.modal', function(e) {
                    var rowid = $(e.relatedTarget).data('id');
                    $('#socialMediaId').val(rowid);
                });
                $('form').submit(function() {
                    $('#hidden_element').val(JSON.stringify(quill.getContents()));
                    $('#editedhidden_element').val(JSON.stringify(editedquill.getContents()));
                    return true;
                });
                $('#deletebutton').click(function() {
                    
                    $.ajax({
                        url: config.developmentPath + "/cmsadmin/controller/socialMediaHandleController.php",
                        method: "POST",
                        data: {
                            id: $('#socialMediaId').val(),
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

            // Toggle for AddMedia modal fields
            $('#mediaType').on('change', function() {
                const type = $(this).val();
                $('.media-file, .video-url').addClass('d-none');
                if (type === 'image') $('.media-file').removeClass('d-none');
                if (type === 'video') $('.media-file, .video-url').removeClass('d-none');
            });
        </script>
    </body>

</html>
