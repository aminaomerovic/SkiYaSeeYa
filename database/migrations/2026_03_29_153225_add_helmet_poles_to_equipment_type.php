<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE equipment MODIFY COLUMN type ENUM('skis','boots','jacket','helmet','poles') NOT NULL");
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE equipment MODIFY COLUMN type ENUM('skis','boots','jacket') NOT NULL");
        }
    }
};