<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Narasumber</h1>
        <p class="page-subtitle text-muted mb-0">Kelola daftar narasumber / fasilitator pelatihan</p>
    </div>
    <button class="btn fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;padding:10px 20px;"
            onclick="openSpeakerModal()">
        <i class="fas fa-plus me-2"></i>Tambah Narasumber
    </button>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Daftar Narasumber</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="speakersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan/Gelar</th>
                        <th>Spesialisasi</th>
                        <th>Kontak</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($speakers as $i => $speaker): ?>
                    <tr id="row-sp-<?= $speaker['id'] ?>">
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <?php if (!empty($speaker['photo'])): ?>
                            <img src="<?= base_url('uploads/speakers/' . esc($speaker['photo'])) ?>"
                                 style="width:44px;height:44px;border-radius:50%;object-fit:cover;"
                                 alt="<?= esc($speaker['name']) ?>"
                                 onerror="this.outerHTML='<div style=\'width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#C8A34D,#1E4FA3);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;\'><?= strtoupper(substr($speaker['name'], 0, 1)) ?></div>'">
                            <?php else: ?>
                            <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#C8A34D,#1E4FA3);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;">
                                <?= strtoupper(substr($speaker['name'], 0, 1)) ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-700"><?= esc($speaker['name']) ?></div>
                        </td>
                        <td>
                            <span style="font-size:13px;"><?= esc($speaker['title'] ?? '-') ?></span>
                        </td>
                        <td>
                            <?php $spec = $speaker['specialization'] ?? $speaker['speciality'] ?? '-'; ?>
                            <span style="font-size:13px;"><?= esc(substr($spec, 0, 50)) ?><?= strlen($spec) > 50 ? '...' : '' ?></span>
                        </td>
                        <td>
                            <?php if (!empty($speaker['email'])): ?>
                            <a href="mailto:<?= esc($speaker['email']) ?>" style="font-size:12px;color:#1E4FA3;">
                                <i class="fas fa-envelope me-1"></i><?= esc($speaker['email']) ?>
                            </a><br>
                            <?php endif; ?>
                            <?php if (!empty($speaker['phone'])): ?>
                            <span style="font-size:12px;color:var(--text-muted,#6c757d);">
                                <i class="fas fa-phone me-1"></i><?= esc($speaker['phone']) ?>
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center mb-0">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="sp-active-<?= $speaker['id'] ?>"
                                       <?= $speaker['is_active'] ? 'checked' : '' ?>
                                       onchange="toggleSpeaker(<?= $speaker['id'] ?>, this.checked)">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-sm" style="background:rgba(200,163,77,0.1);color:#C8A34D;border-radius:8px;"
                                        onclick="editSpeaker(<?= $speaker['id'] ?>, <?= htmlspecialchars(json_encode($speaker), ENT_QUOTES) ?>)"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm" style="background:rgba(220,53,69,0.1);color:#dc3545;border-radius:8px;"
                                        onclick="deleteSpeaker(<?= $speaker['id'] ?>, '<?= esc($speaker['name'], 'js') ?>')"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Speaker Modal -->
<div class="modal fade" id="speakerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700" id="speakerModalTitle">Tambah Narasumber</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="speakerForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" id="speakerId" name="speaker_id">

                    <div class="row g-3">
                        <!-- Photo Upload -->
                        <div class="col-12 text-center">
                            <div id="spPhotoPreviewWrap" onclick="document.getElementById('spPhotoInput').click()"
                                 style="width:90px;height:90px;border-radius:50%;margin:0 auto;cursor:pointer;overflow:hidden;border:3px solid var(--border-color,#e5e7eb);display:flex;align-items:center;justify-content:center;background:rgba(200,163,77,0.1);">
                                <img id="spPhotoPreview" src="" style="width:100%;height:100%;object-fit:cover;display:none;">
                                <i id="spPhotoIcon" class="fas fa-camera" style="color:#C8A34D;font-size:1.5rem;"></i>
                            </div>
                            <input type="file" id="spPhotoInput" name="photo" accept="image/*" style="display:none;" onchange="previewSpeakerPhoto(this)">
                            <small class="text-muted d-block mt-1">Klik foto untuk mengubah</small>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="spName" class="form-control" placeholder="Dr. Ahmad Santoso, M.Si." required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Jabatan / Gelar</label>
                            <input type="text" name="title" id="spTitle" class="form-control" placeholder="Doktor, Profesor, Widyaiswara, dll.">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Spesialisasi / Bidang Keahlian</label>
                            <input type="text" name="specialization" id="spSpecialization" class="form-control" placeholder="Manajemen SDM, Kebijakan Publik, dll.">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Email</label>
                            <input type="email" name="email" id="spEmail" class="form-control" placeholder="narasumber@email.com">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Telepon / WhatsApp</label>
                            <input type="text" name="phone" id="spPhone" class="form-control" placeholder="+62 812 3456 7890">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Bio Singkat</label>
                            <textarea name="bio" id="spBio" class="form-control" rows="4" placeholder="Deskripsi singkat tentang narasumber, latar belakang, dll."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Pendidikan</label>
                            <textarea name="education" id="spEducation" class="form-control" rows="2" placeholder="S3 Universitas Indonesia, 2010..."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Pengalaman</label>
                            <textarea name="experience" id="spExperience" class="form-control" rows="2" placeholder="15 tahun di bidang pelatihan ASN..."></textarea>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-600">LinkedIn URL</label>
                            <input type="url" name="linkedin" id="spLinkedin" class="form-control" placeholder="https://linkedin.com/in/...">
                        </div>
                        <div class="col-12 col-md-4 d-flex align-items-end pb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="spIsActive" value="1" checked>
                                <label class="form-check-label fw-600" for="spIsActive">Aktif</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn px-4" style="background:transparent;border:1.5px solid var(--border-color,#e5e7eb);border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn px-4 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;" onclick="saveSpeaker()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script>
$(function() {
    $('#speakersTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [[2, 'asc']],
        columnDefs: [{ orderable: false, targets: [1, 6, 7] }],
    });
});

