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

// Send Categories id to Form

    // Sub Categories
    document.addEventListener("DOMContentLoaded", function(){
        var subModal = document.getElementById('subModal');

        subModal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;
            var mainId = button.getAttribute('data-main-id');
            var input = subModal.querySelector('#mainCategoryId');
            
            input.value = mainId;
        });

        var addProductModal = document.getElementById('addProduct');

        addProductModal.addEventListener('show.bs.modal', function(event){
            var button = event.relatedTarget;

            var subCategoryId = button.getAttribute('data-sub-id');
            var input = addProductModal.querySelector('#subCategoryId');

            input.value = subCategoryId;
        });

    }); 
    // Sub-Sub Categories
    document.addEventListener("DOMContentLoaded", function() {

        // 1. عنصر المودال
        var subSubModal = document.getElementById('sub_sub_modal');

        if (subSubModal) {
            subSubModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // الزر اللي فتح المودال
            console.log('[DEBUG] relatedTarget (button):', button);

            // اقرأ الـ data attribute
            var subId = button ? button.getAttribute('data-card-id') : null;
            console.log('[DEBUG] data-card-id:', subId);

            // جلب الـ hidden input داخل نفس المودال
            var input = subSubModal.querySelector('#subSubCategoryId');
            console.log('[DEBUG] hidden input element:', input);

            if (input) {
                input.value = subId || '';
                console.log('[DEBUG] hidden input value after set:', input.value);
            } else {
                console.error('[ERROR] hidden input not found inside modal!');
            }
            });
        } else {
            console.warn('[WARN] sub_sub_modal element not found on page.');
        }

        // حماية لباقي الكود: تأكد إن أي مودال تاني تستخدمه موجود قبل addEventListener
        var updateUserModal = document.getElementById('updateUser');
        if (updateUserModal) {
            updateUserModal.addEventListener('show.bs.modal', function(event){ /* ... */ });
        }

    });

// End Send

// Change The Title Of Modal + Reset form if Add

    //Main Category
    document.addEventListener("DOMContentLoaded", function(){
        const addToStaffModal = document.getElementById('mainModal');
        const form = document.getElementById('main_category_form');
        const errorDiv = document.getElementById('formError');

        // لأي زرار هيفتح المودال
        document.querySelectorAll('[data-bs-target="#mainModal"]').forEach(button => {
            button.addEventListener('click', function(){
                const modalTitle = button.getAttribute('modal-title') || 'Form';
                addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
                errorDiv.style.display = 'none';

                // لو الزرار Add → فضي الفورم
                if (button.classList.contains('btn-add-main')) {
                    form.reset();
                    document.getElementById('mainId').value = "";
                }
                // لو Edit → سيب الفورم فاضي لحد الـ fetch يعبيه
            });
        });
    });
    // Sub Category
    document.addEventListener("DOMContentLoaded", function(){
        const addToStaffModal = document.getElementById('subModal');
        const form = document.getElementById('sub_category_form');
        const errorDiv = document.getElementById('formError');

        // لأي زرار هيفتح المودال
        document.querySelectorAll('[data-bs-target="#subModal"]').forEach(button => {
            button.addEventListener('click', function(){
                const modalTitle = button.getAttribute('modal-title') || 'Form';
                addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
                errorDiv.style.display = 'none';

                // لو الزرار Add → فضي الفورم
                if (button.classList.contains('btn-add-sub')) {
                    form.reset();
                    document.getElementById('subId').value = "";
                }
                // لو Edit → سيب الفورم فاضي لحد الـ fetch يعبيه
            });
        });
    });
    //Sub-Sub Category
    document.addEventListener("DOMContentLoaded", function(){
        const addToStaffModal = document.getElementById('sub_sub_modal');
        const form = document.getElementById('sub_sub_category_form');
        const errorDiv = document.getElementById('formError');

        // لأي زرار هيفتح المودال
        document.querySelectorAll('[data-bs-target="#sub_sub_modal"]').forEach(button => {
            button.addEventListener('click', function(){
                const modalTitle = button.getAttribute('modal-title') || 'Form';
                addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
                errorDiv.style.display = 'none';

                // لو الزرار Add → فضي الفورم
                if (button.classList.contains('btn-add-sub-sub')) {
                    form.reset();
                    document.getElementById('subSubId').value = "";
                }
                // لو Edit → سيب الفورم فاضي لحد الـ fetch يعبيه
            });
        });
    });

