
    <!-- ===== عروض Brewtica ===== -->
    <section class="promo-section">
        <!-- العرض 1 -->
        <div class="promo-container first">
        <div class="promo-left">
            <h2>See you on the patio</h2>
            <p>Soak up the season with Summer-Berry Refreshers and Iced Horchata Oatmilk Shaken Espresso. Enjoy these cool favorites while you can.</p>
            <a href="<?= base_url('menu_B') ?>" class="promo-btn">View the menu</a>
        </div>
        <div class="promo-right">
            <img src="<?= base_url('images/site/offer_image.jpg') ?> ?>" alt="Patio Drink">
        </div>
        </div>
        <!-- العرض 2 -->
        <div class="promo-container reverse Second_Offer">
        <div class="promo-left second-text">
            <h2>Cool off with Matcha</h2>
            <p>Refresh your day with our new iced matcha beverages – crafted for summer vibes only. Limited time!</p>
            <!-- <a href="join_B.php" class="promo-btn">Join now</a> -->

            <?php if(isUserLoggedIn()): ?>

                <a href="#" class="promo-btn">Our Club</a>

            <?php else: ?>

                <a href="<?= base_url('user/join_B') ?>" class="promo-btn">Join now</a>

            <?php endif; ?>
            
        </div>
        <div class="promo-right">
            <img src="<?= base_url('images/site/matcha-green-tea-latte_offer.jpg') ?>" alt="Matcha Drink">
        </div>
        </div>
        <!-- العرض 3 -->
        <div class="promo-container third">
        <div class="promo-left">
            <h2>Summer Sandwiches</h2>
            <p>Grab a fresh bite with our handcrafted summer sandwiches – perfect match with any cold brew.</p>
            <a href="bread_B.php" class="promo-btn">Order now</a>
        </div>
        <div class="promo-right">
            <img src="<?= base_url('images/site/breakfast_offer.png') ?>" alt="Sandwiches">
        </div>
        </div>
    </section>
