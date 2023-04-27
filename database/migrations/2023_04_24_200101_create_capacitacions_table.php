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
        Schema::create('capacitacions', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('tipo', 30)->nullable();
            $table->decimal('horas',6 ,2)->nullable();
            $table->date('desde')->nullable();
            $table->date('hasta')->nullable();
            $table->tinyInteger('estado')->nullable()->default(1);//null inactivo, 1 activo

            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

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
        Schema::dropIfExists('capacitacions');
    }
};
