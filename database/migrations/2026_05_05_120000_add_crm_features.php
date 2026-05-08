<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('secteur')->nullable()->after('source');
            $table->string('taille')->nullable()->after('secteur');
            $table->index(['commercial_id', 'statut']);
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->string('type')->default('standard')->after('titre');
            $table->index(['commercial_id', 'etape']);
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->string('signature_status')->default('pending')->after('statut');
            $table->string('signature_url')->nullable()->after('signature_status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('api_token', 80)->nullable()->unique()->after('remember_token');
            $table->json('dashboard_preferences')->nullable()->after('api_token');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['secteur', 'taille']);
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn(['signature_status', 'signature_url']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['api_token', 'dashboard_preferences']);
        });
    }
};
