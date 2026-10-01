<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.faq-list { list-style: none; padding: 0; margin: 0; }
.faq-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 18px; border-bottom: 1px solid var(--border-color, #e9ecef);
    background: #fff; transition: background .15s;
}
.faq-item:last-child { border-bottom: none; }
.faq-item:hover { background: #fafafa; }
.drag-handle {
    cursor: grab; color: #adb5bd; font-size: 16px;
    padding-top: 2px; flex-shrink: 0;
}
.drag-handle:active { cursor: grabbing; }
.faq-content { flex: 1; min-width: 0; }
.faq-question { font-weight: 600; font-size: 14px; color: #212529; margin-bottom: 4px; }
.faq-answer-preview { font-size: 12px; color: #6B7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 420px; }
.faq-meta { display: flex; align-items: center; gap: 10px; margin-top: 6px; }
.faq-sort-badge {
    background: rgba(200,163,77,.15); color: #C8A34D; font-size: 11px;
    font-weight: 700; padding: 2px 8px; border-radius: 20px;
}
.toggle-switch { cursor: pointer; user-select: none; }
.toggle-switch input { display: none; }
.toggle-switch .slider {
    display: inline-block; width: 38px; height: 20px;
    background: #dee2e6; border-radius: 100px; position: relative; transition: background .25s;
}
.toggle-switch .slider::after {
    content: ''; position: absolute; left: 3px; top: 3px;
    width: 14px; height: 14px; border-radius: 50%;
    background: #fff; transition: left .25s; box-shadow: 0 1px 3px rgba(0,0,0,.3);
}
.toggle-switch input:checked + .slider { background: #C8A34D; }
.toggle-switch input:checked + .slider::after { left: 21px; }
.faq-actions { display: flex; gap: 6px; flex-shrink: 0; align-items: flex-start; }
.sortable-ghost { opacity: .4; background: #f0f7ff !important; }
.category-badge {
    background: rgba(30,79,163,.1); color: #1E4FA3;
    font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 20px;
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Kelola FAQ</h1>
        <p class="page-subtitle">Frequently Asked Questions — drag untuk urutkan ulang</p>
    </div>
    <div class="page-actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal"
            style="background:#C8A34D; border-color:#C8A34D; color:#121212; font-weight:700; border-radius:10px; padding:10px 20px;">
            <i class="fas fa-plus me-2"></i>Tambah FAQ
        </button>
    </div>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title"><i class="fas fa-question-circle me-2"></i>Daftar FAQ</h6>
        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Drag &amp; drop untuk mengubah urutan</small>
    </div>
    <div class="admin-card-body p-0">
        <?php if(empty($faqs)): ?>
        <div class="text-center py-5 text-muted">
            <i class="fas fa-question-circle fa-3x mb-3" style="color:#C8A34D; opacity:.4;"></i>
            <p>Belum ada FAQ. Klik "Tambah FAQ" untuk memulai.</p>
        </div>
        <?php else: ?>
        <ul class="faq-list" id="faqSortable">
            <?php foreach($faqs as $faq): ?>
            <li class="faq-item" data-id="<?= $faq['id'] ?>">
                <span class="drag-handle" title="Drag untuk urutkan">
                    <i class="fas fa-grip-vertical"></i>
                </span>
                <div class="faq-content">
                    <div class="faq-question"><?= esc($faq['question']) ?></div>
                    <div class="faq-answer-preview"><?= esc(strip_tags($faq['answer'] ?? '')) ?></div>
                    <div class="faq-meta">
                        <span class="faq-sort-badge">#<?= (int)($faq['sort_order'] ?? 0) ?></span>
                        <?php if(!empty($faq['category'])): ?>
                        <span class="category-badge"><i class="fas fa-tag me-1"></i><?= esc($faq['category']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; align-items:center; gap:6px; flex-shrink:0;">
                    <label class="toggle-switch" title="Aktif/Nonaktif">
                        <input type="checkbox" <?= $faq['is_active'] ? 'checked' : '' ?>
                            onchange="toggleActive(<?= $faq['id'] ?>, this)">
                        <span class="slider"></span>
                    </label>
                    <small style="font-size:10px; color:#adb5bd;"><?= $faq['is_active'] ? 'Aktif' : 'Nonaktif' ?></small>
                </div>
                <div class="faq-actions">
                    <button class="btn btn-sm btn-outline-primary" style="border-radius:8px; padding:5px 10px;"
                        onclick="openEditFaq(<?= htmlspecialchars(json_encode($faq), ENT_QUOTES) ?>)"
                        title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" style="border-radius:8px; padding:5px 10px;"
                        onclick="deleteFaq(<?= $faq['id'] ?>)"
                        title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2" style="color:#C8A34D;"></i>Tambah FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addFaqForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" name="question" class="form-control" required placeholder="Masukkan pertanyaan...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Jawaban <span class="text-danger">*</span></label>
                            <textarea name="answer" class="form-control" rows="5" required placeholder="Masukkan jawaban lengkap..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Kategori</label>
                            <input type="text" name="category" class="form-control" placeholder="Contoh: Pendaftaran, Pembayaran...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="addIsActive" value="1" checked>
                                <label class="form-check-label" for="addIsActive">Aktifkan FAQ ini</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Simpan FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:#C8A34D;"></i>Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editFaqForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_edit_id" id="editFaqId">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="editFaqQuestion" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Jawaban <span class="text-danger">*</span></label>
                            <textarea name="answer" id="editFaqAnswer" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Kategori</label>
                            <input type="text" name="category" id="editFaqCategory" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Sort Order</label>
                            <input type="number" name="sort_order" id="editFaqSortOrder" class="form-control" value="0" min="0">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editFaqIsActive" value="1">
                                <label class="form-check-label" for="editFaqIsActive">Aktifkan FAQ ini</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn" style="background:#C8A34D; color:#121212; font-weight:700;">
                        <i class="fas fa-save me-1"></i>Update FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SortableJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const BASE = '<?= base_url() ?>';

// Drag-and-drop sorting
const sortableEl = document.getElementById('faqSortable');
if (sortableEl) {
    Sortable.create(sortableEl, {
        handle: '.drag-handle',
        animation: 180,
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            const items = [...sortableEl.querySelectorAll('li.faq-item')].map((el, i) => ({
                id: el.dataset.id,
                sort_order: i + 1
            }));
            $.post(BASE + 'admin/faq/reorder', {
                items: JSON.stringify(items),
                '<?= csrf_token() ?>': CSRF
            }, function(r) {
                toast(r.status === 'success' ? 'success' : 'warning', r.message || 'Urutan disimpan');
            });
        }
    });
}

function toggleActive(id, el) {
    $.post(BASE + 'admin/faq/' + id, {
        _method: 'POST',
        is_active: el.checked ? 1 : 0,
        '<?= csrf_token() ?>': CSRF,
        _toggle_active: 1
    }, function(r) {
        toast(r.status === 'success' ? 'success' : 'error', r.message);
        if (r.status !== 'success') el.checked = !el.checked;
    });
}

function openEditFaq(data) {
    $('#editFaqId').val(data.id);
    $('#editFaqQuestion').val(data.question);
    $('#editFaqAnswer').val(data.answer);
    $('#editFaqCategory').val(data.category || '');
    $('#editFaqSortOrder').val(data.sort_order || 0);
    $('#editFaqIsActive').prop('checked', data.is_active == 1);
    new bootstrap.Modal(document.getElementById('editFaqModal')).show();
}

$('#addFaqForm').on('submit', function(e) {
    e.preventDefault();
    $.post(BASE + 'admin/faq', $(this).serialize() + '&<?= csrf_token() ?>=' + CSRF, function(r) {
        if (r.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: r.message, timer: 1800, showConfirmButton: false });
            bootstrap.Modal.getInstance(document.getElementById('addFaqModal')).hide();
            setTimeout(() => location.reload(), 1800);
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: r.message });
        }
    });
});

$('#editFaqForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#editFaqId').val();
    $.post(BASE + 'admin/faq/' + id, $(this).serialize() + '&<?= csrf_token() ?>=' + CSRF, function(r) {
        if (r.status === 'success') {
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: r.message, timer: 1800, showConfirmButton: false });
            bootstrap.Modal.getInstance(document.getElementById('editFaqModal')).hide();
            setTimeout(() => location.reload(), 1800);
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: r.message });
        }
    });
});

function deleteFaq(id) {
    Swal.fire({
        title: 'Hapus FAQ?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(BASE + 'admin/faq/hapus/' + id, {
                _method: 'DELETE',
                '<?= csrf_token() ?>': CSRF
            }, function(r) {
                if (r.status === 'success') {
                    $('li[data-id="' + id + '"]').fadeOut(300, function() { $(this).remove(); });
                    toast('success', r.message);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: r.message });
                }
            });
        }
    });
}

function toast(icon, text) {
    Swal.fire({ toast: true, position: 'top-end', icon: icon, title: text, showConfirmButton: false, timer: 2200 });
}
</script>

<?= $this->endSection() ?>
