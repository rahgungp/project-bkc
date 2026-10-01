<?php $this->extend('Modules\Admin\Views\layout\main') ?>
<?php $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="page-title mb-1"><i class="fas fa-history me-2 text-gold"></i>Activity Log</h4>
        <p class="text-muted mb-0 small">Riwayat aktivitas seluruh pengguna admin panel</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= current_url() ?>?<?= http_build_query(array_merge($filters, ['export' => 1])) ?>&<?= csrf_token() ?>=<?= csrf_hash() ?>"
           class="btn btn-outline-success" id="btnExport">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
        <button type="button" class="btn btn-outline-danger" id="btnClearLogs">
            <i class="fas fa-trash-alt me-1"></i> Hapus Log Lama
        </button>
    </div>
</div>

<!-- Filter Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom py-3">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-filter me-2"></i>Filter Log</h6>
    </div>
    <div class="card-body p-4">
        <form method="GET" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">User</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">— Semua User —</option>
                        <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= ($filters['user_id'] == $u['id']) ? 'selected' : '' ?>>
                            <?= esc($u['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Action</label>
                    <select name="action" class="form-select form-select-sm">
                        <option value="">— Semua —</option>
                        <?php foreach (['created', 'updated', 'deleted', 'login', 'logout', 'reset_password', 'toggle_active'] as $act): ?>
                        <option value="<?= $act ?>" <?= ($filters['action'] === $act) ? 'selected' : '' ?>>
                            <?= ucfirst(str_replace('_', ' ', $act)) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Module / Tabel</label>
                    <input type="text" name="module" class="form-control form-control-sm"
                           value="<?= esc($filters['module'] ?? '') ?>" placeholder="users, roles, ...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Tanggal Dari</label>
                    <input type="date" name="date_from" class="form-control form-control-sm"
                           value="<?= esc($filters['date_from'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Tanggal Sampai</label>
                    <input type="date" name="date_to" class="form-control form-control-sm"
                           value="<?= esc($filters['date_to'] ?? '') ?>">
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-gold btn-sm flex-fill" title="Terapkan Filter">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="<?= base_url('admin/activity-log') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Logs Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-list-alt me-2"></i>Log Aktivitas</h6>
        <span class="badge bg-gold-soft text-gold"><?= count($logs) ?> entri dimuat</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="logsTable" class="table table-hover align-middle mb-0 table-sm">
                <thead class="table-dark">
                    <tr>
                        <th width="150">Waktu</th>
                        <th>User</th>
                        <th width="120">Action</th>
                        <th>Module</th>
                        <th width="80">Record</th>
                        <th>Data Lama</th>
                        <th>Data Baru</th>
                        <th width="110">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-history fa-3x mb-3 d-block opacity-25"></i>
                            Tidak ada log yang sesuai filter.
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                    <?php
                    $actionColors = [
                        'created'       => ['bg' => 'success',  'icon' => 'plus-circle'],
                        'updated'       => ['bg' => 'primary',  'icon' => 'edit'],
                        'deleted'       => ['bg' => 'danger',   'icon' => 'trash-alt'],
                        'login'         => ['bg' => 'gold',     'icon' => 'sign-in-alt'],
                        'logout'        => ['bg' => 'secondary','icon' => 'sign-out-alt'],
                        'reset_password'=> ['bg' => 'warning',  'icon' => 'key'],
                        'toggle_active' => ['bg' => 'info',     'icon' => 'toggle-on'],
                    ];
                    $ac    = $actionColors[$log['action']] ?? ['bg' => 'secondary', 'icon' => 'circle'];
                    $bgCls = $ac['bg'] === 'gold' ? 'style="background:#C8A34D;"' : "class=\"badge bg-{$ac['bg']}\"";
                    ?>
                    <tr>
                        <td class="small text-muted">
                            <?= date('d/m/Y', strtotime($log['created_at'])) ?><br>
                            <span class="fw-semibold"><?= date('H:i:s', strtotime($log['created_at'])) ?></span>
                        </td>
                        <td>
                            <div class="fw-semibold small"><?= esc($log['user_name'] ?? 'System') ?></div>
                            <?php if (!empty($log['role_name'])): ?>
                            <span class="badge bg-secondary" style="font-size:0.65rem;"><?= esc($log['role_name']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($ac['bg'] === 'gold'): ?>
                            <span class="badge text-white" style="background-color:#C8A34D;">
                                <i class="fas fa-<?= $ac['icon'] ?> me-1"></i><?= esc($log['action']) ?>
                            </span>
                            <?php else: ?>
                            <span class="badge bg-<?= $ac['bg'] ?>">
                                <i class="fas fa-<?= $ac['icon'] ?> me-1"></i><?= esc($log['action']) ?>
                            </span>
                            <?php endif; ?>
                        </td>
                        <td><code class="small"><?= esc($log['module']) ?></code></td>
                        <td class="text-center">
                            <?= $log['record_id'] ? '<span class="badge bg-light text-dark border">#' . (int)$log['record_id'] . '</span>' : '—' ?>
                        </td>
                        <!-- Old Data -->
                        <td>
                            <?php if (!empty($log['old_values'])): ?>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2 btn-toggle-json"
                                    data-json='<?= esc($log['old_values']) ?>'
                                    data-type="Lama">
                                <i class="fas fa-code me-1" style="font-size:10px;"></i>
                                <span style="font-size:11px;">Lihat</span>
                            </button>
                            <?php else: ?>
                            <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <!-- New Data -->
                        <td>
                            <?php if (!empty($log['new_values'])): ?>
                            <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-toggle-json"
                                    data-json='<?= esc($log['new_values']) ?>'
                                    data-type="Baru">
                                <i class="fas fa-code me-1" style="font-size:10px;"></i>
                                <span style="font-size:11px;">Lihat</span>
                            </button>
                            <?php else: ?>
                            <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= esc($log['ip_address']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if (isset($pager)): ?>
    <div class="card-footer bg-transparent border-top">
        <?= $pager->links('default', 'bootstrap_full') ?>
    </div>
    <?php endif; ?>
</div>

<!-- JSON Viewer Modal -->
<div class="modal fade" id="jsonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jsonModalTitle"><i class="fas fa-code me-2"></i>Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <pre id="jsonContent" class="m-0 p-4"
                     style="background:#1e1e2e;color:#cdd6f4;font-size:13px;border-radius:0;max-height:500px;overflow:auto;"></pre>
            </div>
        </div>
    </div>
</div>

<style>
.text-gold { color: #C8A34D !important; }
.bg-gold   { background-color: #C8A34D !important; }
.btn-gold  { background-color: #C8A34D; border-color: #C8A34D; color: #fff; font-weight: 600; }
.btn-gold:hover { background-color: #b8922d; border-color: #b8922d; color: #fff; }
.bg-gold-soft { background: rgba(200,163,77,0.12); }
</style>

<script>
$(function () {
    // DataTables
    $('#logsTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json' },
        order:    [[0, 'desc']],
        pageLength: 50,
        columnDefs: [{ orderable: false, targets: [5, 6] }],
    });

    // JSON Viewer
    $(document).on('click', '.btn-toggle-json', function () {
        const jsonStr = $(this).data('json');
        const type    = $(this).data('type');
        let formatted;
        try {
            formatted = JSON.stringify(JSON.parse(jsonStr), null, 2);
        } catch (e) {
            formatted = jsonStr;
        }
        $('#jsonModalTitle').html('<i class="fas fa-code me-2"></i>Data ' + type);
        $('#jsonContent').text(formatted);
        new bootstrap.Modal(document.getElementById('jsonModal')).show();
    });

    // Clear old logs
    $('#btnClearLogs').on('click', function () {
        Swal.fire({
            title: 'Hapus Log Lama?',
            html:  'Semua log yang lebih dari <strong>90 hari</strong> akan dihapus permanen.',
            icon:  'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor:  '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText:  'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $('#btnClearLogs');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

                $.post('<?= base_url('admin/activity-log/clear') ?>', {
                    [csrf_token]: csrf_hash,
                }, function (res) {
                    if (res.success) {
                        Swal.fire({
                            icon:  'success',
                            title: 'Berhasil',
                            html:  res.message,
                            timer: 3000,
                            showConfirmButton: false,
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                }).always(() => {
                    $btn.prop('disabled', false).html('<i class="fas fa-trash-alt me-1"></i> Hapus Log Lama');
                });
            }
        });
    });
});

const csrf_token = '<?= csrf_token() ?>';
const csrf_hash  = '<?= csrf_hash() ?>';
</script>

<?php $this->endSection() ?>
