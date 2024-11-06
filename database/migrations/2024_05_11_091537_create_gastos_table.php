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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_portal');
            $table->string('titulo');
            $table->string('tipo');
            $table->double('cantidad');
            $table->date('fecha');
            $table->string('pagado_por');
            $table->string('participantes');
            $table->unsignedBigInteger('creado_por');
            $table->timestamps();

            $table->foreign('id_portal')->references('id')->on('portales')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
