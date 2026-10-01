<?php

namespace Modules\Registration\Models;

use App\Models\BaseModel;

class CertificateModel extends BaseModel
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uuid', 'registration_code', 'training_id', 'participant_id', 'status',
        'payment_method', 'payment_proof', 'payment_date', 'amount',
        'special_request', 'certificate_path', 'certificate_issued',
        'notes', 'confirmed_by', 'confirmed_at',
    ];

    /**
     * Fetch all data required to render a certificate for a given registration ID.
     *
     * Joins: registrations → participants → trainings → company_profile (as key-value).
     */
    public static function getCertificateData(int $registrationId): ?array
    {
        $db = \Config\Database::connect();

        $row = $db->table('registrations r')
            ->select('r.*, p.name AS participant_name, p.email AS participant_email,
                      p.phone AS participant_phone, p.institution AS participant_institution,
                      p.position AS participant_position,
                      t.title AS training_title, t.start_date, t.end_date,
                      l.name AS location, l.city AS location_city,
                      t.description AS training_description')
            ->join('participants p', 'p.id = r.participant_id', 'left')
            ->join('trainings t', 't.id = r.training_id', 'left')
            ->join('locations l', 'l.id = t.location_id', 'left')
            ->where('r.id', $registrationId)
            ->where('r.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$row) {
            return null;
        }

        // Fetch only the profile keys needed for certificate rendering
        $needed = ['company_name', 'company_tagline', 'founder_name', 'founder_title'];
        $profileRows = $db->table('company_profile')->whereIn('key', $needed)->get()->getResultArray();
        $profile = [];
        foreach ($profileRows as $pr) {
            $value = $pr['value'];
            if (($pr['type'] ?? '') === 'json') {
                $value = json_decode($value, true);
            }
            $profile[$pr['key']] = $value;
        }

        return [
            'registration' => $row,
            'participant'  => [
                'name'         => $row['participant_name'],
                'email'        => $row['participant_email'],
                'phone'        => $row['participant_phone'],
                'institution'  => $row['participant_institution'],
                'position'     => $row['participant_position'],
            ],
            'training' => [
                'title'       => $row['training_title'],
                'start_date'  => $row['start_date'],
                'end_date'    => $row['end_date'],
                'location'    => $row['location'],
                'description' => $row['training_description'],
            ],
            'profile' => $profile,
        ];
    }

    /**
     * Build the HTML certificate template string used by both browser preview and Dompdf.
     *
     * @param array $data  Return value of getCertificateData()
     * @param bool  $embed Whether images should be embedded as base64 (for Dompdf PDF)
     */
    public static function buildCertificateHtml(array $data, bool $embed = false): string
    {
        $reg         = $data['registration'];
        $participant = $data['participant'];
        $training    = $data['training'];
        $profile     = $data['profile'];

        $companyName   = $profile['company_name']  ?? 'CV. Bagus Kencana Cakrada';
        $companyTagline = $profile['company_tagline'] ?? 'Building Knowledge & Capacity';
        $founderName   = $profile['founder_name']   ?? 'Dr. I Bagus Kencana, S.E., M.M.';
        $founderTitle  = $profile['founder_title']  ?? 'Direktur';

        $participantName = esc($participant['name']);
        $institution     = esc($participant['institution'] ?? '');
        $trainingTitle   = esc($training['title']);
        $code            = esc($reg['registration_code']);

        $startDate = $training['start_date'] ? date('d', strtotime($training['start_date'])) : '-';
        $endDate   = $training['end_date']   ? date('d M Y', strtotime($training['end_date'])) : '-';
        $startMonth = $training['start_date'] ? date('M Y', strtotime($training['start_date'])) : '';
        $dateRange = ($training['start_date'] && $training['end_date'])
            ? date('d', strtotime($training['start_date'])) . ' – ' . date('d F Y', strtotime($training['end_date']))
            : '-';
        $location = esc($training['location'] ?? 'Bali');

        // Logo path — prefer base64 embed for Dompdf
        $logoSrc = base_url('assets/images/logo/logo_BKC_2.png');
        if ($embed) {
            $logoPath = ROOTPATH . 'public/assets/images/logo/logo_BKC_2.png';
            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
                $ext      = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
                $mime     = $ext === 'png' ? 'image/png' : 'image/jpeg';
                $logoSrc  = "data:{$mime};base64,{$logoData}";
            }
        }

        $issuedDate = date('d F Y');

        $html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;600&display=swap');

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    width: 297mm;
    height: 210mm;
    background: #fff;
    font-family: 'Inter', sans-serif;
  }

  .cert-wrap {
    width: 297mm;
    height: 210mm;
    position: relative;
    background: #ffffff;
    overflow: hidden;
  }

  /* Outer gold border */
  .border-outer {
    position: absolute;
    inset: 8mm;
    border: 3px solid #C8A34D;
  }

  /* Inner gold border */
  .border-inner {
    position: absolute;
    inset: 11mm;
    border: 1px solid #C8A34D;
  }

  /* Corner ornaments */
  .corner {
    position: absolute;
    width: 20mm;
    height: 20mm;
    border-color: #C8A34D;
    border-style: solid;
  }
  .corner-tl { top: 6mm; left: 6mm; border-width: 3px 0 0 3px; }
  .corner-tr { top: 6mm; right: 6mm; border-width: 3px 3px 0 0; }
  .corner-bl { bottom: 6mm; left: 6mm; border-width: 0 0 3px 3px; }
  .corner-br { bottom: 6mm; right: 6mm; border-width: 0 3px 3px 0; }

  /* Background watermark */
  .bg-watermark {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-size: 120pt;
    color: rgba(200,163,77,0.05);
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    letter-spacing: 0;
    white-space: nowrap;
    pointer-events: none;
  }

  .cert-content {
    position: absolute;
    inset: 14mm;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    text-align: center;
  }

  /* Header */
  .cert-header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid rgba(200,163,77,0.4);
    margin-bottom: 4px;
  }

  .cert-logo {
    height: 40px;
    width: auto;
  }

  .cert-company {
    text-align: left;
  }
  .cert-company-name {
    font-size: 11pt;
    font-weight: 700;
    color: #1E4FA3;
    line-height: 1.2;
  }
  .cert-company-tagline {
    font-size: 7.5pt;
    color: #C8A34D;
    font-style: italic;
  }

  /* Title */
  .cert-title-wrap { margin: 2mm 0; }
  .cert-label {
    font-size: 8pt;
    letter-spacing: 5px;
    text-transform: uppercase;
    color: #888;
  }
  .cert-title {
    font-size: 26pt;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    color: #1E4FA3;
    letter-spacing: 2px;
    line-height: 1.1;
  }
  .cert-subtitle {
    font-size: 8pt;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #C8A34D;
    margin-top: 2px;
  }

  /* Divider */
  .gold-divider {
    width: 80mm;
    height: 2px;
    background: linear-gradient(to right, transparent, #C8A34D, transparent);
    margin: 3mm auto;
  }

  /* Body text */
  .cert-given-to {
    font-size: 9pt;
    color: #555;
    margin-bottom: 2mm;
  }

  .cert-name {
    font-size: 22pt;
    font-family: 'Playfair Display', serif;
    font-style: italic;
    color: #C8A34D;
    font-weight: 400;
    line-height: 1.2;
    margin-bottom: 1mm;
  }

  .cert-institution {
    font-size: 9pt;
    color: #666;
    margin-bottom: 3mm;
  }

  .cert-has-attended {
    font-size: 9pt;
    color: #555;
    margin-bottom: 2mm;
  }

  .cert-training-title {
    font-size: 13pt;
    font-weight: 700;
    color: #1E4FA3;
    font-family: 'Playfair Display', serif;
    line-height: 1.3;
    margin-bottom: 2mm;
    max-width: 200mm;
  }

  .cert-date-loc {
    font-size: 8.5pt;
    color: #555;
  }

  /* Footer / signature row */
  .cert-footer {
    width: 100%;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-top: 2mm;
  }

  /* Code */
  .cert-code {
    font-size: 7pt;
    color: #aaa;
    text-align: left;
  }

  /* QR placeholder */
  .cert-qr {
    width: 18mm;
    height: 18mm;
    border: 1px dashed #C8A34D;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5pt;
    color: #C8A34D;
    flex-direction: column;
    gap: 2px;
  }

  /* Signature block */
  .sig-block {
    text-align: center;
  }
  .sig-seal {
    width: 20mm;
    height: 20mm;
    border: 2px solid #C8A34D;
    border-radius: 50%;
    margin: 0 auto 2mm auto;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5pt;
    color: #C8A34D;
  }
  .sig-line {
    width: 40mm;
    border-top: 1px solid #333;
    margin: 0 auto 1mm auto;
  }
  .sig-name {
    font-size: 8pt;
    font-weight: 700;
    color: #1E4FA3;
  }
  .sig-title {
    font-size: 7pt;
    color: #777;
  }

  .cert-issued {
    font-size: 7pt;
    color: #aaa;
    text-align: right;
  }
</style>
</head>
<body>
<div class="cert-wrap">
  <!-- Borders -->
  <div class="border-outer"></div>
  <div class="border-inner"></div>
  <!-- Corners -->
  <div class="corner corner-tl"></div>
  <div class="corner corner-tr"></div>
  <div class="corner corner-bl"></div>
  <div class="corner corner-br"></div>
  <!-- Watermark -->
  <div class="bg-watermark">BKC</div>

  <div class="cert-content">
    <!-- Header -->
    <div class="cert-header">
      <img src="{$logoSrc}" alt="BKC Logo" class="cert-logo">
      <div class="cert-company">
        <div class="cert-company-name">{$companyName}</div>
        <div class="cert-company-tagline">{$companyTagline}</div>
      </div>
    </div>

    <!-- Title -->
    <div class="cert-title-wrap">
      <div class="cert-label">Piagam Penghargaan</div>
      <div class="cert-title">SERTIFIKAT</div>
      <div class="cert-subtitle">Keikutsertaan</div>
    </div>

    <div class="gold-divider"></div>

    <!-- Body -->
    <div>
      <div class="cert-given-to">Diberikan kepada:</div>
      <div class="cert-name">{$participantName}</div>
      <div class="cert-institution">{$institution}</div>
      <div class="cert-has-attended">Telah mengikuti pelatihan:</div>
      <div class="cert-training-title">{$trainingTitle}</div>
      <div class="cert-date-loc">
        <strong>{$dateRange}</strong> &nbsp;|&nbsp; {$location}
      </div>
    </div>

    <div class="gold-divider"></div>

    <!-- Footer -->
    <div class="cert-footer">
      <!-- Code & Issued -->
      <div>
        <div class="cert-code">No. Sertifikat: {$code}</div>
        <div class="cert-issued">Diterbitkan: {$issuedDate}</div>
      </div>

      <!-- Signature -->
      <div class="sig-block">
        <div class="sig-seal"><span>STEMPEL</span></div>
        <div class="sig-line"></div>
        <div class="sig-name">{$founderName}</div>
        <div class="sig-title">{$founderTitle}</div>
      </div>

      <!-- QR code placeholder -->
      <div class="cert-qr">
        <span>&#x25A9;</span>
        <span>VERIFY</span>
      </div>
    </div>
  </div>
</div>
</body>
</html>
HTML;

        return $html;
    }

    /**
     * Generate a certificate PDF for the given registration data using Dompdf.
     *
     * @param array  $data   Return value of getCertificateData()
     * @param bool   $save   If true, saves to public/uploads/certificates/; returns file path.
     *                       If false, returns the raw PDF string.
     */
    public static function generateCertificatePdf(array $data, bool $save = false): string
    {
        $html = static::buildCertificateHtml($data, true);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'serif');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $pdfContent = $dompdf->output();

        if ($save) {
            $code = $data['registration']['registration_code'];
            $dir  = ROOTPATH . 'public/uploads/certificates/';
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $path = $dir . $code . '.pdf';
            file_put_contents($path, $pdfContent);
            return $path;
        }

        return $pdfContent;
    }
}
