const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i=> {
            i.parentElement.classList.remove('active');
        })
        li.classList.add('active');
    })
});

// ===== TOGGLE SIDEBAR =====
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
})

// ===== SEARCH RESPONSIVE =====
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if(window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if(searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
})

if(window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
    if(this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
})


// ===== DARK MODE =====
const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
    if(this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
})

// ===== Change Title Of Modal =====
const addProductModal = document.getElementById('addProduct');
if (addProductModal) {
    addProductModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const modalTitle = button.getAttribute('data-title');
        addProductModal.querySelector('.modal-title').textContent = modalTitle;
    });
}

const addToStaffModal = document.getElementById('addEmployee');
if (addToStaffModal) {
    addToStaffModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const modalTitle = button.getAttribute('data-title');
        addToStaffModal.querySelector('.modal-title').textContent = modalTitle;
    });
}

