<?php

    // $current_page = basename($_SERVER['PHP_SELF']);

    $user = new User();
    $userInfo = $user->fetchCurrentUser();

?>

<aside class="account-sidebar">
    <div class="account-info">
        <h4>Account Information</h4>
        <p><?= $userInfo['data']['f_name'] . " " . $userInfo['data']['l_name'] ?></p>
    </div>
    <ul class="account-menu-sbar">
        <li><a href="#"><i class="fas fa-receipt"></i> My Orders</a></li>
        <li><a href="#"><i class="fas fa-star"></i> My Rating</a></li>
        <li class="<?= ($page_type == 'fav_list_B') ? 'account-active' : '' ?>"><a href="<?= base_url('fav_list_B') ?>"><i class="fas fa-list-ul"></i> Wish List</a></li>

        <li class="account-dropdown <?= ($page_type == 'gift_club_B') ? 'account-active' : '' ?>">
            <a href="#" class="account-dropdown-toggle"><i class="fas fa-gift"></i> Brewtica Gift Club <i class="fas fa-caret-<?= ($page_type == 'gift_club_B') ? 'up' : 'down' ?>"></i></a>
            <ul class="account-submenu <?= ($page_type == 'gift_club_B') ? 'account-active-submenu' : '' ?>">
                <li><a href="#">My Rewards</a></li>
                <li><a href="#">My Points</a></li>
            </ul>
        </li>

        <li><a href="#"><i class="fas fa-book"></i> Address Book</a></li>

        <li class="account-dropdown <?= ($page_type == 'payment_B') ? 'account-active' : '' ?>">
            <a href="#" class="account-dropdown-toggle"><i class="fas fa-credit-card"></i> My Payment Information <i class="fas fa-caret-down"></i></a>
            <ul class="account-submenu <?= ($page_type == 'payment_B') ? 'account-active-submenu' : '' ?>">
                <li><a href="#">My Cards</a></li>
            </ul>
        </li>

        <li class="account-dropdown <?= ($page_type == 'my_account_B') ? 'account-active' : '' ?>">
            <a href="#" class="account-dropdown-toggle"><i class="fas fa-cogs"></i> My Account Settings <i class="fas fa-caret-<?= ($page_type == 'my_account_B') ? 'up' : 'down' ?>"></i></a>
            <ul class="account-submenu <?= ($page_type == 'my_account_B') ? 'account-active-submenu' : '' ?>">
                <li><a href="#" class="<?= ($page_type == 'my_account_B') ? 'account-current-page' : '' ?>">My Personal Information</a></li>
                <li><a href="#">Change Password</a></li>
                <li><a href="#">Newsletter</a></li>
                <li><a href="#">Communication</a></li>
                <li><a href="#">Language Preference</a></li>
            </ul>
        </li>

        <li><a href="#"><i class="fas fa-question-circle"></i> HELP</a></li>
        <li>
            <!-- <a href="partials/admin/auth/logout_B.php" class="account-logout"><i class="fas fa-sign-out-alt"></i> Log out</a> -->
            <form action="<?= base_url('logout') ?>" method="post">
                <button class="account-logout"><i class="fas fa-sign-out-alt"></i> Log out</button>
            </form>
        </li>
    </ul>
</aside>