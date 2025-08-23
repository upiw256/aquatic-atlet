<?php

namespace App\Validation;

class CustomRules
{
    /**
     * Pastikan tanggal selesai >= tanggal mulai
     */
    public function check_end_date(string $end, string $startField, array $data): bool
    {
        return strtotime($end) >= strtotime($data[$startField] ?? '');
    }

    public function check_registration_deadline(string $deadline, string $startField, array $data): bool
    {
        return strtotime($deadline) <= strtotime($data[$startField] ?? '');
    }

    /**
     * Gabungan pengecekan semua tanggal sekaligus
     */
    public function checkDates(array $data): bool
    {
        $start    = strtotime($data['start_date'] ?? '');
        $end      = strtotime($data['end_date'] ?? '');
        $deadline = strtotime($data['registration_deadline'] ?? '');

        if (!$start || !$end || !$deadline) {
            return false;
        }

        // end >= start && deadline <= start
        return ($end >= $start) && ($deadline <= $start);
    }
}
