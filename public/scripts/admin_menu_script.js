// Toast Handling
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

document.addEventListener("DOMContentLoaded", function(){
    var subModal = document.getElementById('subModal');
    if (subModal) {
        subModal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;
            var mainId = button.getAttribute('data-main-id');
            var input = subModal.querySelector('#mainCategoryId');
            input.value = mainId;
        });
    }

    var addProductModal = document.getElementById('addProduct');
    if (addProductModal) {
        addProductModal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;
            if (!button) return;
            var subCategoryId = button.getAttribute('data-sub-id');
            var input = addProductModal.querySelector('#subCategoryId');
            input.value = subCategoryId;
        });
    }

    var $sub_sub_modal = document.getElementById('sub_sub_modal');
    if ($sub_sub_modal) {
        $sub_sub_modal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;
            var subSubCategotyID = button.getAttribute('data-card-id');
            var input = $sub_sub_modal.querySelector('#subSubCategoryId');
            input.value = subSubCategotyID;
        });
    }

    var $update_user_modal = document.getElementById('updateUser');
    if ($update_user_modal) {
        $update_user_modal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;
            var userID = button.getAttribute('user-id');
            var input = $update_user_modal.querySelector('#userUpdateId');
            input.value = userID;
        });
    }
});

// Add new product to the table without reloading
function addItemToTable(item) {
    // إنشاء الصف الجديد
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${item.id}</td>
        <td>${item.name}</td>
        <td>${item.description}</td>
        <td class="actions">
            <button class="edit open-item" 
                data-bs-toggle="modal"
                data-bs-target="#addProduct"
                data-title="Update Product"
                data-item-id="${item.id}">
                Edit
            </button>
            <button class="delete" data-item-id="${item.id}">Delete</button>
        </td>
    `;

    // تحديد tbody الخاص بالـ sub_sub_category
    const tableBody = document.querySelector(
        `.btn-add-item[data-sub-id="${item.sub_sub_category_id}"]`
    )?.previousElementSibling.querySelector('tbody');

    if (tableBody) {
        // إضافة الصف في أول الجدول
        tableBody.append(row);
    } else {
        console.warn('Table not found for sub_sub_id:', item.sub_sub_category_id);
    }
}

// Add New Product
document.getElementById('addProductForm').addEventListener('submit', function(e){

    const modal = document.getElementById('addProduct');
    const modalInstance = bootstrap.Modal.getInstance(modal);

    if(this.itemId && this.itemId.value){
        e.preventDefault();
        return;
    }

    e.preventDefault();

    const formData = new FormData(this);

    fetch('/admin_menu', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            addItemToTable(data.product);
            // form.reset();
            // modal.hide();
            this.reset();
            modalInstance.hide();
            // window.location.reload();
            showToast('Product Added', 'success');
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
    const modalEl = document.getElementById('addProduct');
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
        const id = btn.dataset.itemId;

        form.reset();
        errorDiv.style.display = 'none';
        setLoading(true);
        modal.show();

        fetch('/menu_api?action=fetch', {
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

            // نخزن الـ id جوه input hidden
            form.item_id.value = item.id;

            // البيانات الأساسية
            document.getElementById('name').value = item.name;
            document.getElementById('desc').value = item.description;
            document.getElementById('ing').value = item.ingredients;

            // الأسعار (من غير "$")
            form.priceS.value = item.prices.small || '';
            form.priceM.value = item.prices.medium || '';
            form.priceL.value = item.prices.large || '';
        })
        .catch(err => {
            errorDiv.textContent = 'Network error: ' +err.message;
            errorDiv.style.display = 'block';
        })
        .finally(()=> setLoading(false));
    });

    // ============= Submit (Update) =============
    form.addEventListener('submit', e => {
        if (!form.item_id.value) return; // 👈 لو مفيش item_id يبقى Add مش Update

        e.preventDefault();
        errorDiv.style.display = 'none';
        setLoading(true);

        const data = new FormData(form); // 👈 عشان الصور

        fetch('/menu_api?action=update', {
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

            // نحدث الصف في الجدول
            const btn = document.querySelector('.open-item[data-item-id="'+form.item_id.value+'"]');
            if (btn) {
                const row = btn.closest('tr');
                if (row) {
                    if (row.querySelector('td:nth-child(2)')) {
                        row.querySelector('td:nth-child(2)').textContent = form.name.value;
                    }
                    if (row.querySelector('td:nth-child(3)')) {
                        row.querySelector('td:nth-child(3)').textContent = form.desc.value;
                    }
                }
            }

            showToast('Item Updated', 'edit');
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
    const addToStaffModal = document.getElementById('addProduct');
    const form = document.getElementById('addProductForm');
    const errorDiv = document.getElementById('formError');

    // لأي زرار هيفتح المودال
    document.querySelectorAll('[data-bs-target="#addProduct"]').forEach(button => {
        button.addEventListener('click', function(){
            const modalTitle = button.getAttribute('data-title') || 'Form';
            addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
            errorDiv.style.display = 'none';

            // لو الزرار Add → فضي الفورم
            if (button.classList.contains('btn-add-item')) {
                form.reset();
                document.getElementById('itemId').value = "";
            }
            // لو Edit → سيب الفورم فاضي لحد الـ fetch يعبيه
        });
    });
});

// Delete Item
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("confirmationModal");
    const confirmBtn = document.getElementById("confirmRemoveBtn");
    const closeBtn = document.querySelector(".close-button");
    const cancelBtn = document.getElementById("cancelRemoveBtn");

    // document.querySelectorAll(".delete").forEach(button => {
    //     button.addEventListener("click", (e) => {
    //         e.preventDefault();
    //         e.stopPropagation();

    //         const itemId = button.dataset.itemId;

    //         confirmBtn.dataset.itemId = itemId;

    //         modal.style.display = "block";
    //     })
    // })

    document.addEventListener("click", e => {
        const deleteBtn = e.target.closest(".delete");

        if(!deleteBtn) return;

        e.preventDefault();
        e.stopPropagation();

        const itemId = deleteBtn.dataset.itemId;
        confirmBtn.dataset.itemId = itemId;
        modal.style.display = "block";
    })

    const closeModal = () => {
        modal.style.display = "none";
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    confirmBtn.addEventListener('click', () => {
        const itemId = confirmBtn.dataset.itemId;

        fetch('/delete_item', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `item_id=${itemId}`
        })
        .then(res => res.json())
        .then(data => {
            console.log("Server Response:", data);

            if(data.success){
                closeModal();
                showToast('Item Deleted', 'delete');

                // window.location.reload();

                document.querySelector(`button.delete[data-item-id="${itemId}"]`).closest('tr').remove();
            } else {
                alert("Deletion Failed. Server Response: " + data);
                closeModal();
                showToast('Failed', 'error');
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