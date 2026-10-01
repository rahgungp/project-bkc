// ========================================
// BKC Admin Panel - Core JavaScript
// ========================================

// Theme Management
function toggleTheme() {
    const html = document.documentElement;
    const icon = document.getElementById('themeIcon');
    const isDark = html.getAttribute('data-theme') === 'dark';

    if (isDark) {
        html.setAttribute('data-theme', 'light');
        icon.classList.replace('fa-sun', 'fa-moon');
        localStorage.setItem('bkc_theme', 'light');
    } else {
        html.setAttribute('data-theme', 'dark');
        icon.classList.replace('fa-moon', 'fa-sun');
        localStorage.setItem('bkc_theme', 'dark');
    }
}

// Load saved theme
(function() {
    const theme = localStorage.getItem('bkc_theme') || 'light';
    document.documentElement.setAttribute('data-theme', theme);
    const icon = document.getElementById('themeIcon');
    if (icon) {
        icon.classList.toggle('fa-sun', theme === 'dark');
        icon.classList.toggle('fa-moon', theme === 'light');
    }
})();

// Sidebar Toggle
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const isOpen = sidebar.classList.contains('open');

    if (isOpen) {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    } else {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

// Sidebar Group Toggle
document.querySelectorAll('.nav-group-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const group = this.closest('.nav-item-group');
        group.classList.toggle('open');
    });
});

// Active submenu auto-open
document.querySelectorAll('.nav-subitem.active').forEach(item => {
    const group = item.closest('.nav-item-group');
    if (group) group.classList.add('open');
});

// AJAX Delete Helper
function deleteRecord(url, callback) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus!',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => { if (callback) callback(); else location.reload(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                }
            })
            .catch(() => { Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus data.' }); });
        }
    });
}

// Success notification
function showSuccess(msg) {
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: msg, timer: 2000, showConfirmButton: false });
}

// Error notification
function showError(msg) {
    Swal.fire({ icon: 'error', title: 'Error!', text: msg, confirmButtonColor: '#C8A34D' });
}

// DataTable defaults
if (typeof $.fn.DataTable !== 'undefined') {
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
        },
        pageLength: 25,
        responsive: true,
        dom: '<"row align-items-center mb-3"<"col-auto"l><"col"f>>rt<"row align-items-center mt-3"<"col"i><"col-auto"p>>',
    });
}

// Format number with K/M suffix
function formatNumber(n) {
    if (n >= 1000000) return (n/1000000).toFixed(1) + 'M';
    if (n >= 1000) return (n/1000).toFixed(1) + 'K';
    return n.toString();
}

// Image preview
document.querySelectorAll('.img-upload-input').forEach(input => {
    input.addEventListener('change', function() {
        const preview = document.querySelector(this.dataset.preview);
        if (preview && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
