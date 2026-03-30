<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('confirmed','completed','rejected') NOT NULL DEFAULT 'confirmed'");
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE reservations MODIFY COLUMN status ENUM('confirmed','completed') NOT NULL DEFAULT 'confirmed'");
        }
    }
};