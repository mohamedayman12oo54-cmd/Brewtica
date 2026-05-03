
<!-- ===== Add & Update Product Modal ===== -->
<!-- <div class="modal fade modal_style" id="addProduct" tabindex="-1" aria-hidden="true">
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
</div> -->

<!-- ===== Main Category Modal ===== -->
<!-- <div class="modal fade" id="mainModal" tabindex="-1" aria-hidden="true">
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
</div> -->

<!-- ===== Sub Category Modal ===== -->
<!-- <div class="modal fade" id="subModal" tabindex="-1" aria-hidden="true">
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
</div> -->

<!-- ===== Sub-Sub Category Modal ===== -->
<!-- <div class="modal fade" id="sub_sub_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-dark-green text-white">
            <h5 class="modal-title"></h5>
            <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

        <form id="sub_sub_category_form">
            <div class="modal-body">
            
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
</div> -->