// End Change 

// Delete Categories

    // Delete Main Category
    // document.addEventListener("DOMContentLoaded", function () {
    //     document.querySelectorAll(".delete_main").forEach(button => {
    //         button.addEventListener("click", function () {

    //             const catId = this.getAttribute("main-category-id");
    //             const tableName = this.getAttribute("table-name");

    //             if (!catId) return;

    //             if (confirm("Are you sure you want to delete this category?")) {
    //                 fetch('/delete_category', {
    //                     method: "POST",
    //                     headers: {
    //                         "Content-Type": "application/x-www-form-urlencoded"
    //                     },
    //                     body: new URLSearchParams({
    //                         id: catId,
    //                         table: tableName
    //                     })
    //                 })
    //                 .then(res => res.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         location.reload();
    //                     } else {
    //                         alert(data.message);
    //                     }
    //                 })
    //                 .catch(() => {
    //                     alert("Something went wrong");
    //                 });
    //             }
    //         });
    //     });
    // });
    // Delete Sub Category
    // document.addEventListener("DOMContentLoaded", function () {
    //     document.querySelectorAll(".delete_sub").forEach(button => {
    //         button.addEventListener("click", function () {

    //             const catId = this.getAttribute("sub-category-id");
    //             const tableName = this.getAttribute("table-name");

    //             if (!catId) return;

    //             if (confirm("Are you sure you want to delete this category?")) {
    //                 fetch('/delete_category', {
    //                     method: "POST",
    //                     headers: {
    //                         "Content-Type": "application/x-www-form-urlencoded"
    //                     },
    //                     body: new URLSearchParams({
    //                         id: catId,
    //                         table: tableName
    //                     })
    //                 })
    //                 .then(res => res.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         location.reload();
    //                     } else {
    //                         alert(data.message);
    //                     }
    //                 })
    //                 .catch(() => {
    //                     alert("Something went wrong");
    //                 });
    //             }
    //         });
    //     });
    // });
    // Delete Sub-Sub Category
    // document.addEventListener("DOMContentLoaded", function () {
    //     document.querySelectorAll(".delete_sub_sub").forEach(button => {
    //         button.addEventListener("click", function () {

    //             const catId = this.getAttribute("sub-sub-category-id");
    //             const tableName = this.getAttribute("table-name");

    //             if (!catId) return;

    //             if (confirm("Are you sure you want to delete this category?")) {
    //                 fetch('/delete_category', {
    //                     method: "POST",
    //                     headers: {
    //                         "Content-Type": "application/x-www-form-urlencoded"
    //                     },
    //                     body: new URLSearchParams({
    //                         id: catId,
    //                         table: tableName
    //                     })
    //                 })
    //                 .then(res => res.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         location.reload();
    //                     } else {
    //                         alert(data.message);
    //                     }
    //                 })
    //                 .catch(() => {
    //                     alert("Something went wrong");
    //                 });
    //             }
    //         });
    //     });
    // });

    // Delete Category
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("confirmationModal");
        const confirmBtn = document.getElementById("confirmRemoveBtn");
        const closeBtn = document.querySelector(".close-button");
        const cancelBtn = document.getElementById("cancelRemoveBtn");

        // document.querySelectorAll(".delete").forEach(button => {
        //     button.addEventListener("click", (e) => {
        //         e.preventDefault();
        //         e.stopPropagation();

        //         const catId = button.dataset.categoryId; 
        //         const tableName = button.dataset.tableName;

        //         confirmBtn.dataset.categoryId = catId;
        //         confirmBtn.dataset.tableName = tableName;

        //         modal.style.display = "block";
        //     })
        // })

        document.addEventListener("click", e => {
            const deleteBtn = e.target.closest(".delete");

            if(!deleteBtn) return;

            e.preventDefault();
            e.stopPropagation();

            const catId = deleteBtn.dataset.categoryId; 
            const tableName = deleteBtn.dataset.tableName;

            confirmBtn.dataset.categoryId = catId;
            confirmBtn.dataset.tableName = tableName;

            modal.style.display = "block";
        })

        const closeModal = () => {
            modal.style.display = "none";
        }

        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        confirmBtn.addEventListener('click', () => {
            // const itemId = confirmBtn.dataset.itemId;
            const catId = confirmBtn.dataset.categoryId;
            const tableName = confirmBtn.dataset.tableName;

            fetch('/delete_category', {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${catId}&table=${tableName}`
            })
            .then(res => res.json())
            .then(data => {
                console.log("Server Response:", data);

                if(data.success){
                    closeModal();
                    showToast('Category Deleted', 'delete');

                    // window.location.reload();

                    // document.querySelector(`button.delete[data-item-id="${itemId}"]`).closest('tr').remove();

                    const btnToRemove = document.querySelector(`[data-category-id="${catId}"][data-table-name="${tableName}"]`);
                    if(btnToRemove){
                        // نشوف أقرب عنصر شامل للكارت
                        const cardDiv = btnToRemove.closest('.category-card, .main-category, li');
                        if(cardDiv) cardDiv.remove();
                    }

                } else {
                    alert("Deletion Failed. Server Response: " + data.message);
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

// End Delete

// Add new category without reloading
function addCategory(category) {

    /* ========== MAIN CATEGORY ========== */
    if (category.type === 'main') {

        const main = document.createElement('div');
        main.className = 'main-category';

        main.innerHTML = `
            <div class="main-category-header d-flex justify-content-between align-items-center">
                <h2>${category.name}</h2>
                <div class="action-buttons">
                    <button class="open-main"
                        data-bs-toggle="modal"
                        data-bs-target="#mainModal"
                        modal-title="Update Main Category"
                        table-name="main_categories"
                        main-category-id="${category.id}">
                        <i class='bx bx-edit'></i>
                    </button>
                    <button class="delete_main delete"
                        data-category-id="${category.id}"
                        data-table-name="main_categories">
                        <i class='bx bx-trash'></i>
                    </button>
                </div>
            </div>

            <div class="main-category-body"></div>

            <div class="d-flex justify-content-between align-items-center mt-2">
                <button class="btn-add-sub"
                    data-bs-toggle="modal"
                    data-bs-target="#subModal"
                    modal-title="Add Sub Category"
                    data-main-id="${category.id}">
                    <i class='bx bx-plus'></i> Add Sub Category
                </button>
            </div>
        `;

        document.querySelector('#content main').append(main);
        return;
    }

    /* ========== SUB CATEGORY ========== */
    if (category.type === 'sub') {

        const mainCategory = document.querySelector(
            `.btn-add-sub[data-main-id="${category.main_category_id}"]`
        )?.closest('.main-category');

        if (!mainCategory) return;

        const card = document.createElement('div');
        card.className = 'category-card mb-3';

        card.innerHTML = `
            <div class="category-header d-flex justify-content-between align-items-center">
                <h3>${category.name}</h3>
                <div class="d-flex align-items-center">
                    <div class="action-buttons me-2">
                        <button class="open-sub"
                            data-bs-toggle="modal"
                            data-bs-target="#subModal"
                            modal-title="Update Sub Category"
                            table-name="sub_categories"
                            sub-category-id="${category.id}">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button class="delete_sub delete"
                            data-category-id="${category.id}"
                            data-table-name="sub_categories">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                    <button class="btn-add-sub-sub"
                        data-bs-toggle="modal"
                        data-bs-target="#sub_sub_modal"
                        modal-title="Add Sub-Sub Category"
                        data-card-id="${category.id}">
                        <i class='bx bx-plus'></i> Add Sub-Sub Category
                    </button>
                </div>
            </div>

            <ul class="sub-categories">
                <li>No Sub-Sub Categories Yet.</li>
            </ul>
        `;

        mainCategory.querySelector('.main-category-body').append(card);
        return;
    }

    /* ========== SUB-SUB CATEGORY ========== */
    if (category.type === 'sub-sub') {

        const ul = document.querySelector(
            `.btn-add-sub-sub[data-card-id="${category.sub_category_id}"]`
        )?.closest('.category-card')
         ?.querySelector('.sub-categories');

        if (!ul) return;

        const empty = ul.querySelector('li:not(.d-flex)');
        if (empty) empty.remove();

        const li = document.createElement('li');
        li.className = 'd-flex justify-content-between align-items-center';

        li.innerHTML = `
            <span class="sub-sub-name">${category.name}</span>
            <div class="action-buttons">
                <button class="open-sub-sub"
                    data-bs-toggle="modal"
                    data-bs-target="#sub_sub_modal"
                    modal-title="Update Sub-Sub Category"
                    table-name="sub_sub_categories"
                    sub-sub-category-id="${category.id}">
                    <i class='bx bx-edit'></i>
                </button>
                <button class="delete_sub_sub delete"
                    data-category-id="${category.id}"
                    data-table-name="sub_sub_categories">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        `;

        ul.append(li);
    }
}

// Add New Category

    // Add Main Category
    document.getElementById('main_category_form').addEventListener('submit', function(e){

        const modal = document.getElementById('mainModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);

        if(this.mainId && this.mainId.value){
            e.preventDefault();
            return;
        }

        e.preventDefault();

        const formData = new FormData(this);

        fetch('/categories', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                addCategory(data.category);
                // form.reset();
                // modal.hide();
                this.reset();
                modalInstance.hide();
                // window.location.reload();
                showToast('Category Added', 'success');
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('somthing went wrong');
        });
    });

    // Add Sub Category
    document.getElementById('sub_category_form').addEventListener('submit', function(e){

        const modal = document.getElementById('subModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);

        if(this.subId && this.subId.value){
            e.preventDefault();
            return;
        }

        e.preventDefault();

        const formData = new FormData(this);

        fetch('/categories', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                addCategory(data.category);
                // form.reset();
                // modal.hide();
                this.reset();
                modalInstance.hide();
                // window.location.reload();
                showToast('Category Added', 'success');
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('somthing went wrong');
        });
    });

    // Add Sub-Sub Category
    document.getElementById('sub_sub_category_form').addEventListener('submit', function(e){

        const modal = document.getElementById('sub_sub_modal');
        const modalInstance = bootstrap.Modal.getInstance(modal);

        if(this.subSubId && this.subSubId.value){
            e.preventDefault();
            return;
        }

        e.preventDefault();

        const formData = new FormData(this);

        fetch('/categories', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                addCategory(data.category);
                // form.reset();
                // modal.hide();
                this.reset();
                modalInstance.hide();
                // window.location.reload();
                showToast('Category Added', 'success');
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert('somthing went wrong');
        });
    });

// End Add

// Fetch and Update Data

    // Fetch and Update Data of Main Category
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('mainModal');
        const modal = new bootstrap.Modal(modalEl);
        const form = document.getElementById('main_category_form');
        const errorDiv = document.getElementById('formError');
        const spinner = document.getElementById('modalSpinner');
        const saveBtn = document.getElementById('saveBtn');

        function setLoading(on){
            spinner.style.display = on ? 'block' : 'none';
            saveBtn.disabled = on;
        }

        // ============= الكود الخاص بالـ Edit بس =============
        document.addEventListener('click', e => {
            const btn = e.target.closest('.open-main'); // زرار Edit بس
            if(!btn) return; // لو مش ضاغط على Edit → اخرج
            const id = btn.getAttribute('main-category-id');

            const table = btn.getAttribute('table-name');

            console.log("ID:", id, "Table:", table);

            // form.setAttribute('data-table', table);

            form.reset();
            errorDiv.style.display = 'none';
            setLoading(true);
            modal.show();

            fetch('/category_api?action=fetch', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'id=' + encodeURIComponent(id) + '&table=' + encodeURIComponent(table)
            })
            .then(r => r.json())
            .then(data => {
                if(!data.success) {
                    errorDiv.textContent = data.error || 'Error Fetching Data';
                    errorDiv.style.display = 'block';
                    return;
                }
                const cat = data.data;

                // نخزن الـ id جوه input hidden
                form.main_id.value = cat.id;

                // البيانات الأساسية
                document.getElementById('mainName').value = cat.name;
            })
            .catch(err => {
                errorDiv.textContent = 'Network error: ' +err.message;
                errorDiv.style.display = 'block';
            })
            .finally(()=> setLoading(false));
        });

        // ============= Submit (Update) =============
        form.addEventListener('submit', e => {
            if (!form.main_id.value) return; // 👈 لو مفيش item_id يبقى Add مش Update

            e.preventDefault();
            errorDiv.style.display = 'none';
            setLoading(true);

            const data = new FormData(form); // 👈 عشان الصور

            fetch('/category_api?action=update', {
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
                showToast('Category Updated', 'edit');

                // Update View
                const btn = document.querySelector('.open-main[main-category-id="'+form.main_id.value+'"]');

                if (btn) {
                    const mainCard = btn.closest('.main-category');
                    if (mainCard) {
                        const title = mainCard.querySelector('h2');
                        if (title) {
                            title.textContent = document.getElementById('mainName').value;
                        }
                    }
                }

            })
            .catch(err => {
                errorDiv.textContent = 'Network error: '+err.message;
                errorDiv.style.display = 'block';
            })
            .finally(() => setLoading(false));
        });
    });
    // Fetch and Update Data of Sup Category
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('subModal');
        const modal = new bootstrap.Modal(modalEl);
        const form = document.getElementById('sub_category_form');
        const errorDiv = document.getElementById('formError');
        const spinner = document.getElementById('modalSpinner');
        const saveBtn = document.getElementById('saveBtn');

        function setLoading(on){
            spinner.style.display = on ? 'block' : 'none';
            saveBtn.disabled = on;
        }

        // ============= الكود الخاص بالـ Edit بس =============
        document.addEventListener('click', e => {
            const btn = e.target.closest('.open-sub'); // زرار Edit بس
            if(!btn) return; // لو مش ضاغط على Edit → اخرج
            const id = btn.getAttribute('sub-category-id');

            const table = btn.getAttribute('table-name')

            console.log("ID:", id, "Table:", table);

            form.reset();
            errorDiv.style.display = 'none';
            setLoading(true);
            modal.show();

            fetch('/category_api?action=fetch', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'id=' + encodeURIComponent(id) + '&table=' + encodeURIComponent(table)
            })
            .then(r => r.json())
            .then(data => {
                if(!data.success) {
                    errorDiv.textContent = data.error || 'Error Fetching Data';
                    errorDiv.style.display = 'block';
                    return;
                }
                const cat = data.data;

                // نخزن الـ id جوه input hidden
                form.sub_id.value = cat.id;

                // البيانات الأساسية
                document.getElementById('subName').value = cat.name;
            })
            .catch(err => {
                errorDiv.textContent = 'Network error: ' +err.message;
                errorDiv.style.display = 'block';
            })
            .finally(()=> setLoading(false));
        });

        // ============= Submit (Update) =============
        form.addEventListener('submit', e => {
            if (!form.sub_id.value) return; // 👈 لو مفيش item_id يبقى Add مش Update

            e.preventDefault();
            errorDiv.style.display = 'none';
            setLoading(true);

            const data = new FormData(form); // 👈 عشان الصور

            fetch('/category_api?action=update', {
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
                showToast('Category Updated', 'edit');

                // Update View
                const btn = document.querySelector('.open-sub[sub-category-id="'+form.sub_id.value+'"]');

                if (btn) {
                    const card = btn.closest('.category-card');
                    if (card) {
                        const title = card.querySelector('h3');
                        if (title) {
                            title.textContent = document.getElementById('subName').value;
                        }
                    }
                }


            })
            .catch(err => {
                errorDiv.textContent = 'Network error: '+err.message;
                errorDiv.style.display = 'block';
            })
            .finally(() => setLoading(false));
        });
    });
    // Fetch and Update Data of Sub-Sub Category
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('sub_sub_modal');
        const modal = new bootstrap.Modal(modalEl);
        const form = document.getElementById('sub_sub_category_form');
        const errorDiv = document.getElementById('formError');
        const spinner = document.getElementById('modalSpinner');
        const saveBtn = document.getElementById('saveBtn');

        function setLoading(on){
            spinner.style.display = on ? 'block' : 'none';
            saveBtn.disabled = on;
        }

        // ============= الكود الخاص بالـ Edit بس =============
        document.addEventListener('click', e => {
            const btn = e.target.closest('.open-sub-sub'); // زرار Edit بس
            if(!btn) return; // لو مش ضاغط على Edit → اخرج
            const id = btn.getAttribute('sub-sub-category-id');

            const table = btn.getAttribute('table-name')

            console.log("ID:", id, "Table:", table);

            form.reset();
            errorDiv.style.display = 'none';
            setLoading(true);
            modal.show();

            fetch('/category_api?action=fetch', {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: 'id=' + encodeURIComponent(id) + '&table=' + encodeURIComponent(table)
            })
            .then(r => r.json())
            .then(data => {
                if(!data.success) {
                    errorDiv.textContent = data.error || 'Error Fetching Data';
                    errorDiv.style.display = 'block';
                    return;
                }
                const cat = data.data;

                // نخزن الـ id جوه input hidden
                form.sub_sub_id.value = cat.id;

                // البيانات الأساسية
                document.getElementById('subSubName').value = cat.name;
            })
            .catch(err => {
                errorDiv.textContent = 'Network error: ' +err.message;
                errorDiv.style.display = 'block';
            })
            .finally(()=> setLoading(false));
        });

        // ============= Submit (Update) =============
        form.addEventListener('submit', e => {
            if (!form.sub_sub_id.value) return; // 👈 لو مفيش item_id يبقى Add مش Update

            e.preventDefault();
            errorDiv.style.display = 'none';
            setLoading(true);

            const data = new FormData(form); // 👈 عشان الصور

            fetch('/category_api?action=update', {
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
                showToast('Category Updated', 'edit');

                // Update View
                const btn = document.querySelector('.open-sub-sub[sub-sub-category-id="'+form.sub_sub_id.value+'"]');

                if (btn) {
                    const li = btn.closest('li');
                    if (li) {
                        const nameEl = li.querySelector('.sub-sub-name');
                        if (nameEl) {
                            nameEl.textContent = form.sub_sub_name.value;
                        }
                    }
                }


            })
            .catch(err => {
                errorDiv.textContent = 'Network error: '+err.message;
                errorDiv.style.display = 'block';
            })
            .finally(() => setLoading(false));
        });
    });

// End Fetch


























// Delete Main Category
// document.addEventListener("DOMContentLoaded", function () {
//     document.querySelectorAll(".delete_main").forEach(button => {
//         button.addEventListener("click", function () {

//             const catId = this.getAttribute("main-category-id");
//             const tableName = this.getAttribute("table-name");

//             if (!catId) return;

//             if (confirm("Are you sure you want to delete this category?")) {
//                 fetch('/delete_category', {
//                     method: "POST",
//                     headers: {
//                         "Content-Type": "application/x-www-form-urlencoded"
//                     },
//                     body: new URLSearchParams({
//                         id: catId,
//                         table: tableName
//                     })
//                 })
//                 .then(res => res.json())
//                 .then(data => {
//                     if (data.success) {
//                         location.reload();
//                     } else {
//                         alert(data.message);
//                     }
//                 })
//                 .catch(() => {
//                     alert("Something went wrong");
//                 });
//             }
//         });
//     });
// });









