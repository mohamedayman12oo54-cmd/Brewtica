<?php

    require_once views_path('partials/admin/header_admin_B.php');
    require_once views_path('partials/admin/sidebar_admin_B.php');
    require_once views_path('partials/admin/navbar_admin_B.php');

    // include "partials/admin/auth/session_admin_check_B.php";

?>

<?= $content ?>

<?php

    require_once views_path('partials/admin/modals_admin_B.php');
    require_once views_path('partials/admin/footer_admin_B.php');

?>