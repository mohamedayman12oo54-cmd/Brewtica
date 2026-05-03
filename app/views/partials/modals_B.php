<!-- ===== Sign-In Modal ===== -->
<!-- <div class="modal fade modal_style" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <img src="images/site/Sign_in_Modal_Img_B.png" alt="Coffee" class="modal-header-img">

            <button type="button" class="btn-close close-btn" data-bs-dismiss="modal"></button>

            <div class="p-4">
                <h5 class="subscribe-text mb-3">Welcome back – let’s stay in touch.</h5><hr>
                <form method="post" action="<?php echo base_url('/sign_in_B'); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control custom-input" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control custom-input" name="password" placeholder="Enter Your Password" required>
                    </div>
                    <button type="submit" class="btn Signin-btn w-100">Sign In</button>
                </form>
            </div>

        </div>
    </div>
</div> -->

<!-- ===== Product Modal ===== -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-dark-green text-white">
                <h5 class="modal-title">
                Product Details
                </h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
            </div>

            <input type="hidden" id="modalProductId">
            <input type="hidden" id="modalProductSize">

            <!-- Body -->
            <div class="modal-body d-flex flex-column flex-md-row">

                <div class="product-image w-100 w-md-50 text-center p-3">
                    <img id="modalProductImage" alt="Product Image" class="img-fluid rounded">
                </div>

                <div class="product-details w-100 w-md-50 p-3">
                    <h4 id="modalProductName"></h4>
                    <p id="modalProductDesc"></p>
                    <p><strong>Ingredients: </strong><span id="modalProductIngredients"></span></p>
                    <div class="mb-3">
                        <strong>Size</strong>
                        <!-- <span class="size-option" onclick="selectSize(this)">S</span>
                        <span class="size-option active-size" onclick="selectSize(this)">M</span>
                        <span class="size-option" onclick="selectSize(this)">L</span> -->

                        <div id="sizeOptionsContainer"></div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div class="price-badge"><span id="modalProductPrice"></span> $</div>
                        <div>
                        <i class="bi bi-heart favorite-icon" onclick="toggleFavorite(this)"></i>
                        <i class="bi bi-bag-fill bag-icon fs-5" onclick="addToBag(this)"></i>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- Footer -->
            <div class="modal-footer bg-dark-green text-white d-flex justify-content-between">
                <a href="#" class="text-white text-decoration-none">
                <i class="bi bi-geo-alt-fill me-1"> Set Your Location</i>
                </a>
            </div>

        </div>
    </div>
</div>














<div class="modal fade modal_style" id="signinModal" tabindex="-1" aria-labelledby="signinModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <img src="images/site/Sign_in_Modal_Img_B.png" alt="Coffee" class="modal-header-img">

            <button type="button" class="btn-close close-btn" data-bs-dismiss="modal"></button>

            <div class="p-4">
                <h5 class="subscribe-text mb-3">Welcome back – let’s stay in touch.</h5><hr>
                <form id="signinForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control custom-input" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control custom-input" name="password" placeholder="Enter Your Password" required>
                    </div>

                    <div class="text-danger d-none" id="loginError"></div>

                    <button type="submit" class="btn Signin-btn w-100">Sign In</button>

                </form>
            </div>

        </div>
    </div>
</div>