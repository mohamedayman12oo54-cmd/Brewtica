// ===== Sign-In_Modal_Script  =====
const openBtn = document.getElementById('openScroll');
const scrollPaper = document.getElementById('scrollPaper');
const scrollSound = document.getElementById('scrollSound');
const scrollContent = document.getElementById('scrollContent');

openBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    scrollPaper.classList.add('open');
    scrollContent.classList.add('hidden');
    // scrollSound.play();

    scrollSound.currentTime = 0; // علشان يبدأ من الأول كل مرة
    scrollSound.play().catch(err => {
        console.log("Error playing sound:", err);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.getElementById('signup_form');
    if(!signupForm) return; // safety

    // =========================
    // Functions
    // =========================
    function showError(field, message){
        const input = signupForm.querySelector(`[name="${field}"]`);
        if(!input) return; // safety

        input.classList.add('is-invalid');

        const feedback = input.nextElementSibling;
        if(feedback && feedback.classList.contains('invalid-feedback')){
            feedback.textContent = message;
            feedback.classList.add('active');
        }
    }

    function clearErrors(){
        const inputs = signupForm.querySelectorAll('.form-control');
        inputs.forEach(input => input.classList.remove('is-invalid'));

        const feedbacks = signupForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(fb => {
            fb.textContent = '';
            fb.classList.remove('active');
        });
    }

    // =========================
    // Submit listener
    // =========================
    signupForm.addEventListener('submit', function(e){
        e.preventDefault();

        clearErrors(); // دلوقتي آمنة

        const formData = new FormData(this);

        fetch('/join_B', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                window.location.href = '/?openModal=signinModal';
            } else {
                if(data.errors){
                    Object.keys(data.errors).forEach(field => {
                        showError(field, data.errors[field]);
                    });
                } else {
                    alert(data.message);
                }
            }
        })
        .catch(err => {
            console.error(err);
            alert('something went wrong');
        });
    });
});

// ===== Product_Modal_Script  =====

function toggleFavorite(icon) {
    // أولاً نغيّر شكل القلب (تحكم واجهة المستخدم)
    icon.classList.toggle('active');
    if (icon.classList.contains('bi-heart')) {
        icon.classList.remove('bi-heart');
        icon.classList.add('bi-heart-fill');
    } else {
        icon.classList.remove('bi-heart-fill');
        icon.classList.add('bi-heart');
    }

    // ثانياً نقرأ الـ product_id من الـ hidden input
    const productId = document.getElementById('modalProductId').value;

    // لو مفيش id نخرج
    if (!productId) {
        console.error('Product ID not found in modal');
        return;
    }

    // ثالثاً نبعته للباك‌اند (PHP)
    fetch('/favourites_handler', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {

        console.log('FULL RESPONSE:', data);
        console.log('requires_login:', data.requires_login);
        console.log('type:', typeof data.requires_login);

        // 🌟 الخطوة 1: التحقق من تسجيل الدخول أولاً
        if (data.requires_login) {
            // إعادة التوجيه إلى صفحة تسجيل الدخول
            window.location.href = '/?openModal=signinModal'; // 👈 تأكد من صحة هذا المسار
            return; 
        }

        if (data.success) {
            console.log('✅ ' + data.message);
        } else {
            console.error('❌ ' + data.message);
            // رجّع القلب لحالته الأصلية لو فشل
            icon.classList.toggle('active');
            icon.classList.toggle('bi-heart-fill');
            icon.classList.toggle('bi-heart');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        // رجّع الحالة الأصلية
        icon.classList.toggle('active');
        icon.classList.toggle('bi-heart-fill');
        icon.classList.toggle('bi-heart');
    });
}

function addToBag(icon){
    const productId = document.getElementById('modalProductId').value;
    const productSize = document.getElementById('modalProductSize').value;

    if(!productId){
        console.error('Product ID not found in modal');
        return;
    } else if(!productSize){
        console.error('Product Size not found');
        return;
    }

    fetch('/bag_handler', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, product_size: productSize})
    })
    .then(res => res.json())
    .then(data => {
        if (data.requires_login) {
            // إعادة التوجيه إلى صفحة تسجيل الدخول
            window.location.href = '/?openModal=signinModal'; // 👈 تأكد من صحة هذا المسار
            return; 
        }

        if (data.success) {

            console.log('✅ ' + data.message);

        } else {

            console.error('Failed:', data);
        }
        
    })
    .catch(err => {
        console.error('Error:', err);
    });
}

