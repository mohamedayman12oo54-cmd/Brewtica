<?php 

    $addToMenu = new Add_To_Menu();

    $menu = $addToMenu->getFullMenuStructure();

?>

<!-- ===== MAIN ===== -->
<section id="content">
    <main>
        <div class="categories">
            <?php foreach ($menu as $main): ?>
                <?php if(!empty($main['sub_categories'])): ?>
                    <?php foreach($main['sub_categories'] as $sub): ?>
                        <!-- Category -->
                        <div class="category">
                            <h2 class="category-title"><?= htmlspecialchars($sub['name']) ?></h2>
                            <?php if(!empty($sub['sub_sub_categories'])): ?>
                                <?php foreach($sub['sub_sub_categories'] as $sub_sub): ?>
                                    <h4 class="section-title items-title"><?= htmlspecialchars($sub_sub['name']) ?></h4>
                                    <table class="products-table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($sub_sub['items'])): ?>
                                                <?php foreach ($sub_sub['items'] as $item): ?>
                                                    <tr>
                                                        <td><?= $item['id'] ?></td>
                                                        <td><?= htmlspecialchars($item['name']) ?></td>
                                                        <td><?= htmlspecialchars($item['description']) ?></td>
                                                        <td class="actions">
                                                            <button class="edit open-item" data-bs-toggle="modal"
                                                                data-bs-target="#addProduct" 
                                                                data-title="Update Product"
                                                                data-item-id="<?= $item['id'] ?>">
                                                                Edit
                                                            </button>
                                                            <button class="delete" data-item-id="<?= $item['id'] ?>">Delete</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4">No products yet.</td>
                                                </tr>
                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                    <button class="btn-add-item add_item mb-5" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addProduct"
                                        data-title="Add New Product"
                                        data-sub-id="<?= $sub_sub['id'] ?>">
                                        <i class='bx bx-plus'></i>
                                        <span>Add New Item</span>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </main>
</section>

<!-- ===== Add & Update Product Modal ===== -->
<div class="modal fade modal_style" id="addProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark-green text-white">
                <h5 class="modal-title"></h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

            <form id="addProductForm" class="needs-validation" novalidate enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="item_id" id="itemId">
                    <input type="hidden" name="sub_sub_category_id" id="subCategoryId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter product title" required>
                        <div class="invalid-feedback">Name is required.</div>
                    </div>

                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea id="desc" name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="ing" class="form-label">Ingredients</label>
                        <textarea id="ing" name="ingredients" class="form-control" rows="2" placeholder="Enter product ingredients"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Upload Image</label>
                        <input id="image" name="image" class="form-control" type="file" accept="image/*">
                    </div>

                    <div class="mb-1">
                        <label class="form-label d-block">Prices</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <label for="priceS" class="form-label small">S</label>
                                <input type="text" id="priceS" name="priceS" class="form-control" placeholder="Price S">
                            </div>
                            <div class="col-4">
                                <label for="priceM" class="form-label small">M</label>
                                <input type="text" id="priceM" name="priceM" class="form-control" placeholder="Price M">
                            </div>
                            <div class="col-4">
                                <label for="priceL" class="form-label small">L</label>
                                <input type="text" id="priceL" name="priceL" class="form-control" placeholder="Price L">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_item" class="btn btn-success" id="saveBtn">Save</button>
                </div>
            </form>

            <div id="formError" class="text-danger mt-2" style="display:none;"></div>
        </div>
    </div>
</div>

<!-- ===== Delete Confirmation Modal ===== -->
<div id="confirmationModal" class="modal confirm-modal">
    <div class="modal-content confirm-modal-content">
        <span class="close-button">&times;</span>
        <h4 class="confirm-title">Confirm Deletion</h4>
        <p class="confirm-text">You are about to permanently delete this item from the system. Do you confirm?</p>

        <button id="confirmRemoveBtn" class="confirm-btn danger" data-item-id="">Remove</button>
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

<script src="<?= base_url('scripts/admin_menu_script.js') ?>"></script>