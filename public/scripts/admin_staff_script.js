// Toast
function showToast(message, type = 'success') {

    const toastEl = document.getElementById('actionToast');
    const toastMessage = document.getElementById('toastMessage');
    const toastIcon = document.getElementById('toastIcon');

    toastMessage.textContent = message;

    // Reset
    toastIcon.textContent = '✓';
    toastIcon.style.background = '#2ecc71';

    if (type === 'delete') {
        toastIcon.textContent = '🗑';
        toastIcon.style.background = '#e74c3c';
    }

    if (type === 'edit') {
        toastIcon.textContent = '✎';
        toastIcon.style.background = '#f1c40f';
    }

    if (type === 'error') {
        toastIcon.textContent = '✕';
        toastIcon.style.background = '#e74c3c';
    }

    const toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });

    toast.show();
}

// Add the new user to the table without reloading
function addUserToTable(user){

    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${user.id}</td>
        <td>${user.fullname}</td>
        <td>${user.email}</td>
        <td class="actions">
            <button class="edit open-item"
                data-bs-toggle="modal"
                data-bs-target="#addEmployee"
                data-title="Update Info"
                data-id="${user.id}">
                Edit
            </button>
            <button class="delete" data-id="${user.id}">Delete</button>
        </td>
    `;

    // تحديد جدول Admin أو Employee
    let tableBody;

    if(user.role === 'admin'){
        tableBody = document.querySelector('.category:nth-of-type(1) tbody');
    } else if(user.role === 'employee'){
        tableBody = document.querySelector('.category:nth-of-type(2) tbody');
    }

    if(tableBody){
        tableBody.append(row);
    }
}

// Add New Admin Or Employee
document.getElementById('addProductForm').addEventListener('submit', function(e){

    const modal = document.getElementById('addEmployee');
    const modalInstance = bootstrap.Modal.getInstance(modal);

    if(this.user_id && this.user_id.value){
        e.preventDefault();
        return;
    }

    e.preventDefault();

    const formData = new FormData(this);

    fetch('/staff', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            addUserToTable(data.user);
            // form.reset();
            // modal.hide();
            this.reset();
            modalInstance.hide();
            // window.location.reload();
            showToast('User Added', 'success');
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('somthing went wrong');
    });
});

// Fetch and Update Data
document.addEventListener('DOMContentLoaded', () => {
    const modalEl = document.getElementById('addEmployee');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('addProductForm');
    const errorDiv = document.getElementById('formError');
    const spinner = document.getElementById('modalSpinner');
    const saveBtn = document.getElementById('saveBtn');

    function setLoading(on){
        spinner.style.display = on ? 'block' : 'none';
        saveBtn.disabled = on;
    }

    // ============= الكود الخاص بالـ Edit بس =============
    document.addEventListener('click', e => {
        const btn = e.target.closest('.open-item'); // زرار Edit بس
        if(!btn) return; // لو مش ضاغط على Edit → اخرج
        const id = btn.dataset.id;

        form.reset();
        errorDiv.style.display = 'none';
        setLoading(true);
        modal.show();

        fetch('/staff_api?action=fetch', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        })
        .then(r => r.json())
        .then(data => {
            if(!data.success) {
                errorDiv.textContent = data.error || 'Error Fetching Data';
                errorDiv.style.display = 'block';
                return;
            }
            const item = data.data;
            document.getElementById('user_id').value = item.id;
            form.fullname.value = item.f_name + " " + item.l_name;
            form.email.value = item.email;
            form.password.value = ".........";
            form.confirm_password.value = ".........";
            form.role.value = item.role;
        })
        .catch(err => {
            errorDiv.textContent = 'Network error: ' +err.message;
            errorDiv.style.display = 'block';
        })
        .finally(()=> setLoading(false));
    });

    // برضه الـ submit ده للـ Edit بس
    form.addEventListener('submit', e => {
        if (!form.user_id.value) return; // 👈 الشرط هنا: لو مفيش user_id يبقى Add → تجاهل الكود كله

        e.preventDefault(); 
        errorDiv.style.display = 'none';
        setLoading(true);

        const data = new URLSearchParams(new FormData(form));

        fetch('/staff_api?action=update', {
            method: 'POST',
            body: data
        })
        .then(r => r.json())
        .then(res => {
            if (!res.success) {
                errorDiv.textContent = res.error || 'خطأ أثناء الحفظ';
                errorDiv.style.display = 'block';
                return;
            }

            modal.hide();

            const btn = document.querySelector(
                '.open-item[data-id="'+form.user_id.value+'"]'
            );

            if (btn) {
                const row = btn.closest('tr');
                if (row) {
                    // الاسم
                    row.querySelector('td:nth-child(2)').textContent = form.fullname.value;
                    
                    // الإيميل
                    row.querySelector('td:nth-child(3)').textContent = form.email.value;
                }
            }

            showToast('User Updated', 'edit');
        })
        .catch(err => {
            errorDiv.textContent = 'Network error: '+err.message;
            errorDiv.style.display = 'block';
        })
        .finally(() => setLoading(false));
    });
});

// Change The Title Of Modal + Reset form if Add
document.addEventListener("DOMContentLoaded", function(){
    const addToStaffModal = document.getElementById('addEmployee');
    const form = document.getElementById('addProductForm');
    const errorDiv = document.getElementById('formError');

    // لأي زرار هيفتح المودال
    document.querySelectorAll('[data-bs-target="#addEmployee"]').forEach(button => {
        button.addEventListener('click', function(){
            const modalTitle = button.getAttribute('data-title') || 'Form';
            addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
            errorDiv.style.display = 'none';

            // لو الزرار Add → فضي الفورم
            if (button.classList.contains('btn-add-item')) {
                form.reset();
                document.getElementById('user_id').value = "";
            }
            // لو Edit → سيب الفورم فاضي لحد الـ fetch يعبيه
        });
    });
});

// Delete User
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("confirmationModal");
    const confirmBtn = document.getElementById("confirmRemoveBtn");
    const closeBtn = document.querySelector(".close-button");
    const cancelBtn = document.getElementById("cancelRemoveBtn");

    // document.querySelectorAll(".delete").forEach(button => {
    //     button.addEventListener("click", (e) => {
    //         e.preventDefault();
    //         e.stopPropagation();

    //         const ID = button.dataset.id;

    //         confirmBtn.dataset.id = ID;

    //         modal.style.display = "block";
    //     })
    // })

    document.addEventListener("click", e => {
        const deleteBtn = e.target.closest(".delete");

        if(!deleteBtn) return;

        e.preventDefault();
        e.stopPropagation();

        const ID = deleteBtn.dataset.id;
        confirmBtn.dataset.id = ID;
        modal.style.display = "block";
    })

    const closeModal = () => {
        modal.style.display = "none";
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    confirmBtn.addEventListener('click', () => {
        const ID = confirmBtn.dataset.id;

        fetch('/delete_user', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `user_id=${ID}`
        })
        .then(res => res.text())
        .then(data => {
            console.log("Server Response:", data);

            if(data.trim() === "success"){
                closeModal();
                showToast('User Deleted', 'delete');

                // window.location.reload();

                document.querySelector(`button.delete[data-id="${ID}"]`).closest('tr').remove();
            } else {
                alert("Deletion Failed. Server Response: " + data);
                closeModal();
                showToast('Failed to add product', 'error');
            }
        })
        .catch(err => {
            console.error("Fetch Error: ", err);
            alert("An error occurred while connecting to the server.");
            closeModal();
        });
    });

    // Close the modal if the user clicks outside of it.
        window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
});