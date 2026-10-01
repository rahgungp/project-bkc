<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title mb-1">Manajemen Lokasi</h1>
        <p class="page-subtitle text-muted mb-0">Kelola daftar lokasi untuk pelatihan dan kegiatan</p>
    </div>
    <button class="btn fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;padding:10px 20px;"
            onclick="openLocationModal()">
        <i class="fas fa-plus me-2"></i>Tambah Lokasi
    </button>
</div>

<div class="admin-card" data-aos="fade-up">
    <div class="admin-card-header">
        <h6 class="admin-card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i>Daftar Lokasi</h6>
    </div>
    <div class="admin-card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="locationsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lokasi</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th class="text-center">Kapasitas</th>
                        <th class="text-center">Maps</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($locations as $i => $loc): ?>
                    <tr id="row-loc-<?= $loc['id'] ?>">
                        <td class="text-muted"><?= $i + 1 ?></td>
                        <td>
                            <div class="fw-600"><?= esc($loc['name']) ?></div>
                            <?php if (!empty($loc['address'])): ?>
                            <small class="text-muted"><?= esc(substr($loc['address'], 0, 60)) ?><?= strlen($loc['address']) > 60 ? '...' : '' ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($loc['city'] ?? '-') ?></td>
                        <td><?= esc($loc['province'] ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($loc['capacity'])): ?>
                            <span class="badge" style="background:rgba(30,79,163,0.12);color:#1E4FA3;border-radius:20px;padding:4px 10px;">
                                <?= number_format($loc['capacity']) ?> org
                            </span>
                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php $mapsUrl = $loc['google_maps'] ?? ''; ?>
                            <?php if ($mapsUrl): ?>
                            <a href="<?= esc($mapsUrl) ?>" target="_blank" class="btn btn-sm"
                               style="background:rgba(66,133,244,0.1);color:#4285f4;border-radius:8px;" title="Buka di Google Maps">
                                <i class="fas fa-map-marked-alt"></i>
                            </a>
                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <button class="btn btn-sm" style="background:rgba(200,163,77,0.1);color:#C8A34D;border-radius:8px;"
                                        onclick="editLocation(<?= $loc['id'] ?>, <?= htmlspecialchars(json_encode($loc), ENT_QUOTES) ?>)"
                                        title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm" style="background:rgba(220,53,69,0.1);color:#dc3545;border-radius:8px;"
                                        onclick="deleteLocation(<?= $loc['id'] ?>, '<?= esc($loc['name'], 'js') ?>')"
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

<!-- Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-700" id="locationModalTitle">Tambah Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="locationForm">
                    <?= csrf_field() ?>
                    <input type="hidden" id="locationId" name="location_id">

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-600">Nama Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="locName" class="form-control" placeholder="Nama hotel/venue/gedung" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Alamat <span class="text-danger">*</span></label>
                            <textarea name="address" id="locAddress" class="form-control" rows="2" placeholder="Alamat lengkap" required></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="locCity" class="form-control" placeholder="Denpasar" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Provinsi</label>
                            <input type="text" name="province" id="locProvince" class="form-control" placeholder="Bali">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Google Maps URL</label>
                            <input type="url" name="google_maps_url" id="locMapsUrl" class="form-control" placeholder="https://maps.google.com/...">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-600">Latitude</label>
                            <input type="text" name="latitude" id="locLat" class="form-control" placeholder="-8.670458">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label fw-600">Longitude</label>
                            <input type="text" name="longitude" id="locLng" class="form-control" placeholder="115.212629">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-600">Kapasitas (orang)</label>
                            <input type="number" name="capacity" id="locCapacity" class="form-control" placeholder="200" min="0">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-600">Telepon</label>
                            <input type="text" name="phone" id="locPhone" class="form-control" placeholder="+62...">
                        </div>
                        <div class="col-12 col-md-6 d-flex align-items-end pb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="locIsActive" value="1" checked>
                                <label class="form-check-label fw-600" for="locIsActive">Lokasi Aktif</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Deskripsi</label>
                            <textarea name="description" id="locDescription" class="form-control" rows="3" placeholder="Fasilitas, catatan tambahan..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn px-4" style="background:transparent;border:1.5px solid var(--border-color,#e5e7eb);border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn px-4 fw-700" style="background:#C8A34D;color:#121212;border-radius:10px;" onclick="saveLocation()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->section('extra_js') ?>
<script>
$(function() {
    $('#locationsTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order: [[1, 'asc']],
        columnDefs: [{ orderable: false, targets: [5, 6] }],
    });
});

let locationModal = null;

function openLocationModal() {
    resetLocationForm();
    document.getElementById('locationModalTitle').textContent = 'Tambah Lokasi';
    if (!locationModal) locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
    locationModal.show();
}

function editLocation(id, data) {
    resetLocationForm();
    document.getElementById('locationModalTitle').textContent = 'Edit Lokasi';
    document.getElementById('locationId').value    = id;
    document.getElementById('locName').value       = data.name || '';
    document.getElementById('locAddress').value    = data.address || '';
    document.getElementById('locCity').value       = data.city || '';
    document.getElementById('locProvince').value   = data.province || '';
    document.getElementById('locMapsUrl').value    = data.google_maps_url || data.google_maps || '';
    document.getElementById('locLat').value        = data.latitude || '';
    document.getElementById('locLng').value        = data.longitude || '';
    document.getElementById('locCapacity').value   = data.capacity || '';
    document.getElementById('locPhone').value      = data.phone || '';
    document.getElementById('locDescription').value = data.description || '';
    document.getElementById('locIsActive').checked = !!parseInt(data.is_active);

    if (!locationModal) locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
    locationModal.show();
}

function resetLocationForm() {
    document.getElementById('locationForm').reset();
    document.getElementById('locationId').value  = '';
    document.getElementById('locIsActive').checked = true;
}

function saveLocation() {
    const id  = document.getElementById('locationId').value;
    const url = id
        ? '<?= base_url('admin/lokasi/update') ?>/' + id
        : '<?= base_url('admin/lokasi/simpan') ?>';

    const fd = new FormData(document.getElementById('locationForm'));
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
                locationModal.hide();
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

function deleteLocation(id, name) {
    Swal.fire({
        title: 'Hapus Lokasi?',
        html: 'Lokasi <strong>' + name + '</strong> akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    }).then(function(result) {
        if (!result.isConfirmed) return;
        $.ajax({
            url: '<?= base_url('admin/lokasi/hapus') ?>/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                if (res.success) {
                    $('#row-loc-' + id).fadeOut(300, function() { $(this).remove(); });
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
