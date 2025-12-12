<?php
include "session.php";
require_once("header.php");
require_once "../dblayer/sliderImageOps.php";
require_once "../model/sliderImageModel.php";
?>
<style>
    .galleria {
        width: 100%;
        height: 600px;
        background: #fff
    }

    .delete-btn {
        z-index: 10;
        position: absolute;
        top: 5%;
        left: 2%;
        width: 40px;
        height: 40px;
    }
</style>

<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Slider Images</h6>
            </div>
            <div class="col" align="right">
                <span data-toggle="modal" data-target="#addDesignModal" data-id=''>
                    <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                </span>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <?php
                $count = 0;
                $isActive = "active";
                $initialValue = 'aria-current="true"';
                error_log("Post ID: " . ($_GET['postId']??'not set'));
                $designList = DBsliderImageFile::readByPostId($_GET['postId']??0);
                foreach ($designList as $design) {
                    echo '<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="' . $count . '" class="' . $isActive . '" ' . $initialValue . ' aria-label="Slide ' . $count . '"></button>';
                    $isActive = "";
                    $count++;
                    $initialValue = "";
                }
                ?>
            </div>

            <div class="carousel-inner">
<?php
$isActive = "active";
$designList = DBsliderImageFile::readByPostId($_GET['postId'] ?? 0);

if (count($designList) > 0) {
    foreach ($designList as $design) {
        echo '<div class="carousel-item ' . $isActive . '" style="position:relative;">';

        // 🔹 Delete Button
        echo '<button type="button"
                    class="btn btn-danger btn-sm delete-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteDesignModal"
                    data-id="' . $design->getImageFileId() . '"
                    style="position:absolute;top:10px;left:10px;z-index:10;">
                    <i class="fas fa-trash"></i>
              </button>';

        // 🔹 Show Image or Video
        if ($design->getFileType() === "image") {
            echo '<img src="../img/Slider/' . $design->getImage() . '" 
                       class="d-block w-100" 
                       alt="' . $design->getImageAlternateText() . '" 
                       style="height:600px">';
        } elseif ($design->getFileType() === "video") {
            if ($design->getVideoUrl()) {
                echo '<div class="ratio ratio-16x9">
                        <iframe src="' . $design->getVideoUrl() . '" 
                                title="' . $design->getImageFileCaption() . '" 
                                allowfullscreen></iframe>
                      </div>';
            } elseif ($design->getVideoFile()) {
                echo '<video class="d-block w-100" controls style="height:600px">
                        <source src="../img/Slider/' . $design->getVideoFile() . '" type="video/mp4">
                      </video>';
            }
        }

        echo '<div class="carousel-caption d-none d-md-block">
                <p>' . $design->getImageFileCaption() . '</p>
              </div>';

        echo '</div>'; // carousel-item

        $isActive = "";
    }
} else {
    echo "<div class='carousel-item active'><p>No images/videos to display</p></div>";
}

?>
</div>

<!-- Add these controls for Previous and Next -->
<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Next</span>
</button>

        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDesignModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" id="DesginFiles_form" enctype="multipart/form-data" action="../controller/sliderImageController.php" class="w-100">
      <div class="modal-content shadow-lg border-0 rounded-3">
        
        <!-- Header -->
        <div class="modal-header bg-gradient text-white" style="background: linear-gradient(135deg, #007bff, #6610f2);">
          <h4 class="modal-title fw-bold d-flex align-items-center">
            <i class="bi bi-images me-2"></i> Slider Media
          </h4>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        
        <!-- Body -->
        <div class="modal-body px-4 py-3">
          <span id="form_message"></span>
          
          <!-- File Type Selection -->
          <div class="mb-3">
            <label for="fileType" class="form-label fw-semibold">File Type</label>
            <select name="fileType" id="fileType" class="form-select" required>
              <option value="image">🖼️ Image</option>
              <option value="video">🎥 Video</option>
            </select>
          </div>

          <!-- Image Upload -->
          <div id="imageUploadField" class="mb-3">
            <label class="form-label fw-semibold">Upload Image</label>
            <input type="file" name="designFilePath" class="form-control" accept="image/*"/>
            <div class="form-text text-muted">Accepted formats: JPG, PNG, WebP</div>
          </div>

          <!-- Video Fields -->
          <div id="videoFields" style="display:none;">
            <div class="mb-3">
              <label class="form-label fw-semibold">Video URL (YouTube/Vimeo)</label>
              <input type="url" name="videoUrl" class="form-control" placeholder="https://youtube.com/..." />
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">OR Upload MP4 File</label>
              <input type="file" name="videoFile" class="form-control" accept="video/mp4"/>
              <div class="form-text text-muted">Only MP4 format supported</div>
            </div>
          </div>

          <!-- <div class="mb-3">
            <label class="form-label fw-semibold">Caption <span class="text-danger">*</span></label>
            <textarea name="designFileDescription" id="designFileDescription" class="form-control" placeholder="Enter caption..." style="text-transform:capitalize" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Alternate Text <span class="text-danger">*</span></label>
            <textarea name="alternateText" id="alternateText" class="form-control" placeholder="Describe the media for accessibility..." style="text-transform:capitalize" required></textarea>
          </div> -->

          <!-- Hidden Fields -->
          <input type="hidden" name="postId" id="postId" value="<?php echo $_GET['postId']??0 ?>" />
          <input type="hidden" name="createdby" id="createdby" value="<?php echo $_SESSION['login_user']; ?>" />
          <input type="hidden" name="modifiedby" id="modifiedby" value="<?php echo $_SESSION['login_user']; ?>" />
        </div>
        
        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-between px-4 py-3">
          <input type="hidden" name="hidden_id" id="hidden_id" />
          <input type="hidden" name="action" id="action" value="Add" />
          <button type="submit" name="submit" id="submit_button" class="btn btn-primary px-4">
            <i class="bi bi-plus-circle me-1"></i> Add
          </button>
          <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
            <i class="bi bi-x-circle mr-1"></i> Close
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteDesignModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteDesignFile_form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Design File</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this file?</p>
                    <input type="hidden" name="designFileId" id="designFileId" value="">
                </div>
                <div class="modal-footer">
                    <input type="submit" id="deletebutton" class="btn btn-danger" value="Confirmed" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require_once("footer.php") ?>

<script>
    $(document).ready(function() {
        // Pass image ID to delete modal
        $('#deleteDesignModal').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#designFileId').val(rowid);
        });

        // Handle delete AJAX
        $('#deleteDesignFile_form').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "../controller/sliderImageController.php",
                method: "POST",
                data: {
                    id: $('#designFileId').val(),
                    action: 'delete'
                },
                success: function(data) {
                    $('#deleteDesignModal').modal('hide');
                    $('#message').html(data);
                    setTimeout(function() {
                        $('#message').html('');
                        location.reload(); // refresh carousel
                    }, 1500);
                }
            });
        });
        $('#fileType').on('change', function() {
            if ($(this).val() === 'image') {
                $('#imageUploadField').show();
                $('#videoFields').hide();
            } else {
                $('#imageUploadField').hide();
                $('#videoFields').show();
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
    const fileType = document.getElementById("fileType");
    const imageUpload = document.getElementById("imageUploadField");
    const videoFields = document.getElementById("videoFields");

    fileType.addEventListener("change", function () {
      if (this.value === "video") {
        imageUpload.style.display = "none";
        videoFields.style.display = "block";
      } else {
        imageUpload.style.display = "block";
        videoFields.style.display = "none";
      }
    });
  });
</script>
