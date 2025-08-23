<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexesToAllTables extends Migration
{
    public function up()
    {
        // === Users ===
        $this->db->query("CREATE INDEX idx_users_role ON users(role)");
        $this->db->query("CREATE INDEX idx_users_is_verified ON users(is_verified)");

        // === Teams ===
        $this->db->query("CREATE INDEX idx_teams_owner_id ON teams(owner_id)");
        $this->db->query("CREATE INDEX idx_teams_name ON teams(name)");

        // === Team Members ===
        $this->db->query("CREATE INDEX idx_team_members_team_id ON team_members(team_id)");
        $this->db->query("CREATE INDEX idx_team_members_member_id ON team_members(member_id)");
        $this->db->query("CREATE INDEX idx_team_members_status ON team_members(status)");
        $this->db->query("CREATE INDEX idx_team_members_team_member ON team_members(team_id, member_id)");

        // === Biodata ===
        $this->db->query("CREATE INDEX idx_biodata_user_id ON biodata(user_id)");
        $this->db->query("CREATE INDEX idx_biodata_nik ON biodata(nik)");
        $this->db->query("CREATE INDEX idx_biodata_phone ON biodata(phone)");

        // === Achivements ===
        $this->db->query("CREATE INDEX idx_achivements_member_id ON achivements(member_id)");
        $this->db->query("CREATE INDEX idx_achivements_tahun ON achivements(tahun)");
        $this->db->query("CREATE INDEX idx_achivements_tingkat ON achivements(tingkat)");

        // === Email Settings ===
        $this->db->query("CREATE INDEX idx_email_settings_from_email ON email_settings(from_email)");
        $this->db->query("CREATE INDEX idx_email_settings_smtp_host ON email_settings(smtp_host)");
    }

    public function down()
    {
        // === Users ===
        $this->db->query("DROP INDEX IF EXISTS idx_users_role");
        $this->db->query("DROP INDEX IF EXISTS idx_users_is_verified");

        // === Teams ===
        $this->db->query("DROP INDEX IF EXISTS idx_teams_owner_id");
        $this->db->query("DROP INDEX IF EXISTS idx_teams_name");

        // === Team Members ===
        $this->db->query("DROP INDEX IF EXISTS idx_team_members_team_id");
        $this->db->query("DROP INDEX IF EXISTS idx_team_members_member_id");
        $this->db->query("DROP INDEX IF EXISTS idx_team_members_status");
        $this->db->query("DROP INDEX IF EXISTS idx_team_members_team_member");

        // === Biodata ===
        $this->db->query("DROP INDEX IF EXISTS idx_biodata_user_id");
        $this->db->query("DROP INDEX IF EXISTS idx_biodata_nik");
        $this->db->query("DROP INDEX IF EXISTS idx_biodata_phone");

        // === Achivements ===
        $this->db->query("DROP INDEX IF EXISTS idx_achivements_member_id");
        $this->db->query("DROP INDEX IF EXISTS idx_achivements_tahun");
        $this->db->query("DROP INDEX IF EXISTS idx_achivements_tingkat");

        // === Email Settings ===
        $this->db->query("DROP INDEX IF EXISTS idx_email_settings_from_email");
        $this->db->query("DROP INDEX IF EXISTS idx_email_settings_smtp_host");
    }
}
