<?php

    $user = new User();
    $userInfo = $user->fetchCurrentUser();

    $userDate = [
        'day' => $userInfo['data']['day'],
        'month' => $userInfo['data']['month'],
        'year' => $userInfo['data']['year']
    ]


?>

<nav class="account-breadcrumb">
    <a href="<?= base_url('/') ?>">Homepage</a>
    <span>&rarr;</span>
    <a href="<?= base_url('my_account_B.php') ?>">My Account</a>
    <span>&rarr;</span>
    <a href="<?= base_url('my_account_B.php') ?>">My Account Settings</a>
    <span>&rarr;</span>
    <span>My Personal Information</span>
</nav>

<main class="account-main-container">

    <?php 
        require_once views_path('partials/Profile/sidebar_B.php');
    ?>

    <section class="account-content">
        <h1>MY ACCOUNT</h1>
        <div class="account-personal-info-form">
            <h2>My personal Information</h2>
            <form id="personalInfoForm" method="post">
                <div class="account-form-group account-row">
                    <div class="account-col">
                        <label for="name">Name</label>
                        <input type="text" id="name" value="<?= $userInfo['data']['f_name'] ?>" required>
                    </div>
                    <div class="account-col">
                        <label for="surname">Surname</label>
                        <input type="text" id="surname" value="<?= $userInfo['data']['l_name'] ?>" required>
                    </div>
                </div>

                <div class="account-form-group">
                    <label for="email">E-mail Address</label>
                    <div class="account-input-with-icon">
                        <input type="email" id="email" value="<?= $userInfo['data']['email'] ?>" readonly>
                        <i class="fas fa-check-circle account-verified-icon"></i>
                    </div>
                </div>

                <div class="account-form-group">
                    <label for="phone">Phone Number*</label>
                    <div class="account-input-with-icon">
                        <input type="tel" id="phone" name="phone" value="<?= $userInfo['data']['phone'] ?>" placeholder="Enter phone number" required>
                        <i class="fas fa-check-circle account-verified-icon"></i>
                    </div>
                </div>

                <div class="account-form-group">
                    <label>Date of Birth</label>
                    <div class="account-date-of-birth">
                        <div class="account-date-select">
                            <label for="day">Day</label>
                            <select id="day" name="day" required></select>
                        </div>
                        <div class="account-date-select">
                            <label for="month">Month</label>
                            <select id="month" name="month" required></select>
                        </div>
                        <div class="account-date-select">
                            <label for="year">Year</label>
                            <select id="year" name="year" required></select>
                        </div>
                    </div>
                </div>

                <div class="account-form-group">
                    <label>Gender</label>
                    <div class="account-radio-group">
                        <label class="account-radio-label">
                            <input type="radio" name="gender" value="female" <?= ($userInfo['data']['gender'] == 'female') ? 'checked' : '' ?>> Female
                        </label>
                        <label class="account-radio-label">
                            <input type="radio" name="gender" value="male" <?= ($userInfo['data']['gender'] == 'male') ? 'checked' : '' ?>> Male
                        </label>
                        <label class="account-radio-label">
                            <input type="radio" name="gender" value="other" <?= ($userInfo['data']['gender'] == 'other') ? 'checked' : '' ?>> I do not want to specify
                        </label>
                    </div>
                </div>
                
                <div class="account-action-buttons">
                    <button type="submit" class="account-action-btn account-btn-save">Save</button>
                    <button type="button" class="account-action-btn account-btn-delete">Delete My Account</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const userDate = <?php echo json_encode($userDate); ?>;
    </script>

</main>