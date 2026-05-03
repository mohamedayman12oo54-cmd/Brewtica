<?php

    $user = new User();
    $users = $user->getAllUsers();

?>

<!-- ===== MAIN ===== -->
<section id="content">
    <main>
        <div class="categories">

            <!-- Category -->
            <div class="category">
                <h2 class="category-title">Admins</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <?php if($user->role === 'admin'): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user->id) ?></td>
                                    <td><?= htmlspecialchars($user->f_name . " " . $user->l_name) ?></td>
                                    <td><?= htmlspecialchars($user->email) ?></td>
                                    <td class="actions">
                                        <button class="edit open-item" 
                                            data-bs-toggle="modal" 
                                            name="updateInfo"
                                            data-bs-target="#addEmployee" 
                                            data-title="Update Info"
                                            id="editUserBtn"
                                            data-id = "<?= $user->id ?>">
                                            Edit
                                        </button>     
                                        <button class="delete" data-id = "<?= $user->id ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn-add-item"
                    data-bs-toggle="modal" 
                    data-bs-target="#addEmployee"
                    data-title="Add New Admin">
                    <i class='bx bx-plus'></i>
                    <span>Add New Admin</span>
                </button>
            </div>

            <!-- Category -->
            <div class="category">
                <h2 class="category-title">Employees</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <?php if($user->role === 'employee'): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user->id) ?></td>
                                    <td><?= htmlspecialchars($user->f_name . " " . $user->l_name) ?></td>
                                    <td><?= htmlspecialchars($user->email) ?></td>
                                    <td class="actions">
                                
                                        <button class="edit open-item" 
                                            data-bs-toggle="modal" 
                                            name="updateInfo"
                                            data-bs-target="#addEmployee" 
                                            data-title="Update Info"
                                            id="editUserBtn"
                                            data-id = "<?= $user->id ?>">
                                            Edit
                                        </button>
                                        <button class="delete" data-id = "<?= $user->id ?>">Delete</button>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button class="btn-add-item" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addEmployee"
                    data-title="Add New Employee">
                    <i class='bx bx-plus'></i>
                    <span>Add New Employee</span>
                </button>
            </div>

        </div>
    </main>
</section>

<!-- ===== Add Admin & Employee Modal ===== -->
<div class="modal fade modal_style" id="addEmployee" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark-green text-white">
                <h5 class="modal-title"></h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div id="modalSpinner" class="text-center my-3" style="display:none;">Loading...</div>

            <form id="addProductForm" class="needs-validation">
                <input type="hidden" name="id" id="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input id="fullname" name="fullname" type="text" class="form-control" placeholder="Enter fullname" required>
                        <div class="invalid-feedback">Name is required.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Enter name" required>
                        <div class="invalid-feedback">Email is required.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter password" required>
                        <div class="invalid-feedback">Password is required.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm" class="form-label">Confirm Password</label>
                        <input id="confirm" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" required>
                        <div class="invalid-feedback">Confirm password is required.</div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="" selected disabled>Role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="customer">Customer</option>
                        </select>
                        <div class="invalid-feedback">Role is required.</div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"  name="submit_item" id="saveBtn">Save</button>
                </div>
            </form>

            <div id="formError" class="text-danger mt-2" style="display:none;"></div>

        </div>
    </div>
</div>

<!-- ===== Delete Confirmation Modal ===== -->
<div id="confirmationModal" class="modal confirm-modal">
    <div class="modal-content confirm-modal-content">
        <span class="close-button">&times;</span>
        <h4 class="confirm-title">Confirm Deletion</h4>
        <p class="confirm-text">You are about to permanently delete this user from the system. Do you confirm?</p>

        <button id="confirmRemoveBtn" class="confirm-btn danger" data-id="">Remove</button>
        <button id="cancelRemoveBtn" class="confirm-btn cancel">Cancel</button>
    </div>
</div>

<!-- ===== Toast ===== -->
<div class="toast-container position-fixed top-50 start-50 translate-middle p-3" style="z-index:9999">

    <div id="actionToast" class="toast border-0" role="alert">
        <div class="toast-body text-center">
            <div id="toastIcon" class="toast-icon">✓</div>
            <div id="toastMessage" class="toast-text">Link copied</div>
        </div>
    </div>

</div>

<script src="<?= base_url('scripts/admin_staff_script.js') ?>"></script>