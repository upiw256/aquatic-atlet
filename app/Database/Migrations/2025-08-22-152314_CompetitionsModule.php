<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CompetitionsModule extends Migration
{
    public function up()
    {
        /**
         * 1. competitions
         */
        $this->forge->addField([
            'id'          => ['type' => 'UUID', 'null' => false],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'start_date'  => ['type' => 'DATE', 'null' => true],
            'end_date'    => ['type' => 'DATE', 'null' => true],
            'created_at'  => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'  => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('competitions');

        /**
         * 2. competition_teams (relasi many-to-many)
         */
        $this->forge->addField([
            'id'             => ['type' => 'UUID', 'null' => false],
            'competition_id' => ['type' => 'UUID', 'null' => false],
            'team_id'        => ['type' => 'UUID', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('competition_id', 'competitions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('team_id', 'teams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('competition_teams');

        /**
         * 3. matches
         */
        $this->forge->addField([
            'id'              => ['type' => 'UUID', 'null' => false],
            'competition_id'  => ['type' => 'UUID', 'null' => false],
            'team_home'       => ['type' => 'UUID', 'null' => false],
            'team_away'       => ['type' => 'UUID', 'null' => false],
            'winner_team_id'  => ['type' => 'UUID', 'null' => true],
            'match_date'      => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at'      => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('competition_id', 'competitions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('team_home', 'teams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('team_away', 'teams', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('winner_team_id', 'teams', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('matches');

        /**
         * 4. match_athletes
         */
        $this->forge->addField([
            'id'        => ['type' => 'UUID', 'null' => false],
            'match_id'  => ['type' => 'UUID', 'null' => false],
            'athlete_id'=> ['type' => 'UUID', 'null' => false], // FK ke team_members
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('match_id', 'matches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('athlete_id', 'team_members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('match_athletes');

        /**
         * 5. goals
         */
        $this->forge->addField([
            'id'         => ['type' => 'UUID', 'null' => false],
            'match_id'   => ['type' => 'UUID', 'null' => false],
            'athlete_id' => ['type' => 'UUID', 'null' => false],
            'minute'     => ['type' => 'INT', 'null' => true], // menit ke berapa gol dicetak
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('match_id', 'matches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('athlete_id', 'team_members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('goals');

        /**
         * 6. athlete_achievements
         */
        $this->forge->addField([
            'id'             => ['type' => 'UUID', 'null' => false],
            'athlete_id'     => ['type' => 'UUID', 'null' => false],
            'competition_id' => ['type' => 'UUID', 'null' => true],
            'title'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'description'    => ['type' => 'TEXT', 'null' => true],
            'achieved_at'    => ['type' => 'DATE', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('athlete_id', 'team_members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('competition_id', 'competitions', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('athlete_achievements');

        /**
         * Indexing khusus PostgreSQL
         */
        $this->db->query('CREATE INDEX idx_competitions_name ON competitions (name)');
        $this->db->query('CREATE INDEX idx_competition_teams_competition ON competition_teams (competition_id)');
        $this->db->query('CREATE INDEX idx_competition_teams_team ON competition_teams (team_id)');
        $this->db->query('CREATE INDEX idx_matches_competition ON matches (competition_id)');
        $this->db->query('CREATE INDEX idx_matches_home ON matches (team_home)');
        $this->db->query('CREATE INDEX idx_matches_away ON matches (team_away)');
        $this->db->query('CREATE INDEX idx_matches_winner ON matches (winner_team_id)');
        $this->db->query('CREATE INDEX idx_match_athletes_match ON match_athletes (match_id)');
        $this->db->query('CREATE INDEX idx_match_athletes_athlete ON match_athletes (athlete_id)');
        $this->db->query('CREATE INDEX idx_goals_match ON goals (match_id)');
        $this->db->query('CREATE INDEX idx_goals_athlete ON goals (athlete_id)');
        $this->db->query('CREATE INDEX idx_achievements_athlete ON athlete_achievements (athlete_id)');
        $this->db->query('CREATE INDEX idx_achievements_competition ON athlete_achievements (competition_id)');
    }

    public function down()
    {
        $this->forge->dropTable('athlete_achievements', true);
        $this->forge->dropTable('goals', true);
        $this->forge->dropTable('match_athletes', true);
        $this->forge->dropTable('matches', true);
        $this->forge->dropTable('competition_teams', true);
        $this->forge->dropTable('competitions', true);
    }
}
