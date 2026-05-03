<?php 

    $addToMenu = new Add_To_Menu();

    $fullMenuStructure = $addToMenu->getFullMenuStructure();

?>

<!-- ===== MAIN ===== -->
<section id="content">
    <main>

        <div class="head-title">
            <div class="left">
                <h1>Categories</h1>
                <ul class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="#" class="active">Categories</a></li>
                </ul>
            </div>
            <!-- Open Main Category Modal -->
            <button class="btn-add-main" 
                data-bs-toggle="modal" 
                data-bs-target="#mainModal"
                modal-title="Add Main Category">
                <i class='bx bx-plus'></i>
                <span>Add Main Category</span>
            </button>
        </div>

        <?php foreach($fullMenuStructure as $main): ?>
            <div class="main-category">
                <div class="main-category-header d-flex justify-content-between align-items-center">
                    <h2><?= htmlspecialchars($main['name']) ?></h2>
                    <div class="action-buttons">
                        <button title="Edit"
                            class="open-main"
                            data-bs-toggle="modal" 
                            data-bs-target="#mainModal"
                            modal-title="Update Main Category"
                            table-name="main_categories"
                            main-category-id="<?= $main['id'] ?>">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button class="delete_main delete"
                            data-category-id="<?= $main['id'] ?>"
                            data-table-name="main_categories">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                </div>

                <div class="main-category-body">
                    <?php foreach($main['sub_categories'] as $index => $sub): ?>
                        <div class="category-card mb-3">
                            <div class="category-header d-flex justify-content-between align-items-center">
                                <h3><?= htmlspecialchars($sub['name']) ?></h3>
                                <div class="d-flex align-items-center">
                                    <div class="action-buttons me-2">
                                        <button title="Edit"
                                            class="open-sub"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#subModal"
                                            modal-title="Update Sub Category"
                                            table-name="sub_categories"
                                            sub-category-id="<?= $sub['id'] ?>">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                        <button class="delete_sub delete"
                                            data-category-id="<?= $sub['id'] ?>"
                                            data-table-name="sub_categories">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                    <!-- Button داخل حلقة foreach على الـ sub -->
                                    <button type="button"
                                        class="btn-add-sub-sub"
                                        data-bs-toggle="modal"
                                        data-bs-target="#sub_sub_modal"
                                        modal-title="Add Sub-Sub Category"
                                        data-card-id="<?= htmlspecialchars($sub['id']) ?>">
                                        <i class='bx bx-plus'></i> Add Sub-Sub Category
                                    </button>
                                </div>
                            </div>

                            <ul class="sub-categories">
                                <?php if(!empty($sub['sub_sub_categories'])): ?>
                                    <?php foreach($sub['sub_sub_categories'] as $sub_sub): ?>
                                        <li class="d-flex justify-content-between align-items-center">
                                            <span class="sub-sub-name"><?= htmlspecialchars($sub_sub['name']) ?></span>
                                            <div class="action-buttons">
                                                <button title="Edit"
                                                    class="open-sub-sub"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#sub_sub_modal"
                                                    modal-title="Update Sub-Sub Category"
                                                    table-name="sub_sub_categories"
                                                    sub-sub-category-id="<?= $sub_sub['id'] ?>">
                                                    <i class='bx bx-edit'></i>
                                                </button>
                                                <button class="delete_sub_sub delete"
                                                    data-category-id="<?= $sub_sub['id'] ?>"
                                                    data-table-name="sub_sub_categories">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>No Sub-Sub Categories Yet.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <button class="btn-add-sub" 
                        data-bs-toggle="modal" 
                        data-bs-target="#subModal" 
                        modal-title="Add Sub Category"
                        data-main-id="<?= $main['id'] ?>">
                        <i class='bx bx-plus'></i> Add Sub Category
                    </button>
                    <!-- <div class="action-buttons">
                        <button title="Edit"><i class='bx bx-edit'></i></button>
                        <button title="Delete"><i class='bx bx-trash'></i></button>
                    </div> -->
                </div>
            </div>
        <?php endforeach; ?>

    </main>
</section>

<!-- ===== Main Category Modal ===== -->
<div class="modal fade" id="mainModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark-green text-white">
                <h5 class="modal-title"></h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

            <form id="main_category_form">
                <div class="modal-body">
                    <input type="hidden" name="main_id" id="mainId">
                    <input type="hidden" name="table" value="main_categories">

                    <label for="mainName" class="form-label">Main Category Name</label>
                    <input type="text" id="mainName" class="form-control" name="main_name" placeholder="Enter category name" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_main" class="btn btn-success" id="saveBtn">Safe</button>
                </div>
            </form>

            <div id="formError" class="text-danger mt-2" style="display:none;"></div>
        </div>
    </div>
</div>

<!-- ===== Sub Category Modal ===== -->
<div class="modal fade" id="subModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark-green text-white">
                <h5 class="modal-title"></h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

            <form id="sub_category_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="sub_id" id="subId">
                    <input type="hidden" name="main_category_id" id="mainCategoryId">
                    <input type="hidden" name="table" value="sub_categories">


                    <div class="mb-3">
                        <label for="subTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" name="sub_name" id="subName" placeholder="Enter sub category title">
                    </div>
                    <div class="mb-3">
                        <label for="subImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="sub_image" id="subImage" accept="image/*" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_sub" class="btn btn-success" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== Sub-Sub Category Modal ===== -->
<div class="modal fade" id="sub_sub_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-dark-green text-white">
            <h5 class="modal-title"></h5>
            <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

        <form id="sub_sub_category_form">
            <div class="modal-body">
            <!-- IMPORTANT: id must match the JS selector and name must match PHP -->
            <input type="hidden" name="sub_category_id" id="subSubCategoryId" value="">
            <input type="hidden" name="sub_sub_id" id="subSubId">
            <input type="hidden" name="table" value="sub_sub_categories">

            <div class="mb-3">
                <label for="subSubName" class="form-label"> Sub-Sub Category Name</label>
                <input type="text" id="subSubName" class="form-control" name="sub_sub_name" placeholder="Enter category name" />
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="submit_sub_sub" class="btn btn-success" id="saveBtn">Save</button>
            </div>
        </form>

        </div>
    </div>
</div>

<!-- ===== Delete Confirmation Modal ===== -->
<div id="confirmationModal" class="modal confirm-modal">
    <div class="modal-content confirm-modal-content">
        <span class="close-button">&times;</span>
        <h4 class="confirm-title">Confirm Deletion</h4>
        <p class="confirm-text">You are about to permanently delete this item from the system. Do you confirm?</p>

        <button id="confirmRemoveBtn" class="confirm-btn danger" data-category-id="" data-table-name="">Remove</button>
        <button id="cancelRemoveBtn" class="confirm-btn cancel">Cancel</button>
    </div>
</div>

<!-- ===== Toast ===== -->
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index:9999">

    <div id="actionToast" class="toast border-0" role="alert">
        <div class="toast-body text-center">
            <div id="toastIcon" class="toast-icon">✓</div>
            <div id="toastMessage" class="toast-text">Link copied</div>
        </div>
    </div>

</div>

<script src="<?= base_url('scripts/admin_categories_script.js') ?>"></script>