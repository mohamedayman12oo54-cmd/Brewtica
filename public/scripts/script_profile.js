// MY Account
document.addEventListener('DOMContentLoaded', () => {
    // 1. Populate Date of Birth Fields (Day, Month, Year)
    const daySelect = document.getElementById('day');
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    
    const defaultDay = userDate?.day ?? null;
    const defaultMonth = userDate?.month ?? null;
    const defaultYear = userDate?.year ?? null;

    // Function to create dropdown options
    const createOptions = (selectElement, start, end, selectedValue) => {
        for (let i = start; i <= end; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            if (i === selectedValue) {
                option.selected = true;
            }
            selectElement.appendChild(option);
        }
    };

    // Populate Days (1-31)
    createOptions(daySelect, 1, 31, defaultDay);

    // Populate Months (1-12)
    createOptions(monthSelect, 1, 12, defaultMonth);

    // Populate Years (Current year down to 100 years ago)
    const currentYear = new Date().getFullYear();
    createOptions(yearSelect, currentYear - 100, currentYear, defaultYear); 

    // 2. Sidebar Dropdown Toggle Functionality
    // Note: We select based on the general class and traverse the DOM
    // const dropdownToggles = document.querySelectorAll('.account-sidebar .account-dropdown-toggle');

    // dropdownToggles.forEach(toggle => {
    //     toggle.addEventListener('click', (e) => {
    //         e.preventDefault();
    //         const parentLi = toggle.closest('li');
    //         const submenu = parentLi.querySelector('.account-submenu');

    //         if (submenu) {
    //             // Toggle the 'account-active-submenu' class to show/hide the menu
    //             submenu.classList.toggle('account-active-submenu');
                
    //             // Change the icon (up/down arrow)
    //             const icon = toggle.querySelector('.fas.fa-caret-up, .fas.fa-caret-down');
    //             if (icon) {
    //                 if (submenu.classList.contains('account-active-submenu')) {
    //                     icon.classList.replace('fa-caret-down', 'fa-caret-up');
    //                 } else {
    //                     icon.classList.replace('fa-caret-up', 'fa-caret-down');
    //                 }
    //             }
    //         }
    //     });
    // });

    // 3. Prevent default form submission (for demonstration purposes)
    // const form = document.getElementById('personalInfoForm');
    // form.addEventListener('submit', (e) => {
    //     e.preventDefault();
    //     alert('Form submission successfully simulated!');
    // });
});

// Wish List
document.addEventListener('DOMContentLoaded', () => {

    // 1. Sidebar Dropdown Toggle Functionality
    const dropdownToggles = document.querySelectorAll('.account-sidebar .account-dropdown-toggle');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const parentLi = toggle.closest('li');
            const submenu = parentLi.querySelector('.account-submenu');

            if (submenu) {
                submenu.classList.toggle('account-active-submenu');
                
                const icon = toggle.querySelector('.fas.fa-caret-up, .fas.fa-caret-down');
                if (icon) {
                    if (submenu.classList.contains('account-active-submenu')) {
                        icon.classList.replace('fa-caret-down', 'fa-caret-up');
                    } else {
                        icon.classList.replace('fa-caret-up', 'fa-caret-down');
                    }
                }
            }
        });
    });

    // 2. Clickable Heart Icon Functionality
    
    // const clickableHearts = document.querySelectorAll('.clickable-heart');

    // if (clickableHearts) {
    //     clickableHearts.forEach(heart => {
    //         heart.addEventListener('click', () => {
    //             const productId = heart.dataset.productId;
    //             alert(`Heart icon for Product ID: ${productId} clicked! You can implement your logic here.`);
    //             // Example: Toggle a class to change its appearance or send an AJAX request
    //             // heart.classList.toggle('account-heart-active'); 
    //         });
    //     });
    // }

    // 3. Add to Cart (Placeholder functionality)
    const addToCartButtons = document.querySelectorAll('.account-btn-add-to-cart-sm');
    addToCartButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const productName = btn.closest('.account-product-card').querySelector('.account-product-name').textContent;
            alert(`"${productName}" added to cart!`);
        });
    });

    // 4. Search Favorites (Placeholder functionality)
    const searchFavoritesInput = document.querySelector('.account-search-favorites input');
    if (searchFavoritesInput) {
        searchFavoritesInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            console.log(`Searching for: ${searchTerm}`);
            // Here you would implement actual filtering logic for your products
            // For example:
            // const productCards = document.querySelectorAll('.account-product-card');
            // productCards.forEach(card => {
            //     const productName = card.querySelector('.account-product-name').textContent.toLowerCase();
            //     if (productName.includes(searchTerm)) {
            //         card.style.display = 'block';
            //     } else {
            //         card.style.display = 'none';
            //     }
            // });
        });
    }
});

