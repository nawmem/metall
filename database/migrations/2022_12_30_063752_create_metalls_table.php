<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metalls', function (Blueprint $table) {
            $table->id();
            $table->string('event');
            $table->float('price_one', 8,2)->default(00,00); // цена за кг
            $table->float('massa', 8,2)->default(00,00); // масса
            $table->float('price_all', 8,2)->default(00,00); // цена за всю массу
            $table->integer('blockage'); // засор %
            $table->integer('metall_types_id'); // ид типа металла
            $table->integer('metall_categories_id'); // ид категории металла
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metalls');
    }
};
