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
        if (! Schema::hasColumn('followers', 'follower_user_id')) {
            Schema::table('followers', function (Blueprint $table) {
                $table->unsignedBigInteger('follower_user_id')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('followers', 'following_user_id')) {
            Schema::table('followers', function (Blueprint $table) {
                $table->unsignedBigInteger('following_user_id')->nullable()->after('follower_user_id');
            });
        }

        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS followers_follower_user_id_following_user_id_unique ON followers (follower_user_id, following_user_id)');

            return;
        }

        try {
            Schema::table('followers', function (Blueprint $table) {
                $table->unique(['follower_user_id', 'following_user_id']);
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
            DB::statement('DROP INDEX IF EXISTS followers_follower_user_id_following_user_id_unique');
        } else {
            try {
                Schema::table('followers', function (Blueprint $table) {
                    $table->dropUnique('followers_follower_user_id_following_user_id_unique');
                });
            } catch (QueryException) {
                // Index does not exist.
            }
        }

        Schema::table('followers', function (Blueprint $table) {
            if (Schema::hasColumn('followers', 'following_user_id')) {
                $table->dropColumn('following_user_id');
            }

            if (Schema::hasColumn('followers', 'follower_user_id')) {
                $table->dropColumn('follower_user_id');
            }
        });
    }
};
