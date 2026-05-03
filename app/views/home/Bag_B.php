<?php 

    $userId = $_SESSION['user_id'] ?? null;

    $cart = new Add_To_Menu();

    $bag = $cart->getCart($userId);

 

    foreach ($bag as &$item) {
        $item['is_checked'] = $_SESSION['cart_checked'][$item['product_id']][$item['size']] ?? 1;
    }
    unset($item);

    $subTotal = 0;

    foreach($bag as $item){
        if($item['is_checked']){
            $subTotal  += $item['total_price'];
        }

        // $subTotal  += $item['total_price'];

    }

    $deliveryFee = 2;
    $tax = $subTotal * 0.14;
    $Total = $subTotal + $tax + $deliveryFee;
  

?>

<nav class="account-breadcrumb">
    <a href="<?= base_url('/') ?>">Homepage</a>
    <!-- <span>&rarr;</span>
    <a href="<?= base_url('my_account_B.php') ?>">My Account</a> -->
    <span>&rarr;</span>
    <a href="<?= base_url('/bag_B') ?>">Bag</a>
    <!-- <span>&rarr;</span>
    <span>My Personal Information</span> -->
</nav>


<main class="coffee-cart-main-content py-4 bg-light">
    <div class="container coffee-cart-container">
        <div class="d-flex justify-content-between align-items-center mb-3 coffee-cart-header">
            <a href="#" class="text-dark text-decoration-none coffee-cart-back-link d-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Shopping Cart (<?= count($bag); ?> Product)
            </a>
            <button class="btn btn-sm coffee-cart-favorites-btn" id="goBtn" style="color: #6c757d; background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 0.5rem; padding: 0.5rem 1rem;">
                <i class="bi bi-heart me-1"></i> Favorites
            </button>
        </div>

        <div class="alert coffee-cart-shipping-banner text-center py-2 mb-4 d-flex align-items-center justify-content-center" role="alert" style="background-color: #fcf8f9; border-color: #fde8ed; color: #721c24; border-radius: 0.5rem;">
            <span class="me-2" style="font-size: 0.9rem;">Add <strong style="color: #d84357;">750 EGP</strong> more to your cart to get <strong style="color: #d84357;">free shipping</strong></span>
        </div>

        <div class="row coffee-cart-row">





            <?php if(count($bag) > 0): ?>

                <?php foreach($bag as $item): ?>

                    <div class="col-lg-8 coffee-cart-items-column">
                        <div class="card mb-3 shadow-sm coffee-cart-item-card" style="border: 1px solid #e0e0e0; border-radius: 0.5rem;">
                            <div class="card-body py-3 px-3">
                                <div class="row align-items-center">
                                    <div class="col-auto d-flex align-items-center coffee-cart-image-area">
                                        <input class="form-check-input me-3 coffee-cart-checkbox cart-item-check" <?= ($item['is_checked'] ?? true) ? 'checked' : '' ?> data-product-id="<?= $item['product_id'] ?>" data-size="<?= $item['size'] ?>" type="checkbox" data-price="<?= $item['total_price'] ?>" style="transform: scale(1.1);">
                                        <img src="<?= base_url('uploads/products/' . htmlspecialchars($item['product_image'])) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="img-fluid rounded me-3 coffee-cart-item-img"  style="width: 100px; height: 130px; object-fit: cover; border-radius: 0.3rem !important;">
                                    </div>

                                    <div class="col coffee-cart-details">
                                        <h6 class="card-title mb-1 coffee-cart-item-title" style="font-size: 0.95rem; font-weight: 600;"><?= htmlspecialchars($item['product_name']) ?></h6>
                                        <div class="d-flex align-items-center mb-2 coffee-cart-options-wrap">
                                            <span class="text-muted me-2" style="font-size: 0.85rem;">Size:</span> 
                                            <div class="coffee-cart-size-selector d-flex me-3">
                                                <button class="btn coffee-cart-size-btn size_btn coffee-cart-size-s <?= ($item['size'] == 'small')? 'coffee-cart-size-active' : ''; ?>" data-new-size="small" data-old-size="<?= $item['size'] ?>" data-product-id="<?= $item['product_id'] ?>">S</button>
                                                <button class="btn coffee-cart-size-btn size_btn coffee-cart-size-m <?= ($item['size'] == 'medium')? 'coffee-cart-size-active' : ''; ?>" data-new-size="medium" data-old-size="<?= $item['size'] ?>" data-product-id="<?= $item['product_id'] ?>">M</button>
                                                <button class="btn coffee-cart-size-btn size_btn coffee-cart-size-l <?= ($item['size'] == 'large')? 'coffee-cart-size-active' : ''; ?>" data-new-size="large" data-old-size="<?= $item['size'] ?>" data-product-id="<?= $item['product_id'] ?>">L</button>
                                            </div>
                                            <!-- <span class="text-muted" style="font-size: 0.85rem;">Type: Hot</span> -->
                                        </div>
                                        <span class="fw-bold text-dark fs-6 coffee-cart-price"><?= htmlspecialchars($item['total_price']) ?>$</span> 
                                        <!-- <span class="text-decoration-line-through text-muted ms-2" style="font-size: 0.85rem;">60 EGP</span> -->
                                    </div>

                                    <div class="col-auto text-end coffee-cart-actions">
                                        <div class="d-flex align-items-center justify-content-end mb-1 coffee-cart-quantity-controls">
                                            <button class="btn btn-outline-secondary btn-sm p-0 d-flex align-items-center justify-content-center coffee-cart-qty-minus action_btn" data-quantity-action="decrease" data-product-id="<?= $item['product_id'] ?>" data-size="<?= $item['size'] ?>" style="width: 28px; height: 28px; font-size: 1rem; border-radius: 0.2rem; border-color: #dee2e6;">-</button><input type="text" id="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" class="form-control form-control-sm text-center mx-1 coffee-cart-qty-input" style="width: 35px; height: 28px; padding: 0.1rem; font-size: 0.85rem; border-color: #dee2e6;">
                                            <button class="btn btn-outline-secondary btn-sm p-0 d-flex align-items-center justify-content-center coffee-cart-qty-plus action_btn" data-quantity-action="increase" data-product-id="<?= $item['product_id'] ?>" data-size="<?= $item['size'] ?>" style="width: 28px; height: 28px; font-size: 1rem; border-radius: 0.2rem; border-color: #dee2e6;">+</button>
                                        </div>
                                        <button class="btn btn-sm btn-link p-0 text-muted coffee-cart-remove-btn bag-remove-btn" data-product-id="<?= $item['product_id'] ?>" data-size="<?= $item['size'] ?>" title="Remove Item" style="font-size: 0.8rem; text-decoration: none;">
                                            <i class="bi bi-x-lg me-1"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- <p class="text-muted mt-3 coffee-cart-delivery-info" style="font-size: 0.85rem;"><i class="bi bi-truck me-2"></i>Estimated Delivery Date: 14 October - 19 October</p> -->

                    </div>

                <?php endforeach; ?>
            <?php else: ?>



            <?php endif; ?>





            <div class="col-lg-4 coffee-cart-summary-column coffee-cart-summary-fixed">
                <div class="card border-0 shadow-sm coffee-cart-summary-card" style="border-radius: 0.5rem; background-color: #fff;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2 coffee-cart-subtotal" style="font-size: 0.9rem;">
                            <span>SubTotal</span>
                            <span id="subTotal"><?= $subTotal ?>$</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 coffee-cart-delivery-charge" style="font-size: 0.9rem;">
                            <span>Cargo <i class="bi bi-info-circle-fill text-muted ms-1" data-bs-toggle="tooltip" title="Delivery charges"></i></span>
                            <span id="deliveryFee"><?= $deliveryFee ?>$</span>
                        </div>

                        <hr class="my-3 coffee-cart-divider" style="border-top: 1px solid #ececec;">

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3 coffee-cart-total">
                            <span style="font-size: 1.2rem;">Total</span>
                            <span id="total" style="font-size: 1.2rem;"><?= $Total ?>$</span>
                        </div>

                        <button class="btn btn-dark w-100 py-2 mb-4 coffee-cart-complete-order-btn" >COMPLETE ORDER</button>

                        <div class="mb-3 coffee-cart-loyalty-points">
                            <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 0.9rem;">
                                <span>Use My Gift Club Points</span>
                                <span class="text-muted">0 EGP</span>
                            </div>
                            <div class="input-group coffee-cart-gift-club-input-group">
                                <input type="text" class="form-control coffee-cart-points-input" placeholder="Amount of $ you want to use">
                                <button class="btn btn-outline-secondary coffee-cart-points-use-btn" type="button" style="font-size: 0.85rem; border-radius: 0; border-color: #dee2e6;">Use</button>
                            </div>
                        </div>

                        <div class="mb-3 coffee-cart-discount-code">
                            <label for="discountCode" class="form-label visually-hidden">Your Discount Code</label>
                            <div class="input-group coffee-cart-discount-input-group">
                                <input type="text" class="form-control coffee-cart-discount-input" id="discountCode" placeholder="Your Discount Code">
                                <button class="btn btn-outline-secondary coffee-cart-discount-use-btn" type="button" style="font-size: 0.85rem; border-radius: 0; border-color: #dee2e6;">Use</button>
                            </div>
                        </div>

                        <div class="coffee-cart-new-money-points mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-2 coffee-cart-money-points-header">
                                <span class="fw-bold" style="font-size: 0.9rem;">Money Points</span>
                                
                                <i class="bi bi-chevron-up text-muted" 
                                style="font-size: 0.8rem; cursor: pointer; transition: transform 0.3s ease;" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#moneyPointsContent" 
                                aria-expanded="true"
                                aria-controls="moneyPointsContent"
                                class="coffee-cart-money-points-toggle-icon"></i>
                            </div>

                            <div class="collapse show" id="moneyPointsContent">
                                <div class="d-flex justify-content-between align-items-center mb-1 coffee-cart-money-points-balance">
                                    <span class="text-muted" style="font-size: 0.85rem;">The Money Points you can use:</span>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">0 EGP</span>
                                </div>
                                
                                <div class="coffee-cart-underlined-input-group mt-3 pb-2 border-bottom border-secondary-subtle d-flex align-items-end">
                                    <input type="text" class="form-control border-0 p-0 me-2 coffee-cart-money-input" 
                                        placeholder="The amount you would like to use:" 
                                        style="background-color: transparent; box-shadow: none !important; font-size: 0.9rem; border-radius: 0;">
                                    <button class="btn btn-link p-0 text-dark text-decoration-none coffee-cart-money-use-btn" type="button" 
                                            style="font-size: 0.9rem; font-weight: 500;">Use</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>