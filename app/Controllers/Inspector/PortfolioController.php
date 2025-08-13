<?php

namespace App\Controllers\Inspector;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BiodataModel;
use App\Models\UserModel;
use App\Models\Achivement;
use App\Models\TeamMemberModel;
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
    public function pdf($userId)
    {
        $text = base_url() . "inspector/portfolio/" . $userId;
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
            return redirect()->to('/inspector/admin/members')
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
            'margin_bottom' => 18,
            'default_font' => 'dejavusans', // aman unicode
        ]);

        // Header & footer (opsional)
        $mpdf->SetTitle('Portfolio - ' . ($user['name'] ?? 'User'));
        $mpdf->SetAuthor('Sistem');
        $mpdf->SetHeader('Portfolio|' . $user['name'] . '|{PAGENO}');
        $mpdf->SetFooter('Dicetak: {DATE d-m-Y H:i}||Hal. {PAGENO}/{nbpg}');

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
        $mpdf->WriteFixedPosHTML(
            '<img src="' . $qr->getDataUri() . '" alt="QR Code">',
            160, // X posisi dari kiri (mm)
            120, // Y posisi dari atas (mm)
            40,  // Lebar (mm)
            40   // Tinggi (mm)
        );
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

        // Output ke browser (download atau inline)
        return $this->response
            ->setContentType('application/pdf')
            ->setBody($mpdf->Output('Portfolio-' . $user['name'] . '.pdf', 'I')); // 'I' inline, 'D' download
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