// Remove From Wish List
document.addEventListener("DOMContentLoaded", () => {
    
    // ⭐️ عناصر النافذة التأكيدية
    const modal = document.getElementById("confirmationModal");
    const confirmBtn = document.getElementById("confirmRemoveBtn");
    const closeBtn = document.querySelector(".close-button");
    const cancelBtn = document.getElementById("cancelRemoveBtn");
    
    // 1. فتح النافذة التأكيدية عند النقر على القلب
    document.querySelectorAll(".account-favorite-icon").forEach(icon => {
        icon.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            const productId = icon.dataset.productId;
            
            // ⭐️ تمرير الـ ID إلى زر التأكيد في النافذة
            confirmBtn.dataset.productId = productId;
            
            // ⭐️ عرض النافذة
            modal.style.display = "block"; 
        });
    });

    // 2. إغلاق النافذة عند الضغط على X أو Cancel
    const closeModal = () => {
        modal.style.display = "none";
    };

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // 3. إرسال طلب الحذف عند الضغط على زر "Remove"
    confirmBtn.addEventListener("click", () => {
        
        const productId = confirmBtn.dataset.productId;
        
        // 💡 يمكنك إضافة كود لاختيار العنصر الأب هنا إذا كنت تريد حذفه من الـ DOM مباشرة (الخيار الأفضل)
        // const productCard = document.querySelector([data-product-id="${productId}"]).closest('.product-card-selector');

        fetch('/delete_favorite', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}`
        })
        .then(res => res.text())
        .then(data => {
            console.log("Server Response:", data);
            
            // ⭐️ تحقق من الرد (بعد تعديل كود PHP لطباعة 'success')
            if (data.trim() === "success") {
                // ⭐️ إغلاق النافذة قبل التحديث لتبدو العملية فورية
                closeModal(); 
                
                // ⭐️ التحديث التلقائي للصفحة
                window.location.reload(); 
                
                // --- أو الخيار الأفضل: الحذف من الـ DOM مباشرة ---
                // if (productCard) productCard.remove();
            } else {
                alert("فشل الحذف. الرد من السيرفر: " + data);
                closeModal(); 
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            alert("حدث خطأ أثناء الاتصال بالسيرفر.");
            closeModal(); 
        });
    });
    
    // إغلاق النافذة إذا ضغط المستخدم خارجها
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
});

// Initialize tooltips (optional, but good practice for info icons)
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Example for quantity controls (you'd enhance this with actual logic)
// document.querySelectorAll('.coffee-cart-qty-plus').forEach(button => {
//     button.addEventListener('click', () => {
//         let input = button.previousElementSibling;
//         input.value = parseInt(input.value) + 1;
//         // Add logic here to update total price
//     });
// });

// document.querySelectorAll('.coffee-cart-qty-minus').forEach(button => {
//     button.addEventListener('click', () => {
//         let input = button.nextElementSibling;
//         if (parseInt(input.value) > 1) {
//             input.value = parseInt(input.value) - 1;
//             // Add logic here to update total price
//         }
//     });
// });

// document.addEventListener('DOMContentLoaded', function() {
//     const sizeButtons = document.querySelectorAll('.coffee-cart-size-btn');

//     sizeButtons.forEach(button => {
//         button.addEventListener('click', function() {
            
//             // 1. تحديد بطاقة المنتج (الأب) باستخدام الكلاس الفريد
//             const parentCard = this.closest('.coffee-cart-item-card');

//             // 2. إذا لم يتم العثور على الأب، نوقف الدالة
//             if (!parentCard) return; 

//             // 3. البحث عن جميع أزرار الحجم داخل بطاقة المنتج الحالية فقط
//             const buttonsInCurrentCard = parentCard.querySelectorAll('.coffee-cart-size-btn');

//             // 4. إزالة كلاس التفعيل فقط من الأزرار الموجودة في بطاقة المنتج الحالية
//             buttonsInCurrentCard.forEach(btn => {
//                 btn.classList.remove('coffee-cart-size-active');
//             });

//             // 5. إضافة كلاس التفعيل إلى الزر الذي تم الضغط عليه
//             this.classList.add('coffee-cart-size-active');
            
//             console.log('Size selection updated successfully for one item.');
//         });
//     });
// });


document.querySelectorAll(".size_btn").forEach(button => {
    button.addEventListener("click", function () {
        const newSize = this.dataset.newSize;
        const oldSize = this.dataset.oldSize;
        const productId = this.dataset.productId;

        if(newSize === oldSize){
            window.location.reload();
            return;
        }

        fetch('/update_size', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}&old_size=${oldSize}&new_size=${newSize}`
        })
        .then(res => res.json())
        .then(data => {

            if(data.success){
                window.location.reload();
            } else {
                alert("Update Failed. The response from the server: " + data.message);
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            alert("An error occurred while connecting to the server.");
        })
    })
})

