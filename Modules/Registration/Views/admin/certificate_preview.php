<?= $this->extend('Modules\Admin\Views\layout\main') ?>
<?= $this->section('content') ?>

<style>
.preview-toolbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.preview-toolbar-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-primary);
}
.preview-toolbar-code {
    font-size: 12px;
    color: #C8A34D;
    font-family: monospace;
    background: rgba(200,163,77,0.1);
    padding: 2px 10px;
    border-radius: 6px;
    margin-left: 10px;
}

.cert-canvas-wrapper {
    background: #2a2a2a;
    border-radius: 16px;
    padding: 40px 24px;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
    overflow: auto;
}

.cert-canvas-inner {
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    /* A4 landscape: 297mm × 210mm — scale to fit screen */
    width: 100%;
    max-width: 960px;
    aspect-ratio: 297 / 210;
    overflow: hidden;
}

.cert-canvas-inner iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.cert-info-row {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 18px 24px;
    margin-top: 20px;
}
.cert-info-label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}
.cert-info-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

@media print {
    .preview-toolbar, .cert-info-row, .admin-sidebar, .admin-topbar, .admin-footer { display: none !important; }
    .cert-canvas-wrapper {
        background: transparent;
        padding: 0;
        min-height: unset;
    }
    .cert-canvas-inner {
        box-shadow: none;
        max-width: 100%;
        width: 297mm;
        height: 210mm;
    }
    body { background: #fff !important; }
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Preview Sertifikat</h1>
        <p class="page-subtitle">Pratinjau sertifikat sebelum dicetak atau diunduh</p>
    </div>
</div>

<!-- Toolbar -->
<div class="preview-toolbar" data-aos="fade-down">
    <div class="d-flex align-items-center flex-wrap gap-2">
        <span class="preview-toolbar-title">
            <i class="fas fa-certificate me-2" style="color:#C8A34D;"></i>
            <?= esc($data['participant']['name']) ?>
        </span>
        <span class="preview-toolbar-code"><?= esc($data['registration']['registration_code']) ?></span>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= base_url('admin/sertifikat') ?>" class="btn btn-sm btn-outline-secondary" style="border-radius:10px;">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
        <button onclick="printCert()" class="btn btn-sm btn-outline-primary" style="border-radius:10px;">
            <i class="fas fa-print me-1"></i>Print
        </button>
        <a href="<?= base_url('admin/sertifikat/download/' . $registrationId) ?>"
           class="btn btn-sm"
           style="border-radius:10px; background:#C8A34D; color:#121212; font-weight:700; border:none;">
            <i class="fas fa-file-pdf me-1"></i>Download PDF
        </a>
    </div>
</div>

<!-- Certificate Preview -->
<div class="cert-canvas-wrapper" data-aos="fade-up">
    <div class="cert-canvas-inner">
        <iframe id="certFrame" srcdoc="" title="Certificate Preview"></iframe>
    </div>
</div>

<!-- Registration Info -->
<div class="cert-info-row" data-aos="fade-up">
    <div class="row g-4">
        <div class="col-6 col-md-3">
            <div class="cert-info-label">Nama Peserta</div>
            <div class="cert-info-value"><?= esc($data['participant']['name']) ?></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cert-info-label">Instansi</div>
            <div class="cert-info-value"><?= esc($data['participant']['institution'] ?? '-') ?></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cert-info-label">Pelatihan</div>
            <div class="cert-info-value"><?= esc($data['training']['title']) ?></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="cert-info-label">Tanggal</div>
            <div class="cert-info-value">
                <?php
                    $s = $data['training']['start_date'];
                    $e = $data['training']['end_date'];
                    echo ($s ? date('d M', strtotime($s)) : '-') . ' – ' . ($e ? date('d M Y', strtotime($e)) : '-');
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// Inject certificate HTML into the iframe
document.addEventListener('DOMContentLoaded', function () {
    const frame = document.getElementById('certFrame');
    const certHtml = <?= json_encode($cert_html, JSON_HEX_TAG) ?>;
    frame.srcdoc = certHtml;
});

function printCert() {
    const frame = document.getElementById('certFrame');
    frame.contentWindow.focus();
    frame.contentWindow.print();
}
</script>

<?= $this->endSection() ?>
