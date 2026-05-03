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
  <!-- Join_B JS -->
  <script src="<?= base_url('scripts/script.js') ?>"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      const params = new URLSearchParams(window.location.search);
      if(params.get('openModal') === 'signinModal'){
          var myModal = new bootstrap.Modal(document.getElementById('signinModal'));
          myModal.show();

          history.replaceState(null, '', window.location.pathname);
      }
    });

    document.getElementById('signinForm').addEventListener('submit', function(e){
      e.preventDefault();

      const errorBox = document.getElementById('loginError');
      errorBox.classList.add('d-none');
      errorBox.textContent = '';

      const formData = new FormData(this);

      fetch('/sign_in_B', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success){
          if(data.role === 'admin'){
            window.location.href = '/dashboard_B';
          } else {
            window.location.href = '/';
          }

        } else {
          // alert(data.message);
          errorBox.textContent = data.message;
          errorBox.classList.remove('d-none');
        }
      })
      .catch(err => {
        console.error(err);
        alert('somthing went wrong');
      });
    });
  </script>
  
</body>
</html>