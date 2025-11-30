<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('creditos', function (Blueprint $table) {
            // CORRECCIÓN CRÍTICA: Cambiado de unsignedBigInteger a unsignedInteger
            // para coincidir con el tipo de dato INT(11) de la tabla 'tickets'.
            $table->unsignedInteger('ticket_id')->after('cliente_id')->nullable();

            // La definición de la clave foránea permanece igual
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('creditos', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->dropColumn('ticket_id');
        });
    }
};
