<section id="sidebar">
    <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">AdminHub</span>
    </a>
    <ul class="side-menu top">
        <li class="<?= ($current_page == 'dashboard_B') ? 'active' : '' ?>">
            <a href="<?= base_url('dashboard_B') ?>">
                <i class="bx bxs-dashboard"></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('/') ?>">
                <i class="bx bx-globe"></i> 
                <span class="text">View Site</span>
            </a>
        </li>
        <li class="<?= ($current_page == 'admin_categories_B') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/categories_B') ?>">
                <i class="bx bx-category"></i>
                <span class="text">Categories</span>
            </a>
        </li>
        <li class="<?= ($current_page == 'admin_menu_B') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/menu_B') ?>">
                <i class="bx bx-list-ul"></i>
                <span class="text">Menu</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bx bxs-group"></i>
                <span class="text">Customers</span>
            </a>
        </li>
        <li  class="<?= ($current_page == 'admin_staff_B') ? 'active' : '' ?>">
            <a href="<?= base_url('admin/staff_B') ?>">
                <i class="bx bx-briefcase"></i>
                <span class="text">Staff</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-doughnut-chart' ></i>
                <span class="text">Analytics</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-message-dots' ></i>
                <span class="text">Message</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog' ></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <form action="<?= base_url('logout') ?>" method="post">
                <!-- <a href="" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a> -->

                <button class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</section>