// function toggleFavorite(icon) {
//     // ⚠️ ملاحظة: تم حذف منطق تغيير شكل القلب المبدئي
//     // لأننا سنغيره فقط بعد الحصول على تأكيد من الخادم.

//     // 1. الحصول على Product ID و الرابط الأصلي
//     const productId = document.getElementById('modalProductId').value;
//     // نفترض أنك قمت بتخزين مرجع العنصر الأصلي (<a>) في خاصية بيانات
//     // على زر المفضلة (icon) داخل الـ Modal، كما اتفقنا.
//     const originalLink = icon.dataset.originalLink; 

//     if (!productId || !originalLink) {
//         console.error('Product ID or original link not found.');
//         // يمكن إغلاق الـ Modal أو عرض رسالة خطأ هنا
//         return;
//     }

//     // 2. إرسال الطلب للباك‌اند (PHP)
//     fetch('favorites_handler.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ product_id: productId })
//     })
//     .then(res => res.json())
//     .then(data => {
//         // 🌟 الخطوة 1: التحقق من تسجيل الدخول أولاً
//         if (data.requires_login) {
//             // إعادة التوجيه إلى صفحة تسجيل الدخول
//             window.location.href = 'login.php'; // 👈 تأكد من صحة هذا المسار
//             return; 
//         }

//         // 🌟 الخطوة 2: إذا نجحت العملية (تم التبديل)
//         if (data.success) {
//             console.log('✅ ' + data.message);
            
//             // نفترض أن الخادم يرسل الحالة الجديدة للمفضلة (0 أو 1)
//             const isNowFavorite = data.is_favorite; 

//             // أ. تحديث مظهر الأيقونة فوراً داخل الـ Modal
//             if (isNowFavorite == 1) { // 1 = مفضل
//                 icon.classList.remove('bi-heart');
//                 icon.classList.add('bi-heart-fill');
//             } else { // 0 = ليس مفضل
//                 icon.classList.remove('bi-heart-fill');
//                 icon.classList.add('bi-heart');
//             }
//             icon.classList.toggle('active'); // تبديل حالة النشاط

//             // ب. تحديث خاصية data-is-favorite على رابط المنتج الأصلي
//             // هذا يضمن أن التغيير يبقى حتى بعد إغلاق وفتح الـ Modal
//             originalLink.setAttribute('data-is-favorite', isNowFavorite);
            
//         } else {
//             console.error('❌ ' + data.message);
//             alert('فشل في تعديل حالة المفضلة: ' + data.message); 
//             // لا حاجة لرجوع القلب لحالته الأصلية لأننا لم نغيره في البداية
//         }
//     })
//     .catch(err => {
//         console.error('Error:', err);
//         alert('حدث خطأ في الاتصال بالخادم. يرجى المحاولة لاحقًا.');
//         // لا حاجة لرجوع القلب لحالته الأصلية
//     });
// }

