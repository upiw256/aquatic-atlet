<?php

namespace App\Controllers\Inspector;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BiodataModel;
use App\Models\UserModel;
use App\Models\Achivement;
use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use Mpdf\Mpdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;


class PortfolioController extends BaseController
{
    function isValidUuid($uuid) {
        return preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $uuid
        ) === 1;
    }
    public function pdf($userId)
    {
        if (!$this->isValidUuid($userId)) {
            return redirect()->to('/inspector/members')
                ->with('error', 'ID Anggota tidak valid. Pastikan ID yang dimasukkan benar.')
                ->withInput();
        }
        $text = base_url() . "portfolio/pdf/" . $userId;
        // --- Generate QR Code ---
        $writer = new PngWriter();
        $qrCode = new QrCode(
            data: $text,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
        $logo = new Logo(
            path: FCPATH . 'assets/images/logo-aquatic.png',
            resizeToWidth: 130,
            punchoutBackground: false
        );
        $qr = $writer->write($qrCode, $logo);

        // --- Ambil data utama ---
        $userModel        = new UserModel();
        $biodataModel     = new BiodataModel();      // pastikan ada method getByUserId($userId)
        $achievementModel = new Achivement();  // pastikan ada method listByUserId($userId)
        $team = new TeamMemberModel();
        // cek biodata jika kosong, kembalikan error dengan redirect
        if (!$biodataModel->getByUserId($userId)) {
            return redirect()->to('/inspector/members')
                ->with('error', 'Biodata tidak ditemukan. Beritahukan anggota untuk mengisi biodata terlebih dahulu.')
                ->withInput();
        }

        $user = $userModel->find($userId);
        if (!$user) {
            return $this->response->setStatusCode(404, 'User tidak ditemukan');
        }

        $biodata     = $biodataModel->getByUserId($userId);          // array assoc (nama, tgl_lahir, alamat, phone, dsb)
        $achievements = $achievementModel->getMemberByUserid($userId);    // array of assoc (tahun, nama, penyelenggara, peringkat/dll)
        $userbybiodata = $biodataModel->getDataFormUser($userId); // ambil data biodata lengkap dengan user info
        $dataTeam = $team->getTeamByMember($userId); // ambil data tim jika ada
        if (!$biodata) {
            return $this->response->setStatusCode(404, 'Biodata tidak ditemukan');
        }
        // --- Siapkan path foto (pakai file system path agar aman di mPDF) ---
        $fileName   = $biodata['photo'] ?? null; // misal kolom 'photo' simpan nama file
        $absPhoto   = FCPATH . $fileName ? FCPATH . 'uploads/photos/' . $fileName : null;
        if (!$absPhoto || !is_file($absPhoto)) {
            $absPhoto = FCPATH . 'assets/img/no-photo.png'; // fallback gambar default
        }
        // --- Render HTML dari view ---
        $html = view('inspector/portfolio_pdf', [
            'biodata'      => $userbybiodata,
            'achievements' => $achievements,
            'photoSrc'     => $fileName,
            'dataTeam'    => $dataTeam,
        ]);

        // --- Konfigurasi mPDF ---
        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4',
            'orientation'  => 'P',
            'margin_left'  => 12,
            'margin_right' => 12,
            'margin_top'   => 18,
            'margin_bottom' => 80,
            'default_font' => 'dejavusans', // aman unicode
        ]);

        // Header & footer (opsional)
        $mpdf->SetTitle('Portfolio - ' . ($user['name'] ?? 'User'));
        $mpdf->SetAuthor('Sistem');
        $mpdf->SetHeader('Portfolio|' . $user['name'] . '|{PAGENO}');
        $mpdf->SetFooter('    <div style="position: relative; height: 55px;">
        <!-- QR di kanan atas -->
        <div style="position: absolute; right: 0; top: 0; padding-bottom: 20px; text-align: right;">
            <p style="font-size: 10pt; margin: 0;">Scan QR untuk melihat keaslian</p>
            <img src="' . $qr->getDataUri() . '" width="150" height="150" style="display: inline-block;">
        </div>
        <!-- Garis bawah QR -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0;">
            <hr style="border: none; border-top: 1px solid #ccc; margin: 0;">
        </div>
    </div>
    <table width="100%" style="padding-top:2px; font-size:10pt;">
        <tr>
            <td style="text-align:left;">Dicetak: {DATE d-m-Y H:i}</td>
            <td style="text-align:right;">Hal. {PAGENO}/{nbpg}</td>
        </tr>
    </table>');

        // CSS kecil (boleh juga dipisah ke file CSS dan di-embed)
        $stylesheet = '
        body {
        font-family: sans-serif;
        font-size: 12pt;
        color: #000;
        }

        /* Header berbasis tabel agar kompatibel mPDF */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .header-table td {
            vertical-align: middle;  /* sejajarkan secara vertikal */
            padding: 0;
        }

        /* Kolom logo dan ukuran logo */
        .logo-cell { width: 22mm; }      /* ruang tetap di kiri */
        .logo {
            width: 16mm;                 /* kecilkan logo di PDF */
            height: auto;
            display: block;
        }

        /* Kolom judul di tengah */
        .title-cell { text-align: center; }
        .title-cell h2 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
        }
        .title-cell .sub-title {
            margin-top: 3px;
            font-size: 12pt;
            color: #555;
        }

        /* Judul section */
        h2, h3 {
            text-align: center;
            margin: 0;
        }

        /* Tabel biodata */
        .biodata {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .biodata td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .biodata .label {
            width: 160px;
            font-weight: bold;
        }

        /* Foto profil */
        .thumbnail {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .photo {
            text-align: center;
        }

        .photo img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Tabel riwayat kejuaraan */
        table.achievements {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.achievements th,
        table.achievements td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 10pt;
        }

        table.achievements th {
            background: #f0f0f0;
        }

        /* Catatan bawah */
        .note {
            font-size: 10pt;
            margin-top: 10px;
        }

        ';
        $mpdf->SetWatermarkImage(FCPATH . 'assets/images/logo-aquatic.png', 0.2); // 0.2 = transparansi
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Output ke browser (download atau inline)
        return $this->response
            ->setContentType('application/pdf')
            ->setBody($mpdf->Output('Portfolio-' . $user['name'] . '.pdf', 'I')); // 'I' inline, 'D' download
    }
    public function team($userId)
    {
        if (!$this->isValidUuid($userId)) {
            return redirect()->to('/inspector/teams')
                ->with('error', 'ID Anggota tidak valid. Pastikan ID yang dimasukkan benar.')
                ->withInput();
        }
        $text = base_url() . "team/pdf/" . $userId;
        // --- Generate QR Code ---
        $writer = new PngWriter();
        $qrCode = new QrCode(
            data: $text,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
        $logo = new Logo(
            path: FCPATH . 'assets/images/logo-aquatic.png',
            resizeToWidth: 130,
            punchoutBackground: false
        );
        $qr = $writer->write($qrCode, $logo);

        // --- Ambil data utama ---
        $teamModel = new TeamModel();
        $DataMember = $teamModel->getMemberByTeamId($userId); // ambil data tim jika ada
        $team = $teamModel->where('id', $userId)->first();
        if (empty($team['owner_id'])) {
            return redirect()->to('/inspector/teams')
                ->with('error', 'Biodata tidak ditemukan. Beritahukan anggota untuk mengisi biodata terlebih dahulu.')
                ->withInput();
        }
        $dataTeam = $teamModel->getTeamByOwnerId($team['owner_id']);
        if (!$DataMember) {
            return $this->response->setStatusCode(404, 'Team tidak ditemukan');
        }
        $html = view('inspector/team_pdf', [
            'team'      => $dataTeam,
            'DataMembers' => $DataMember,
            'qrSrc'     => $qr->getDataUri(),
        ]);

        $mpdf = new Mpdf([
            'mode'         => 'utf-8',
            'format'       => 'A4',
            'orientation'  => 'P',
            'margin_left'  => 12,
            'margin_right' => 12,
            'margin_top'   => 18,
            'margin_bottom' => 80,
            'default_font' => 'dejavusans', // aman unicode
        ]);

        $mpdf->SetTitle('Portfolio - ' . ($dataTeam['name'] ?? 'User'));
        $mpdf->SetAuthor('Sistem');
        $mpdf->SetHeader('Portfolio|' . $dataTeam['name'] . '|{PAGENO}');

        $mpdf->SetFooter('    <div style="position: relative; height: 55px;">
        <!-- QR di kanan atas -->
        <div style="position: absolute; right: 0; top: 0; padding-bottom: 20px; text-align: right;">
            <p style="font-size: 10pt; margin: 0;">Scan QR untuk melihat keaslian</p>
            <img src="' . $qr->getDataUri() . '" width="150" height="150" style="display: inline-block;">
        </div>
        <!-- Garis bawah QR -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0;">
            <hr style="border: none; border-top: 1px solid #ccc; margin: 0;">
        </div>
    </div>
    <table width="100%" style="padding-top:2px; font-size:10pt;">
        <tr>
            <td style="text-align:left;">Dicetak: {DATE d-m-Y H:i}</td>
            <td style="text-align:right;">Hal. {PAGENO}/{nbpg}</td>
        </tr>
    </table>');

        $stylesheet = '
        body {
        font-family: sans-serif;
        font-size: 12pt;
        color: #000;
        }



        /* Header berbasis tabel agar kompatibel mPDF */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .header-table td {
            vertical-align: middle;  /* sejajarkan secara vertikal */
            padding: 0;
        }

        /* Kolom logo dan ukuran logo */
        .logo-cell { width: 22mm; }      /* ruang tetap di kiri */
        .logo {
            width: 16mm;                 /* kecilkan logo di PDF */
            height: auto;
            display: block;
        }

        /* Kolom judul di tengah */
        .title-cell { text-align: center; }
        .title-cell h2 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
        }
        .title-cell .sub-title {
            margin-top: 3px;
            font-size: 12pt;
            color: #555;
        }

        /* Judul section */
        h2, h3 {
            text-align: center;
            margin: 0;
        }

        /* Tabel biodata */
        .biodata {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .biodata td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .biodata .label {
            width: 160px;
            font-weight: bold;
        }

        /* Foto profil */
        .thumbnail {
            width: 200px;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .photo {
            text-align: center;
        }

        .photo img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        /* Tabel riwayat kejuaraan */
        table.achievements {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.achievements th,
        table.achievements td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 10pt;
        }

        table.achievements th {
            background: #f0f0f0;
        }

        /* Catatan bawah */
        .note {
            font-size: 10pt;
            margin-top: 10px;
        }

        ';
        $mpdf->SetWatermarkImage(FCPATH . 'assets/images/logo-aquatic.png', 0.2); // 0.2 = transparansi
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Output ke browser (download atau inline)
        return $this->response
            ->setContentType('application/pdf')
            ->setBody($mpdf->Output('Portfolio-' . $dataTeam['name'] . '.pdf', 'I'));
    }
    public function preview($userId)
    {
        $userModel        = new UserModel();
        $biodataModel     = new BiodataModel();
        $achievementModel = new Achivement();

        $user = $userModel->find($userId);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan");
        }

        $biodata      = $biodataModel->getByUserId($userId);
        $achievements = $achievementModel->getAchivementsByMember($userId);
        $userbybiodata = $biodataModel->getDataFormUser($userId);

        return view('inspector/portfolio_pdf', [
            'biodata'      => $userbybiodata,
            'achievements' => $achievements,
            'photoSrc'     => $biodata['photo'] ?? null,
        ]);
    }
}