document.querySelectorAll(".action_btn").forEach(button => {
    button.addEventListener("click", function () {
        const productId = this.dataset.productId;
        const quantityAction = this.dataset.quantityAction;
        const size = this.dataset.size;

        fetch('/update_quantity', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}&quantity_action=${quantityAction}&size=${size}`
        })
        .then(res => res.json())
        .then(data => {

            if(data.success){
                window.location.reload();
            } else {
                alert("Update Failed. The response from the server: " + data.message);
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            alert("An error occurred while connecting to the server.");
        })
    })
})

document.querySelectorAll(".bag-remove-btn").forEach(btn => {
    btn.addEventListener("click", function (){
        const productId = this.dataset.productId;
        const size = this.dataset.size;

        fetch('/remove_from_bag', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}&size=${size}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                window.location.reload();
            } else {
                alert("Delete Failed. The response from the server: " + data.message);
            }
        })
        .catch(err => {
            console.error("Fetch Error:", err);
            alert("An error occurred while connecting to the server.");
        })
    })
})

// document.addEventListener('DOMContentLoaded', () => {
//     const checkboxes = document.querySelectorAll('.cart-item-check');
//     const subTotalEl = document.getElementById('subTotal');
//     const totalEl = document.getElementById('total');
//     // const deliveryFee = <?= ?>
//     const taxRate = 0.14;

//     function calculateBill(){
//         let subTotal = 0;

//         checkboxes.forEach(cb => {
//             if(cb.checked){
//                 subTotal += parseFloat(cb.dataset.price)
//             }
//         });

//         let tax = subTotal * taxRate;
//         let total = subTotal + tax + deliveryFee;

//         subTotalEl.textContent = subTotal.toFixed(2) + '$';
//         totalEl.textContent = total.toFixed(2) + '$';


//     }
//     checkboxes.forEach(cb => {
//         cb.addEventListener('change', calculateBill);
//     });
// });


// checkbox of products in bag
document.querySelectorAll('.cart-item-check').forEach(cb => {
    cb.addEventListener('change', function () {

        const productId = this.dataset.productId;
        const size = this.dataset.size;
        const checked = this.checked ? 1 : 0;

        fetch('/toggle_cart_item_check', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${productId}&size=${size}&checked=${checked}`
        })
        .then(() => {
            window.location.reload();
        });

    });
});

// favourite Button in Bag 
document.getElementById("goBtn").addEventListener("click", function () {
    window.location.href = "/fav_list_B";
})