function populateModal(button){
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');
    const desc = button.getAttribute('data-desc');
    const ingredients = button.getAttribute('data-ingredients');
    const image = button.getAttribute('data-image');
    
    // قراءة الأسعار الثلاثة مباشرة من الـ HTML
    const priceS = button.getAttribute('data-price-s');
    const priceM = button.getAttribute('data-price-m');
    const priceL = button.getAttribute('data-price-l');

    document.getElementById('modalProductId').value = id;
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalProductDesc').textContent = desc;
    document.getElementById('modalProductIngredients').textContent = ingredients;
    document.getElementById('modalProductImage').src = image;

    // 1. بناء خيارات الأحجام بشكل ديناميكي
    const sizeOptionsContainer = document.getElementById('sizeOptionsContainer');
    let sizeOptionsHtml = '';
    
    // مصفوفة لتخزين الأسعار الصالحة لتعيين القيمة الافتراضية
    const availablePrices = []; 

    // فحص وعرض الحجم S (Small)
    if (priceS && parseFloat(priceS) > 0) {
        sizeOptionsHtml += `<span class="size-option" data-size-code="S" data-price="${priceS}" onclick="selectSize(this)">S</span>`;
        availablePrices.push({code: 'S', price: priceS});
    }

    // فحص وعرض الحجم M (Medium)
    if (priceM && parseFloat(priceM) > 0) {
        sizeOptionsHtml += `<span class="size-option" data-size-code="M" data-price="${priceM}" onclick="selectSize(this)">M</span>`;
        availablePrices.push({code: 'M', price: priceM});
    }

    // فحص وعرض الحجم L (Large)
    if (priceL && parseFloat(priceL) > 0) {
        sizeOptionsHtml += `<span class="size-option" data-size-code="L" data-price="${priceL}" onclick="selectSize(this)">L</span>`;
        availablePrices.push({code: 'L', price: priceL});
    }

    // تعبئة الحاوية بالخيارات المتاحة
    sizeOptionsContainer.innerHTML = sizeOptionsHtml || '<span>No size available.</span>';


    // 2. تعيين السعر الافتراضي وتفعيل الزر الصحيح
    let defaultPrice = 'N/A';
    let defaultCode = '';
    
    // نبحث عن أول سعر متاح بترتيب (M ثم S ثم L)
    const defaultItem = availablePrices.find(item => item.code === 'M') || 
                        availablePrices.find(item => item.code === 'S') || 
                        availablePrices.find(item => item.code === 'L');

    if (defaultItem) {
        defaultPrice = parseFloat(defaultItem.price).toFixed(2);
        defaultCode = defaultItem.code;
    }

    // 3. تطبيق السعر والتفعيل
    document.getElementById('modalProductPrice').textContent = defaultPrice;

    // إزالة التفعيل من الكل ثم تفعيل الافتراضي
    document.querySelectorAll('#sizeOptionsContainer .size-option').forEach(el => el.classList.remove('active-size'));
    
    const defaultActive = sizeOptionsContainer.querySelector(`[data-size-code="${defaultCode}"]`);
    if(defaultActive) {
        defaultActive.classList.add('active-size');

        document.getElementById('modalProductSize').value = defaultActive.getAttribute('data-size-code');
    }

    // ----------------------------------------------------------------------
    const isFavorite = button.getAttribute('data-is-favorite') === '1'; 
    
    // ... تعبئة البيانات الأخرى في المودال

    const favoriteIcon = document.querySelector('.favorite-icon');

    // إزالة جميع حالات القلب السابقة
    favoriteIcon.classList.remove('active', 'bi-heart', 'bi-heart-fill');

    if (isFavorite) {
        favoriteIcon.classList.add('active', 'bi-heart-fill');
    } else {
        favoriteIcon.classList.add('bi-heart');
    }
}


// function populateModal(button){
//     // 🌟🌟🌟 الخطوة الجديدة: حفظ مرجع الرابط الأصلي 🌟🌟🌟
    
//     // 1. قراءة حالة المفضلة (تم نقل هذا السطر لأعلى ليتم استخدامه في الخطوات التالية)
//     const isFavorite = button.getAttribute('data-is-favorite') === '1'; 
    
//     // 2. الحصول على عنصر أيقونة المفضلة داخل الـ Modal
//     const favoriteIcon = document.querySelector('.favorite-icon');

//     // 3. تخزين مرجع عنصر الرابط الأصلي (button) في خاصية بيانات جديدة على الأيقونة
//     // هذه هي النقطة التي ستستخدمها دالة toggleFavorite لاحقًا للتحديث.
//     favoriteIcon.dataset.originalLink = button;

//     // 🌟🌟🌟 نهاية الخطوة الجديدة 🌟🌟🌟
    
//     // ----------------------------------------------------------------------
    
//     const id = button.getAttribute('data-id');
//     const name = button.getAttribute('data-name');
//     const desc = button.getAttribute('data-desc');
//     const ingredients = button.getAttribute('data-ingredients');
//     const image = button.getAttribute('data-image');
    
//     // قراءة الأسعار الثلاثة مباشرة من الـ HTML
//     const priceS = button.getAttribute('data-price-s');
//     const priceM = button.getAttribute('data-price-m');
//     const priceL = button.getAttribute('data-price-l');

