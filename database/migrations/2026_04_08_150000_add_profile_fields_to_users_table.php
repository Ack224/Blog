<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('theme');
            }

            if (! Schema::hasColumn('users', 'website_url')) {
                $table->string('website_url')->nullable()->after('bio');
            }

            if (! Schema::hasColumn('users', 'github_url')) {
                $table->string('github_url')->nullable()->after('website_url');
            }

            if (! Schema::hasColumn('users', 'x_url')) {
                $table->string('x_url')->nullable()->after('github_url');
            }

            if (! Schema::hasColumn('users', 'locale')) {
                $table->string('locale', 5)->default('pl')->after('x_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [];

            foreach (['bio', 'website_url', 'github_url', 'x_url', 'locale'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columnsToDrop[] = $column;
                }
            }

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
