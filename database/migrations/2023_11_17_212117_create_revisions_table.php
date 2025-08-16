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
        Schema::create('revisions', function (Blueprint $table) {
            $table->id();

            $table->date('f_asignacion');
            $table->date('f_revision')->nullable();
            $table->text('observaciones')->nullable();
            $table->tinyInteger('estado_doc')->nullable(); //1 aprobado, 2 aprobado con notas, 3 revisar y volver a enviar, 4 rechazado
            $table->tinyInteger('estado')->nullable(); //null pendiente, 1 revisado
            $table->tinyInteger('t_revision')->nullable();

            $table->unsignedBigInteger('documento_id');
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('revisions');
    }
};
