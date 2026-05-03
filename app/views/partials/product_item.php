<?php 
    // $isFavorite = $addToMenu->checkIfFavorite($item['id'], $_SESSION['user_id']);

    if (isset($_SESSION['user_id'])) {
        $isFavorite = $addToMenu->checkIfFavorite($item['id'], $_SESSION['user_id']);
    } else {
        $isFavorite = false;
    }
?>
<div class="col-sm-6 col-md-4 drink-item">
    <a href="#" class="product-link 
    text-decoration-none 
    text-dark text-center 
    d-block"
    data-bs-toggle="modal"
    data-bs-target="#productModal"
    data-id = "<?= $item['id'] ?>"
    data-name="<?= htmlspecialchars($item['name']) ?>"
    data-desc="<?= htmlspecialchars($item['description']) ?>"
    data-ingredients="<?= htmlspecialchars($item['ingredients']) ?>"
    data-image="uploads/products/<?= htmlspecialchars($item['image']) ?>"
    data-price-s="<?= $item['price_s'] ?? '' ?>"
    data-price-m="<?= $item['price_m'] ?? '' ?>"
    data-price-l="<?= $item['price_l'] ?? '' ?>"
    data-is-favorite="<?= $isFavorite ?? 0 ?>"
    onclick="populateModal(this)">
        <img src="<?= base_url('uploads/products/' . htmlspecialchars($item['image'])) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="drink-img">
        <p class="mt-2"><?= htmlspecialchars($item['name']) ?></p>
    </a>
</div>