//     document.getElementById('modalProductId').value = id;
//     document.getElementById('modalProductName').textContent = name;
//     document.getElementById('modalProductDesc').textContent = desc;
//     document.getElementById('modalProductIngredients').textContent = ingredients;
//     document.getElementById('modalProductImage').src = image;

//     // 1. بناء خيارات الأحجام بشكل ديناميكي
//     const sizeOptionsContainer = document.getElementById('sizeOptionsContainer');
//     let sizeOptionsHtml = '';
    
//     // مصفوفة لتخزين الأسعار الصالحة لتعيين القيمة الافتراضية
//     const availablePrices = []; 

//     // فحص وعرض الحجم S (Small)
//     if (priceS && parseFloat(priceS) > 0) {
//         sizeOptionsHtml += `<span class="size-option" data-size-code="S" data-price="${priceS}" onclick="selectSize(this)">S</span>`;
//         availablePrices.push({code: 'S', price: priceS});
//     }

//     // فحص وعرض الحجم M (Medium)
//     if (priceM && parseFloat(priceM) > 0) {
//         sizeOptionsHtml += `<span class="size-option" data-size-code="M" data-price="${priceM}" onclick="selectSize(this)">M</span>`;
//         availablePrices.push({code: 'M', price: priceM});
//     }

//     // فحص وعرض الحجم L (Large)
//     if (priceL && parseFloat(priceL) > 0) {
//         sizeOptionsHtml += `<span class="size-option" data-size-code="L" data-price="${priceL}" onclick="selectSize(this)">L</span>`;
//         availablePrices.push({code: 'L', price: priceL});
//     }

//     // تعبئة الحاوية بالخيارات المتاحة
//     sizeOptionsContainer.innerHTML = sizeOptionsHtml || '<span>No size available.</span>';


//     // 2. تعيين السعر الافتراضي وتفعيل الزر الصحيح
//     let defaultPrice = 'N/A';
//     let defaultCode = '';
    
//     // نبحث عن أول سعر متاح بترتيب (M ثم S ثم L)
//     const defaultItem = availablePrices.find(item => item.code === 'M')  
//                         || availablePrices.find(item => item.code === 'S') 
//                         || availablePrices.find(item => item.code === 'L');

//     if (defaultItem) {
//         defaultPrice = parseFloat(defaultItem.price).toFixed(2);
//         defaultCode = defaultItem.code;
//     }

//     // 3. تطبيق السعر والتفعيل
//     document.getElementById('modalProductPrice').textContent = defaultPrice;

//     // إزالة التفعيل من الكل ثم تفعيل الافتراضي
//     document.querySelectorAll('#sizeOptionsContainer .size-option').forEach(el => el.classList.remove('active-size'));
    
//     const defaultActive = sizeOptionsContainer.querySelector(`[data-size-code="${defaultCode}"]`);
//     if(defaultActive) {
//         defaultActive.classList.add('active-size');
//     }

//     // ----------------------------------------------------------------------
//     // isFavorite تم قراءتها في البداية الآن

//     // ... تعبئة البيانات الأخرى في المودال

//     // favoriteIcon تم تعريفه في البداية الآن

//     // إزالة جميع حالات القلب السابقة
//     favoriteIcon.classList.remove('active', 'bi-heart', 'bi-heart-fill');

//     if (isFavorite) {
//         favoriteIcon.classList.add('active', 'bi-heart-fill');
//     } else {
//         favoriteIcon.classList.add('bi-heart');
//     }
// }

function selectSize(element){
    // إزالة التنشيط من جميع الأحجام
    document.querySelectorAll('#sizeOptionsContainer .size-option').forEach(el => {
        el.classList.remove('active-size');
    });
    // تفعيل الحجم المختار
    element.classList.add('active-size');

    document.getElementById('modalProductSize').value = element.getAttribute('data-size-code');

    // ⭐️ جلب السعر مباشرة من خاصية البيانات على الزر
    const selectedPrice = element.getAttribute('data-price'); 

    if (selectedPrice && selectedPrice !== '') {
        // تحديث السعر المعروض وتنسيقه
        document.getElementById('modalProductPrice').textContent = parseFloat(selectedPrice).toFixed(2);
    } else {
        // في حالة عدم توفر السعر لهذا الحجم
        document.getElementById('modalProductPrice').textContent = 'N/A';
    }
}

