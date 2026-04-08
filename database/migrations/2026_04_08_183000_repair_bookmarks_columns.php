<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('bookmarks', 'user_id')) {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('bookmarks', 'post_id')) {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->unsignedBigInteger('post_id')->nullable()->after('user_id');
            });
        }

        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS bookmarks_user_id_post_id_unique ON bookmarks (user_id, post_id)');

            return;
        }

        try {
            Schema::table('bookmarks', function (Blueprint $table) {
                $table->unique(['user_id', 'post_id']);
            });
        } catch (QueryException) {
            // Index already exists.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS bookmarks_user_id_post_id_unique');
        } else {
            try {
                Schema::table('bookmarks', function (Blueprint $table) {
                    $table->dropUnique('bookmarks_user_id_post_id_unique');
                });
            } catch (QueryException) {
                // Index does not exist.
            }
        }

        Schema::table('bookmarks', function (Blueprint $table) {
            if (Schema::hasColumn('bookmarks', 'post_id')) {
                $table->dropColumn('post_id');
            }

            if (Schema::hasColumn('bookmarks', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