let speakerModal = null;

function openSpeakerModal() {
    resetSpeakerForm();
    document.getElementById('speakerModalTitle').textContent = 'Tambah Narasumber';
    if (!speakerModal) speakerModal = new bootstrap.Modal(document.getElementById('speakerModal'));
    speakerModal.show();
}

function editSpeaker(id, data) {
    resetSpeakerForm();
    document.getElementById('speakerModalTitle').textContent = 'Edit Narasumber';
    document.getElementById('speakerId').value        = id;
    document.getElementById('spName').value           = data.name || '';
    document.getElementById('spTitle').value          = data.title || '';
    document.getElementById('spSpecialization').value = data.specialization || data.speciality || '';
    document.getElementById('spEmail').value          = data.email || '';
    document.getElementById('spPhone').value          = data.phone || '';
    document.getElementById('spBio').value            = data.bio || '';
    document.getElementById('spEducation').value      = data.education || '';
    document.getElementById('spExperience').value     = data.experience || '';
    document.getElementById('spLinkedin').value       = data.linkedin || '';
    document.getElementById('spIsActive').checked     = !!parseInt(data.is_active);

    if (data.photo) {
        const preview = document.getElementById('spPhotoPreview');
        preview.src           = '<?= base_url('uploads/speakers/') ?>' + data.photo;
        preview.style.display = 'block';
        document.getElementById('spPhotoIcon').style.display = 'none';
    }

    if (!speakerModal) speakerModal = new bootstrap.Modal(document.getElementById('speakerModal'));
    speakerModal.show();
}

function resetSpeakerForm() {
    document.getElementById('speakerForm').reset();
    document.getElementById('speakerId').value    = '';
    document.getElementById('spIsActive').checked = true;
    const preview = document.getElementById('spPhotoPreview');
    preview.src           = '';
    preview.style.display = 'none';
    document.getElementById('spPhotoIcon').style.display = 'block';
}

function previewSpeakerPhoto(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview           = document.getElementById('spPhotoPreview');
        preview.src             = e.target.result;
        preview.style.display   = 'block';
        document.getElementById('spPhotoIcon').style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}

function saveSpeaker() {
    const id  = document.getElementById('speakerId').value;
    const url = id
        ? '<?= base_url('admin/narasumber/update') ?>/' + id
        : '<?= base_url('admin/narasumber/simpan') ?>';

    const fd = new FormData(document.getElementById('speakerForm'));
    if (!fd.get('is_active')) fd.set('is_active', '0');

    $.ajax({
        url: url,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(res) {
            if (res.success) {
                speakerModal.hide();
                Swal.fire({
                    title: 'Berhasil!',
                    text: res.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                }).then(function() { location.reload(); });
            } else {
                const errHtml = res.errors ? Object.values(res.errors).join('<br>') : (res.message || 'Gagal menyimpan.');
                Swal.fire('Gagal', errHtml, 'error');
            }
        },
        error: function() { Swal.fire('Error', 'Terjadi kesalahan server.', 'error'); },
    });
}

function toggleSpeaker(id, isChecked) {
    $.post('<?= base_url('admin/narasumber/update') ?>/' + id, {
        is_active: isChecked ? 1 : 0,
        '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
    }).fail(function() {
        document.getElementById('sp-active-' + id).checked = !isChecked;
        Swal.fire('Gagal', 'Gagal mengubah status.', 'error');
    });
}

function deleteSpeaker(id, name) {
    Swal.fire({
        title: 'Hapus Narasumber?',
        html: '<strong>' + name + '</strong> akan dihapus dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;
        $.ajax({
            url: '<?= base_url('admin/narasumber/hapus') ?>/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.success) {
                    $('#row-sp-' + id).fadeOut(300, function() { $(this).remove(); });
                    Swal.fire({ title: 'Berhasil!', text: res.message, icon: 'success', timer: 1500, showConfirmButton: false });
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
        });
    });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
