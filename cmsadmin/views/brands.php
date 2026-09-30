<?php
include "session.php";
include "header.php";

require_once "../dblayer/brandOps.php";
require_once "../dblayer/brandSectionOps.php";

$brands = DBbrand::getAll();
$section = DBbrandSection::get();
?>
<style>
    /* CARD */
    .brand-card-admin {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .brand-card-admin:hover {
        transform: translateY(-5px);
    }

    /* IMAGE BOX */
    .brand-img-box {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* IMAGE */
    .brand-img-box img {
        max-width: 100%;
        max-height: 70px;
        object-fit: contain;
    }
</style>
<div class="container mt-4">

    <!-- SECTION -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h5>Brand Section</h5>
            <button class="btn btn-success" data-toggle="modal" data-target="#sectionModal">Edit</button>
        </div>

        <div class="card-body">
            <h4>
                <?= $section ? $section->getHeading() : "No Heading"; ?>
            </h4>
            <p>
                <?= $section ? $section->getParagraph() : "No Paragraph"; ?>
            </p>
        </div>
    </div>

    <!-- BRANDS -->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Brands</h5>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addBrand">Add Brand</button>
        </div>

        <div class="card-body">
            <div class="row">
                <?php foreach ($brands as $b): ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-4">
                        <div class="brand-card-admin text-center p-3">

                            <div class="brand-img-box">
                                <img src="/acedecor/cmsadmin/img/brands/<?= htmlspecialchars($b->getImage(), ENT_QUOTES, 'UTF-8'); ?>" alt="">
                            </div>

                            <h6 class="mt-3"><?= $b->getName(); ?></h6>

                            <a href="../controller/brandController.php?delete=<?= $b->getId(); ?>"
                                class="btn btn-danger btn-sm mt-2">Delete</a>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<!-- SECTION MODAL -->
<div class="modal fade" id="sectionModal">
    <div class="modal-dialog">
        <form method="POST" action="../controller/brandSectionController.php">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5>Edit Section</h5>
                </div>

                <div class="modal-body">
                    <label>Heading</label>
                    <input type="text" name="heading" class="form-control"
                        value="<?= $section ? $section->getHeading() : ""; ?>">

                    <label>Paragraph</label>
                    <textarea name="paragraph"
                        class="form-control"><?= $section ? $section->getParagraph() : ""; ?></textarea>

                    <input type="hidden" name="action" value="Save">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ADD BRAND MODAL -->
<div class="modal fade" id="addBrand">
    <div class="modal-dialog">
        <form method="POST" action="../controller/brandController.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5>Add Brand</h5>
                </div>

                <div class="modal-body">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>

                    <label>Image</label>
                    <input type="file" name="image" class="form-control" required>

                    <input type="hidden" name="action" value="Add">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>