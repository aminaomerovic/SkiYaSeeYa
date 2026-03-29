<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::statement("ALTER TABLE equipment MODIFY COLUMN type ENUM('skis','boots','jacket','helmet','poles') NOT NULL");
}

    public function down()
{
    DB::statement("ALTER TABLE equipment MODIFY COLUMN type ENUM('skis','boots','jacket') NOT NULL");
}
};
