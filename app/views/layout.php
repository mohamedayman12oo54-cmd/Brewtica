<?php

    require_once views_path('partials/header_B.php');
    require_once views_path('partials/navbar_B.php');
    require_once views_path('partials/sign_in_B.php');
    // include "partials/auth/sessions_check_B.php";
?>

<!-- Main Content -->
<main class="main-content"> 

    <?php echo $content ?>

</main>

<?php

    require_once views_path('partials/modals_B.php');
    require_once views_path('partials/footer_B.php');

?>