  <!-- ============ Footer ============ -->
  <footer class="footer">
    <div class="container">
      <div class="row">
          <div class="col-md-4 mb-4">
              <h6>About us</h6>
              <a href="#">Our Coffees</a><a href="#">Our Story</a><a href="#">Sustainability</a>
              <a href="#">Brewtica Foundation</a><a href="#">Policies and reports</a><a href="#">Download our app</a>
          </div>
          <div class="col-md-4 mb-4">
              <h6>For business</h6>
              <a href="#">Coffee Solutions</a><a href="#">What we offer</a><a href="#">Contact us</a><a href="#">About us</a>
          </div>
          <div class="col-md-4 mb-4">
              <h6>Contact us</h6>
              <a href="#">FAQs</a><a href="#">Contact us</a><a href="#">Press</a><a href="#">Careers</a>
          </div>
      </div>
    </div>
  </footer>

  <footer class="footer-bottom">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-4 text-start"><a href="#">Privacy policy</a></div>
        <div class="col-4 text-center"><a href="#">Cookie policy</a></div>
        <div class="col-4 text-end"><a href="#">Terms and conditions</a></div>
      </div>
      <div class="text-center">
        <p class="mb-5">&copy; 2025 Costa. All rights reserved.</p>
        <div class="social-icons d-flex justify-content-center mb-5">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-x-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-tiktok"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
          <a href="#"><i class="fab fa-pinterest-p"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="<?= base_url('scripts/script_profile.js') ?>"></script>

  <!-- <script>
    function removeFavorite(icon){
      const productId = icon.dataset.productId;

      fetch('delete_favorite.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}`
      })
      .then(res => res.text())
      .then(data => {
        if (data.trim() === 'success') {
          // icon.closest('.account-product-card').remove();
          location.reload();
        }
      })
      .catch(err => console.error('Error:' . err));
    }
  </script> -->

  <!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        // لما المستخدم يضغط على أيقونة القلب ❤️
        document.querySelectorAll(".account-favorite-icon").forEach(icon => {
            icon.addEventListener("click", () => {
                const productId = icon.dataset.productId;

                fetch("delete_favorite.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `product_id=${productId}`
                })
                .then(res => res.text())
                .then(data => {
                    console.log("Response:", data); // 🔍 بس علشان تتأكد أثناء التجربة

                    if (data.trim() === "success") {
                        // ✅ هنا هنعمل تحديث للصفحة فورًا بعد نجاح الحذف
                        window.location.reload(true); // force reload من السيرفر مش الكاش
                    }
                })
                .catch(err => console.error("Error:", err));
            });
        });
    });
  </script> -->

  <!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".account-favorite-icon").forEach(icon => {
            icon.addEventListener("click", (e) => {
                e.preventDefault(); // ✅ يمنع أي تصرف افتراضي ممكن يوقف الـ reload
                e.stopPropagation(); // ✅ يمنع أي كود تاني من التدخل

                const productId = icon.dataset.productId;

                fetch("delete_favorite.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `product_id=${productId}`
                })
                .then(res => res.text())
                .then(data => {
                    console.log("Server:", data);
                    if (data.trim() === "success") {
                        alert("تم حذف المنتج! سيتم تحديث الصفحة الآن"); // ✅ للتأكد إن الجزء ده بيتنفذ
                        window.location.reload(); // 🔁 التحديث الفعلي
                    } else {
                        alert("الرد من السيرفر غير success: " + data);
                    }
                })
                .catch(err => console.error("Error:", err));
            });
        });
    });
  </script> -->
  
  
</body>
</html>