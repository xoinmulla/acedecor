<?php
include "session.php";
include "header.php";
require_once __DIR__ . "/../dblayer/dbconnection.php";
require_once __DIR__ . "/../dblayer/contentOps.php";

$maincontent = DBcontent::getLatestContent(type: "main");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Content Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
    .card { box-shadow: 0 1px 4px rgba(0,0,0,.1); border-radius: .5rem; }
    .card-header { background: #fff; border-bottom: 1px solid #ddd; }
    .card-body { background: #fff; }
    .btn-circle { border-radius: 50%; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; }
  </style>
</head>

<body>
<div class="container mt-4">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
        <div class="col">
          <h6 class="m-0 font-weight-bold text-primary">Content Management</h6>
        </div>
        <div class="col text-right">
          <?php if ($maincontent): ?>
            <!-- Edit Content Button -->
            <button class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#editModal" title="Edit Content">
              <i class="fas fa-pencil-alt"></i>
            </button>

            <!-- Add Media Button -->
            <button class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#addMediaModal" title="Add Media">
              <i class="fas fa-photo-video"></i>
            </button>
          <?php else: ?>
            <!-- Add Content Button -->
            <button class="btn btn-warning btn-circle btn-sm" data-toggle="modal" data-target="#addModal" title="Add Content">
              <i class="fas fa-plus"></i>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="card-body">
      <?php if ($maincontent): ?>
        <h3><?= htmlspecialchars($maincontent->getTitle()); ?></h3>
        <p><strong>Brief:</strong><br><?= nl2br(htmlspecialchars($maincontent->getBrief())); ?></p>
        <p><strong>Paragraph:</strong><br><?= nl2br(htmlspecialchars($maincontent->getParagraph())); ?></p>

        <?php if ($maincontent->getImage()): ?>
          <img src="../img/<?= htmlspecialchars($maincontent->getImage()); ?>" width="300" class="rounded mb-3" />
        <?php endif; ?>

        <hr>
        <h5 class="mb-3"><i class="fas fa-sliders-h mr-2 text-primary"></i>Slider Media</h5>

        <?php
        $mediaList = DBcontent::getMediaByContent($maincontent->getId());
        if ($mediaList && count($mediaList)):
        ?>
          <div class="row">
            <?php foreach ($mediaList as $m): ?>
              <div class="col-md-4 mb-4">
                <div class="card">
                  <div class="card-body text-center">
                    <?php if ($m['file_type'] === 'image'): ?>
                      <img src="../img/Slider/<?= htmlspecialchars($m['image_file']) ?>" class="img-fluid rounded mb-2" alt="<?= htmlspecialchars($m['alt_text']) ?>">
                    <?php elseif ($m['file_type'] === 'video'): ?>
                      <?php if (!empty($m['video_url'])): ?>
                        <div class="embed-responsive embed-responsive-16by9 mb-2">
                          <iframe class="embed-responsive-item" src="<?= htmlspecialchars($m['video_url']) ?>" allowfullscreen></iframe>
                        </div>
                      <?php elseif (!empty($m['video_file'])): ?>
                        <video class="w-100 mb-2" controls>
                          <source src="../img/Slider/<?= htmlspecialchars($m['video_file']) ?>" type="video/mp4">
                        </video>
                      <?php endif; ?>
                    <?php endif; ?>

                    <?php if (!empty($m['caption'])): ?>
                      <div class="text-muted small"><?= htmlspecialchars($m['caption']) ?></div>
                    <?php endif; ?>

                    <a href="../controller/contentController.php?action=deleteMedia&id=<?= (int)$m['id'] ?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Delete this media?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-muted">No slider media yet.</p>
        <?php endif; ?>

      <?php else: ?>
        <p>No content available.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- ✅ ADD CONTENT MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="../controller/contentController.php" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title">Add Content</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Title</label>
          <input type="text" name="title" class="form-control" required>

          <label>Brief</label>
          <textarea name="brief" class="form-control" required></textarea>

          <label>Paragraph</label>
          <textarea name="paragraph" class="form-control" required></textarea>

          <!-- <label>Image</label>
          <input type="file" name="image" class="form-control"> -->

          <input type="hidden" name="type" value="main">
          <input type="hidden" name="action" value="Add">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ✅ EDIT CONTENT MODAL -->
<?php if ($maincontent): ?>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="../controller/contentController.php" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Content</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <label>Title</label>
          <input type="text" name="title" value="<?= htmlspecialchars($maincontent->getTitle()) ?>" class="form-control" required>

          <label>Brief</label>
          <textarea name="brief" class="form-control" required><?= htmlspecialchars($maincontent->getBrief()) ?></textarea>

          <label>Paragraph</label>
          <textarea name="paragraph" class="form-control" required><?= htmlspecialchars($maincontent->getParagraph()) ?></textarea>

          <!-- <label>Image</label>
          <input type="file" name="image" class="form-control"> -->

          <input type="hidden" name="id" value="<?= (int)$maincontent->getId(); ?>">
          <input type="hidden" name="action" value="Edit">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<!-- ✅ ADD MEDIA MODAL -->
<div class="modal fade" id="addMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" action="../controller/contentController.php" enctype="multipart/form-data" class="w-100">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title"><i class="fas fa-photo-video mr-2"></i>Add Slider Media</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="content_id" value="<?= $maincontent ? (int)$maincontent->getId() : 0; ?>">

          <div class="form-group">
            <label>File Type</label>
            <select name="fileType" id="fileType" class="form-control" required>
              <option value="image">Image</option>
              <option value="video">Video</option>
            </select>
          </div>

          <div id="imageFields" class="form-group">
            <label>Upload Image</label>
            <input type="file" name="media_image" class="form-control" accept="image/*">
          </div>

          <div id="videoFields" class="form-group" style="display:none;">
            <label>Video URL (YouTube/Vimeo)</label>
            <input type="url" name="media_video_url" class="form-control" placeholder="https://youtube.com/...">
            <div class="text-center my-2">— OR —</div>
            <label>Upload MP4</label>
            <input type="file" name="media_video_file" class="form-control" accept="video/mp4">
          </div>

          <div class="form-group">
            <label>Caption (optional)</label>
            <input type="text" name="media_caption" class="form-control">
          </div>

          <div class="form-group">
            <label>Alt Text (optional)</label>
            <input type="text" name="media_alt" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="AddMedia">
          <button type="submit" class="btn btn-info">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $('#fileType').on('change', function() {
    if ($(this).val() === 'video') {
      $('#imageFields').hide();
      $('#videoFields').show();
    } else {
      $('#videoFields').hide();
      $('#imageFields').show();
    }
  });
</script>

<?php include "footer.php"; ?>
</body>
</html>
