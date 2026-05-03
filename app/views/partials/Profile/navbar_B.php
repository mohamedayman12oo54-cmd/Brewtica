<?php 

    // $current_page = basename($_SERVER['PHP_SELF']);

    $user = new User();
    $userInfo = $user->fetchCurrentUser();


?>

<!-- ============ Navbar ============ -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <a href="<?= base_url('/') ?>" class="navbar-brand"><img src="<?= base_url('images/site/Logo_B.png') ?>" alt="Logo" class="img-fluid rounded-circle"></a>
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto ms-4 mb-2 mb-lg-0">
            <li class="nav-item"><a href="<?= base_url('menu_B') ?>" class="nav-link <?= ($page_type  == 'menu_B') ? 'current-nav-item' : '' ?>">Menu</a></li>
            <li class="nav-item"><a href="#" class="nav-link <?= ($page_type  == 'events_B') ? 'current-nav-item' : '' ?>">Events</a></li>
            <li class="nav-item"><a href="#" class="nav-link <?= ($page_type  == 'gift_cards_B') ? 'current-nav-item' : '' ?>">Gift Cards</a></li>
        </ul>
        </div>
        <div class="d-flex align-items-center">
        <a href="https://maps.app.goo.gl/uEP7smWNWSAnfMsw8" class="btn-find-store" target="_blank">
            <i class="bi bi-geo-alt-fill me-1"></i>Find a store
        </a>
        <!-- <button class="btn btn-signin" data-bs-toggle="modal" data-bs-target="#signinModal">Sign in</button>
        <a href="join_B.php" class="btn btn-join">Join now</a> -->

        <?php if(isUserLoggedIn()): ?>
            <nav class="nav-icons">
                <a href="<?= base_url('bag_B') ?>" class="cart-btn" aria-label="Shopping Cart">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="label">Shopping Bag</span>
                    <span class="cart-count">0</span>
                </a>

                <a href="<?= base_url('fav_list_B') ?>" class="favorite-btn" aria-label="Favorites">
                    <i class="fas fa-heart"></i>
                    <span class="label">Favorites</span>
                </a>

                <div class="account-container">
                <a href="<?= base_url('my_account_B') ?>" class="account-dropdown-toggle">
                    <i class="fas fa-user"></i> My Account
                </a>
                <div class="account-menu">
                    <ul>
                        <li class="username"><a href="<?= base_url('my_account_B') ?>"><?= $userInfo['data']['f_name'] . " " . $userInfo['data']['l_name'] ?></a></li>
                        <li><a href="#">My Orders</a></li>
                        <li><a href="#">Address Book</a></li>
                        <li><a href="#">My Rating</a></li>
                        <li class="gift-section">
                            <a href="#">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/1/1d/Gift_icon.svg">
                                <span>Brewtica Gift Club</span>
                            </a>
                        </li>
                        <li><a href="#">Help</a></li>
                    </ul>
                    <div class="account-footer">
                        <!-- <a href="partials/admin/auth/logout_B.php" class="logout-btn">Log out</a> -->
                        <form action="<?= base_url('logout') ?>" method="post">
                            <button class="logout-btn">Log out</button>
                        </form>
                    </div>
                </div>
                </div>
            </nav>
        <?php else: ?>

            <button class="btn btn-signin" data-bs-toggle="modal" data-bs-target="#signinModal">Sign in</button>
            <a href="<?= base_url('user/join_B') ?>" class="btn btn-join">Join now</a>

        <?php endif; ?>

        </div>
    </nav>
</header>