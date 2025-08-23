<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;
use Ramsey\Uuid\Uuid;

class Competition extends Model
{
    protected $table            = 'competitions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = false;
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $beforeInsert = ['generateUUID', 'checkDates'];
    protected $beforeUpdate = ['checkDates'];

    protected $allowedFields    = [
        'id',
        'name',
        'description',
        'level',
        'start_date',
        'end_date',
        'registration_deadline',
        'location',
        'created_at',
        'updated_at',
    ];

    /**
     * Cek apakah pendaftaran masih dibuka
     *
     * @return bool
     */
    protected function generateUUID(array $data)
    {
        if (!isset($data['data']['id']) || empty($data['data']['id'])) {
            $data['data']['id'] = Uuid::uuid4()->toString();
        }
        return $data;
    }
    public function isRegistrationOpen(string $competitionId): bool
    {
        $competition = $this->find($competitionId);

        if (!$competition) {
            throw new Exception('Competition not found.');
        }

        // Jika tidak ada batasan deadline, berarti selalu bisa daftar
        if (empty($competition['registration_deadline'])) {
            return true;
        }

        return (date('Y-m-d') <= $competition['registration_deadline']);
    }

    /**
     * Ambil daftar tim yang ikut kompetisi
     */
    public function getTeams(string $competitionId): array
    {
        $db = \Config\Database::connect();

        return $db->table('competition_teams ct')
            ->select('ct.id, t.id as team_id, t.name as team_name')
            ->join('teams t', 't.id = ct.team_id')
            ->where('ct.competition_id', $competitionId)
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil daftar atlet dalam kompetisi
     */
    public function getAthletes(string $competitionId): array
    {
        $db = \Config\Database::connect();

        return $db->table('competition_teams ct')
            ->select('a.id as athlete_id, u.name as athlete_name, t.name as team_name')
            ->join('teams t', 't.id = ct.team_id')
            ->join('team_members a', 'a.team_id = t.id')
            ->join('users u', 'u.id = a.member_id')
            ->where('ct.competition_id', $competitionId)
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil daftar pertandingan dalam kompetisi
     */
    public function getMatches(string $competitionId): array
    {
        $db = \Config\Database::connect();

        return $db->table('matches m')
            ->select('m.id, t1.name as team1, t2.name as team2, m.winner_team_id, tw.name as winner')
            ->join('teams t1', 't1.id = m.team1_id')
            ->join('teams t2', 't2.id = m.team2_id')
            ->join('teams tw', 'tw.id = m.winner_team_id', 'left')
            ->where('m.competition_id', $competitionId)
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil pencetak gol (scorers) per kompetisi
     */
    public function getScorers(string $competitionId): array
    {
        $db = \Config\Database::connect();

        return $db->table('match_goals g')
            ->select('u.name as athlete_name, t.name as team_name, COUNT(g.id) as total_goals')
            ->join('team_members a', 'a.id = g.athlete_id')
            ->join('users u', 'u.id = a.member_id')
            ->join('teams t', 't.id = a.team_id')
            ->join('matches m', 'm.id = g.match_id')
            ->where('m.competition_id', $competitionId)
            ->groupBy('u.name, t.name')
            ->orderBy('total_goals', 'DESC')
            ->get()
            ->getResultArray();
    }
    protected $validationRules = [
        'name'                  => 'required|min_length[3]|max_length[150]',
        'description'           => 'required',
        'start_date'            => 'required|valid_date',
        'end_date'              => 'required|valid_date|check_end_date[start_date]',
        'registration_deadline' => 'required|valid_date|check_registration_deadline[start_date]',
        'level'                 => 'required|in_list[local,kabupaten,provinsi,nasional,internasional]',
        'location'              => 'required',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama kompetisi wajib diisi.',
            'min_length' => 'Nama kompetisi minimal 3 karakter.',
        ],
        'start_date' => [
            'required'   => 'Tanggal mulai wajib diisi.',
            'valid_date' => 'Format tanggal mulai tidak valid.',
        ],
        'end_date' => [
            'check_end_date' => 'Tanggal selesai harus setelah tanggal mulai.'
        ],
        'registration_deadline' => [
            'rules'  => 'required|valid_date[Y-m-d]|check_registration_deadline[start_date]',
            'errors' => [
                'check_registration_deadline' => 'Batas pendaftaran harus sebelum tanggal mulai.',
            ]
        ],
    ];

    // custom validator
    protected function checkDates(array $data)
    {
        $start  = strtotime($data['data']['start_date'] ?? '');
        $end    = strtotime($data['data']['end_date'] ?? '');
        $reg    = strtotime($data['data']['registration_deadline'] ?? '');

        if ($start && $end && $start > $end) {
            $this->validation->setError('end_date', 'Tanggal selesai harus setelah tanggal mulai.');
            // tetap return $data supaya tidak error
            return $data;
        }

        if ($reg && $start && $reg > $start) {
            $this->validation->setError('registration_deadline', 'Batas pendaftaran harus sebelum tanggal mulai.');
            return $data;
        }

        return $data;
    }
}
