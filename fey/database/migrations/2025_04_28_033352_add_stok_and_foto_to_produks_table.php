<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStokAndFotoToProduksTable extends Migration
{
    public function up()
{
    Schema::table('produks', function (Blueprint $table) {
        $table->integer('stok')->default(0);  // Add the stok column
    });
}

public function down()
{
    Schema::table('produks', function (Blueprint $table) {
        $table->dropColumn('stok');  // Drop the stok column if migration is rolled back
    });
}

}
