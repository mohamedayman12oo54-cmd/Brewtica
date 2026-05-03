<?php 

    $userId = $_SESSION['user_id'] ?? null;

    $fav = new Add_To_Menu();

    $favorites = $fav->getFavorites($userId);

?>


<nav class="account-breadcrumb">
    <a href="<?= base_url('/') ?>">Homepage</a>
    <span>&rarr;</span>
    <!-- <a href="#">My Account</a>
    <span>&rarr;</span> -->
    <a href="<?= base_url('fav_list_B') ?>">Wish List</a>
    <!-- <span>&rarr;</span>
    <span>My Personal Information</span> -->
</nav>

<main class="account-main-container">

    <?php 
        require_once views_path('partials/Profile/sidebar_B.php');
    ?>

    <section class="account-content">
        <h1>MY ACCOUNT</h1>
        <div class="account-wishlist-header">
            <h2>Wish List</h2>
            <div class="account-search-favorites">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search my favorites">
            </div>
        </div>
        <div class="account-product-grid" id="wishlist-grid">
            <?php if (count($favorites) > 0): ?>
                <?php foreach ($favorites as $item): ?>
            
                    <div class="account-product-card">
                        <div class="account-card-actions">
                            <i class="fas fa-heart account-favorite-icon clickable-heart" 
                                data-product-id="<?= $item['id'] ?>" >
                            </i>
                        </div>

                        <img src="<?= base_url('uploads/products/' . htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="account-product-image">
                            
                        <div class="account-product-details">
                            <p class="account-product-name"><?= htmlspecialchars($item['name']) ?></p>
                            <div class="account-product-price"><?= $item['price_m'] ?? '' ?>$</div>
                            <div class="account-product-rating">
                                <i class="fas fa-star"></i> 4.5
                            </div>
                            <button class="account-btn-add-to-cart-sm">Add to Cart</button>
                        </div>
                    </div>                      
                
                <?php endforeach; ?>
            <?php else: ?>
                <!-- <p class="text-center text-muted mt-4">You don't have any favorite items yet</p> -->
                
                <h1 class="title-text-favourites">FAVOURITES</h1>
                <div class="content-area">
                    <p class="message-heading">OH! YOUR FAVOURITES IS EMPTY.</p>
                    <p class="message-text">
                        Start exploring our menu to add your first item to this list.
                    </p>
                    <a href="<?= base_url('menu_B') ?>" class="btn btn-continue">
                        CONTINUE TO MENU
                    </a>
                </div>
                
            <?php endif; ?>
        </div>

    </section>

    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h4>REMOVE FROM MY FAVORITES</h4>
            <p>The product will be removed from your favorite list. Do you confirm?</p>

            <button id="confirmRemoveBtn" data-product-id="">Remove</button>
            <button id="cancelRemoveBtn">Cancel</button>
        </div>
    </div>

</main>