<?php

    $addToMenu = new Add_To_Menu();

    $menu = $addToMenu->getFullMenuStructure();

?>



<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">

            <ul class="list-unstyled">
                <li><a href="#" class="side-link current">Menu</a></li>
                <li><a href="#" class="side-link">Featured</a></li>
                <li><a href="#" class="side-link">Previous</a></li>
                <li><a href="#" class="side-link">Favorites</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 py-4 px-5">
            <h2 class="text-center fw-bold mb-4">Menu</h2>
            <?php foreach ($menu as $main): ?>
                <h4 class="section-title-menu"><?= htmlspecialchars($main['name']) ?></h4>

                <div class="row">
                    <?php if(!empty($main['sub_categories'])): ?>
                        <?php foreach($main['sub_categories'] as $sub): ?>
                            <?php $page = generateFileName($sub['name']); ?>
                            <div class="col-sm-6 col-md-4 drink-item-menu">
                                <a href="drinks_B?type=<?= urlencode($page) ?>" class="text-decoration-none text-dark text-center d-block">
                                    <img src="<?= base_url('uploads/sub_categories/' . htmlspecialchars($sub['image'])) ?>" alt="<?= htmlspecialchars($sub['name']) ?>" class="drink-img-menu">
                                    <p class="mt-2"><?= htmlspecialchars($sub['name']) ?></p>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>