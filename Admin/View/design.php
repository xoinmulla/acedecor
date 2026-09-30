<?php
include('session.php');
require_once("designnavigation.php");
require_once "../DB Operations/designFileOps.php";
require_once "../DB Operations/customerOps.php";
require_once "../Model/designfilesModel.php";
require_once "../DB Operations/enq_categoryOps.php";


/**
 * design.php
 * - Sanitizes/validates incoming id
 * - Escapes outputs with htmlspecialchars
 * - Uses Bootstrap 5 data-* attributes
 * - Generates carousel indicators/items safely
 * - Uses unique element IDs
 * - Uses FormData for file upload AJAX
 * - Expects JSON responses from the controller for add/delete
 */

/* --------- sanitize GET id --------- */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo '<div class="alert alert-warning">Invalid customer id.</div>';
    exit;
}

/* --------- load customer (and verify existence) --------- */
$DesignList = DBcustomer::selectcustomerbasedonId($id);
if (!$DesignList) {
    echo '<div class="alert alert-warning">Customer not found.</div>';
    exit;
}

/* --------- ensure a CSRF token exists in session (simple) --------- */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
$csrf_token = $_SESSION['csrf_token'];

?>

<style>
    .galleria {
        width: 100%;
        height: 600px;
        background: #fff;
    }

    .btn-delete {
        position: fixed;
        right: 5%;
        top: 25%;
    }

    .delete-btn {
        z-index: 10;
        position: absolute;
        top: 5%;
        left: 2%;
        width: 32px;
        height: 32px;
        background-color: #ffffff;
        color: black;
    }

    .carousel-item {
        height: 500px;
    }

    .carousel-item img {
        height: 100%;
        object-fit: contain;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<h1 class="h3 mb-4 text-gray-800">Customer Management</h1>
<!-- message placeholder -->
<span id="message"></span>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Design Files</h6>
            </div>
            <div class="col text-end">
                <!-- Bootstrap 5 modal trigger (data-*) -->
                <button type="button" class="btn btn-success btn-circle btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addDesignModal" dataid="<?= $id ?>">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <fieldset class="mt-3">
            <legend>Customer Info :</legend>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-2 text-end">Customer Id : </label>
                    <div class="col-md-2">
                        <p><?= htmlspecialchars($DesignList->getCustomerCode(), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <label class="col-md-2 text-end">Customer Name :</label>
                    <div class="col-md-2">
                        <p><?= htmlspecialchars($DesignList->get_customerName(), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <label class="col-md-2 text-end">Customer Phone :</label>
                    <div class="col-md-2">
                        <p><?= htmlspecialchars($DesignList->get_customerPhone(), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <label class="col-md-2 text-end">Customer Address :</label>
                    <div class="col-md-2">
                        <p><?= htmlspecialchars($DesignList->get_customerAddress(), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>

                    <label class="col-md-2 text-end">Customer Country : </label>
                    <div class="col-md-2">
                        <p><?= htmlspecialchars($DesignList->getCustomerCountry(), ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<?php

// read all design files for this customer
// read all design files for this customer
// read all design files for this customer
$designList = DBdesignFile::readAll($id);

// group by designCategory (string)
$rawDesigns = DBdesignFile::readAll($id);

$grouped = [];  // final data

foreach ($rawDesigns as $catId => $group) {

    if (!isset($group['catName']) || !isset($group['images'])) {
        continue;
    }

    $catName = $group['catName'];

    // Convert images list into simple array
    $imgList = [];

    foreach ($group['images'] as $img) {
        $imgList[] = [
            'id' => $img['id'] ?? 0,
            'path' => $img['path'] ?? '',
            'desc' => $img['desc'] ?? '',
        ];
    }

    $grouped[$catId] = [
        'name' => $catName,
        'images' => $imgList
    ];
}

$groupJsonEscaped = json_encode($grouped);



$designCategories = DBcategory::selectDesignCategories();

?>

<?php if (!empty($grouped)): ?>


    <ul class="nav nav-tabs" id="designTabs">
        <?php $i = 0;
        foreach ($grouped as $catId => $items): ?>
            <li class="nav-item">
                <button class="nav-link <?= ($i == 0 ? 'active' : '') ?>" data-cat="<?= $catId ?>" type="button">

                    <?= htmlspecialchars($items['name']) ?>
                </button>
            </li>
            <?php $i++; endforeach; ?>
    </ul>

    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $firstKey = array_key_first($grouped);
            $images = $grouped[$firstKey]['images'];

            foreach ($images as $index => $img):
                $active = ($index == 0 ? 'active' : '');  // ⭐ REQUIRED
                $desc = htmlspecialchars($img['desc'], ENT_QUOTES, 'UTF-8');
                $path = htmlspecialchars($img['path'], ENT_QUOTES, 'UTF-8');
                $fileId = intval($img['id']);
                ?>
                <div class="carousel-item <?= $active ?>">
                    <h3 class="text-center"><?= $desc ?></h3>
                    <img src="../img/Designs/<?= $path ?>" class="d-block img-fluid mx-auto" alt="<?= $desc ?>">

                    <span class="delete-btn" data-bs-toggle="modal" data-bs-target="#deleteDesignModal"
                        data-id="<?= $fileId ?>">
                        <button type="button" class="btn btn-danger btn-circle">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>


        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

<?php else: ?>
    <div class="alert alert-info">No design files available for this customer.</div>
<?php endif; ?>

<!-- Add Design Modal -->
<div class="modal fade" id="addDesignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="DesginFiles_form" enctype="multipart/form-data"
            action="../Controller/designFileController.php">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Add Design Files</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <span id="form_message"></span>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-end">File Path <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="file" name="designFilePath" id="designFilePath" class="form-control"
                                required />
                            <input type="hidden" name="customerId" id="customerId_add" value="<?= $id ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-end">Description <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <textarea name="designFileDescription" id="designFileDescription" class="form-control"
                                style="text-transform:capitalize" required></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-md-4 col-form-label text-end">Design Category <span
                                class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select name="designCategory" id="designCategory" class="form-control" required>
                                <option value="">-- Select Design Category --</option>
                                <?php foreach ($designCategories as $cat): ?>
                                    <option value="<?= $cat['enq_catid']; ?>">
                                        <?= htmlspecialchars($cat['enq_cat_name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- hidden meta -->
                    <input type="hidden" name="createdby" id="createdby"
                        value="<?= htmlspecialchars($_SESSION['login_user'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="modifiedby" id="modifiedby"
                        value="<?= htmlspecialchars($_SESSION['login_user'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_add_id" id="hidden_add_id" />
                    <input type="hidden" name="action" id="action_add" value="Add" />
                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Design Modal -->
<div class="modal fade" id="deleteDesignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteDesignFile_form">
            <div class="modal-content">
                <div class="modal-header text-white"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px 8px 0 0;">
                    <h4 class="modal-title">Delete Design File</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="lead">Are you sure you want to delete this file?</p>
                    <input type="hidden" name="designFileId" id="designFileId" value="">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="hidden_delete_id" id="hidden_delete_id" />
                    <input type="submit" name="submit_delete" id="deletebutton" class="btn btn-danger"
                        value="Confirm" />
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once("footer.php");
?>

<script>
    $(document).ready(function () {
        // set customerId when Add modal opens
        $('#addDesignModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#customerId_add').val(rowid || '<?= $id ?>');
        });

        // set file id when Delete modal opens
        $('#deleteDesignModal').on('show.bs.modal', function (e) {
            var fileId = $(e.relatedTarget).data('id');
            $('#designFileId').val(fileId);
        });

        /* ---------------- Add form AJAX (file upload) ---------------- */
        $('#DesginFiles_form').on('submit', function (e) {
            e.preventDefault();

            var form = document.getElementById('DesginFiles_form');
            var formData = new FormData(form);

            // ensure action value present
            formData.set('action', 'Add');

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/designFileController.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json', // expect JSON
                success: function (res) {
                    if (res && res.success) {
                        $('#form_message').html('<div class="alert alert-success">' + res.message + '</div>');
                        // close modal and reload to show new item (or update DOM dynamically)
                        setTimeout(function () {
                            location.reload();
                        }, 900);
                    } else {
                        var msg = (res && res.message) ? res.message : 'Add failed.';
                        $('#form_message').html('<div class="alert alert-danger">' + msg + '</div>');
                    }
                },
                error: function (xhr, status, err) {
                    $('#form_message').html('<div class="alert alert-danger">Request failed: ' + err + '</div>');
                }
            });
        });

        /* ---------------- Delete form AJAX ---------------- */
        $('#deleteDesignFile_form').on('submit', function (e) {
            e.preventDefault();
            var id = $('#designFileId').val();
            if (!id) return;

            $.ajax({
                url: config.developmentPath + "/Admin/Controller/designFileController.php",
                method: "POST",
                data: {
                    id: id,
                    action: 'delete',
                    csrf_token: $('input[name="csrf_token"]', '#deleteDesignFile_form').val()
                },
                dataType: 'json', // expect JSON
                success: function (res) {
                    if (res && res.success) {
                        $('#message').html('<div class="alert alert-success">' + res.message + '</div>');
                        // hide modal then refresh or remove DOM node
                        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteDesignModal'));
                        if (deleteModal) deleteModal.hide();
                        setTimeout(function () {
                            location.reload();
                        }, 700);
                    } else {
                        var msg = (res && res.message) ? res.message : 'Delete failed.';
                        $('#message').html('<div class="alert alert-danger">' + msg + '</div>');
                    }
                },
                error: function (xhr, status, err) {
                    $('#message').html('<div class="alert alert-danger">Request failed: ' + err + '</div>');
                }
            });
        });

        // Tabs click -> move carousel
        $(document).on('click', '#designTabs .nav-link', function () {
            let cat = parseInt($(this).data('cat'));
            $('#designTabs .nav-link').removeClass('active');
            $(this).addClass('active');
            renderCarouselForCategory(cat);
        });


        // Carousel slide -> update tab
        $('#carouselExampleDark').on('slid.bs.carousel', function (e) {
            let index = $(e.relatedTarget).index();

            $('.nav-link[dataslide-index]').removeClass('active');
            $('.nav-link[dataslide-index="' + index + '"]').addClass('active');
        });
        const firstTab = $('#designTabs .nav-link').first();
        const firstCat = parseInt(firstTab.data('cat'));
        renderCarouselForCategory(firstCat);
    });
    const groupedDesigns = <?= $groupJsonEscaped ?>;

    function renderCarouselForCategory(catId) {
        catId = parseInt(catId);
        const images = groupedDesigns[catId]?.images || [];

        const carouselEl = document.getElementById("carouselExampleDark");

        // Dispose existing carousel FIRST
        if ($(carouselEl).data('bs.carousel')) {
            $(carouselEl).carousel('dispose');
        }
        // 🔥 FORCE FULL RESET
        carouselEl.innerHTML = `
    <div class="carousel-inner"></div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
`;

        const container = carouselEl.querySelector(".carousel-inner");

        if (images.length === 0) {
            container.innerHTML = `
            <div class="carousel-item active">
                <div class="p-5 text-center">No images for this category.</div>
            </div>`;
        } else {
            let html = "";
            images.forEach((img, idx) => {
                html += `
                <div class="carousel-item ${idx === 0 ? "active" : ""}">
                
                    <h3 class="text-center">${escapeHtml(img.desc)}</h3>
                    
                    <img src="../img/Designs/${encodeURIComponent(img.path)}"
                         class="d-block img-fluid mx-auto"
                         alt="${escapeHtml(img.desc)}">

                    <span class="delete-btn" 
                          data-bs-toggle="modal" 
                          data-bs-target="#deleteDesignModal"
                          data-id="${img.id}">
                        <button type="button" class="btn btn-danger btn-circle">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </span>

                </div>
            `;
            });

            container.innerHTML = html;
        }

        // re-initialize
        $(carouselEl).carousel();
    }



    // on tab click:
    // document.addEventListener('DOMContentLoaded', function () {
    //     const tabButtons = document.querySelectorAll('#designTabs .nav-link');

    //     if (tabButtons.length === 0) return;

    //     // initial render of first tab (keep your existing first draw too)
    //     const firstBtn = tabButtons[0];
    //     const firstCat = firstBtn.dataset.cat || firstBtn.textContent.trim();
    //     renderCarouselForCategory(firstCat);

    //     tabButtons.forEach(btn => {
    //         btn.addEventListener('click', function () {
    //             tabButtons.forEach(b => b.classList.remove('active'));
    //             this.classList.add('active');
    //             const cat = this.dataset.cat || this.textContent.trim();
    //             renderCarouselForCategory(cat);
    //         });
    //     });
    // });
    $('.modal').on('shown.bs.modal', function () {

        var $dialog = $(this).find('.modal-dialog');

        if ($dialog.hasClass("ui-draggable")) {
            $dialog.draggable("destroy");
        }

        var offset = $dialog.offset();

        $dialog.css({
            margin: 0,
            position: "fixed",
            left: offset.left,
            top: offset.top,
            transform: "none"
        });

        $dialog.draggable({
            handle: ".modal-header",
            containment: "window",
            scroll: false
        });

    });

</script>
<script>
    function escapeHtml(text) {
        if (text == null) return "";
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>