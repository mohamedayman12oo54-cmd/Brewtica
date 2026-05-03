<?php

    $addToMenu = new Add_To_Menu();

    $menu = $addToMenu->getFullMenuStructure();

    $page = $_GET['type'] ?? '';

    $page = htmlspecialchars($page);

?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <!-- <h5 class="fw-bold mb-3">Drinks</h5>
            <h5 class="fw-bold mb-3">Featured</h5>
            <h5 class="fw-bold mb-3">Previous</h5>
            <h5 class="fw-bold mb-3">Favorites</h5> -->

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
                <?php if(!empty($main['sub_categories'])): ?>
                    <?php foreach($main['sub_categories'] as $sub): ?>
                        <?php if(generateFileName($sub['name']) === $page): ?>
                            <h4 class="section-title"><?= htmlspecialchars($sub['name']) ?></h4>
                            <?php if(!empty($sub['sub_sub_categories'])): ?>
                                <?php foreach($sub['sub_sub_categories'] as $sub_sub): ?>
                                    <h4 class="section-title items-title"><?= htmlspecialchars($sub_sub['name']) ?></h4>

                                    <div class="row mb-5">
                                        <?php if(!empty($sub_sub['items'])): ?>
                                            <?php foreach ($sub_sub['items'] as $item): ?>
                                                <?php 
                                                    include views_path('partials/product_item.php');
                                                ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?> 
                <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>