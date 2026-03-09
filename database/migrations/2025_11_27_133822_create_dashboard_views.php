<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1) total solde (un seul enregistrement)
        DB::statement(<<<SQL
            CREATE VIEW vue_total_solde AS
            SELECT COALESCE(SUM(solde),0) AS total_solde
            FROM compte_bancaires
            WHERE statut = 'actif';
            SQL
        );

        // 2) comptes par statut
        DB::statement(<<<SQL
            CREATE VIEW vue_comptes_par_statut AS
            SELECT statut, COUNT(*) AS total
            FROM compte_bancaires
            GROUP BY statut;
            SQL
        );

        // 3) virements par mois
        DB::statement(<<<SQL
            CREATE VIEW vue_virements_par_mois AS
            SELECT DATE_FORMAT(created_at, '%Y-%m') AS mois,
                   COUNT(*) AS nombre,
                   COALESCE(SUM(montant),0) AS total
            FROM virements
            GROUP BY DATE_FORMAT(created_at, '%Y-%m')
            ORDER BY mois DESC;
            SQL
        );

        // 4) statut virements
        DB::statement(<<<SQL
            CREATE VIEW vue_statut_virements AS
            SELECT statut, COUNT(*) AS total
            FROM virements
            GROUP BY statut;
            SQL
        );

        // 5) top 10 clients par solde total
        DB::statement(<<<SQL
            CREATE VIEW vue_top_clients AS
            SELECT users.id, users.name, users.prenom,
                   COALESCE(SUM(compte_bancaires.solde),0) AS total_solde
            FROM users
            JOIN compte_bancaires ON users.id = compte_bancaires.user_id
            WHERE compte_bancaires.statut = 'actif'
            GROUP BY users.id, users.name, users.prenom
            ORDER BY total_solde DESC
            LIMIT 10;
            SQL
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vue_top_clients");
        DB::statement("DROP VIEW IF EXISTS vue_statut_virements");
        DB::statement("DROP VIEW IF EXISTS vue_virements_par_mois");
        DB::statement("DROP VIEW IF EXISTS vue_comptes_par_statut");
        DB::statement("DROP VIEW IF EXISTS vue_total_solde");
    }
};
