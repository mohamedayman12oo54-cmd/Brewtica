<div class="scroll-paper" id="scrollPaper">
    <div class="scroll-content" id="scrollContent">
        <div class="intro-text">
            <p><strong>Welcome to Brewtica — where every sip tells a story.</strong><br>
            Our café blends passion, flavor, and warmth in every cup.</p>
        </div>
        <div class="intro-question">
            Would you like to join our cozy community?
        </div>
        <button class="open-btn" id="openScroll">Join Now!</button>
    </div>
    <form class="signup-form" id="signup_form">
        <div class="mb-3">
            <label for="fullname" class="form-label custom-label">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="form-control custom-input" required>
            <div class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label custom-label">Email</label>
            <input type="email" id="email" name="email" class="form-control custom-input" required>
            <div class="invalid-feedback"></div>
        </div>
        <!-- <div class="mb-3">
            <label for="phone" class="form-label custom-label">Phone</label>
            <input type="tel" id="phone" class="form-control custom-input" required>
        </div> -->
        <div class="mb-3">
            <label for="password" class="form-label custom-label">Password</label>
            <input type="password" id="password" name="password" class="form-control custom-input" required>
            <div class="invalid-feedback"></div>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label custom-label">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control custom-input" required>
            <div class="invalid-feedback"></div>
        </div>
        <div class="text-start mt-3">
            <button type="submit" class="btn btn-rounded">Create</button>
        </div>
    </form>
</div>