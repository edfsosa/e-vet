<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones. Esta función crea las tablas necesarias en la base de datos para administrar los trabajos en cola de Laravel.
     */
    public function up(): void
    {
        // Crea la tabla 'jobs', donde se almacenan los trabajos individuales en cola.
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // ID único del trabajo
            $table->string('queue')->index(); // Nombre de la cola a la que pertenece el trabajo (indexado para búsquedas eficientes).
            $table->longText('payload'); // Datos del trabajo (serializados).
            $table->unsignedTinyInteger('attempts'); // Número de intentos de ejecución.
            $table->unsignedInteger('reserved_at')->nullable(); // Marca de tiempo de reserva (cuando un trabajador toma el trabajo).
            $table->unsignedInteger('available_at'); // Marca de tiempo de disponibilidad (cuándo el trabajo estará disponible para ser procesado).
            $table->unsignedInteger('created_at'); // Marca de tiempo de creación del trabajo.
        });

        // Crea la tabla 'job_batches', que agrupa trabajos relacionados en lotes.
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID único del lote de trabajos.
            $table->string('name'); // Nombre del lote.
            $table->integer('total_jobs'); // Número total de trabajos en el lote.
            $table->integer('pending_jobs'); // Número de trabajos pendientes.
            $table->integer('failed_jobs'); // Número de trabajos fallidos.
            $table->longText('failed_job_ids'); // IDs de los trabajos fallidos.
            $table->mediumText('options')->nullable(); // Opciones adicionales del lote (serializadas).
            $table->integer('cancelled_at')->nullable(); // Marca de tiempo de cancelación (si el lote fue cancelado).
            $table->integer('created_at'); // Marca de tiempo de creación del lote.
            $table->integer('finished_at')->nullable(); // Marca de tiempo de finalización (cuando todos los trabajos del lote han terminado).
        });

        // Crea la tabla 'failed_jobs', que almacena trabajos que fallaron después de múltiples intentos.
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // ID único del trabajo fallido.
            $table->string('uuid')->unique(); // UUID único del trabajo.
            $table->text('connection'); // Nombre de la conexión a la cola.
            $table->text('queue'); // Nombre de la cola.
            $table->longText('payload'); // Datos del trabajo (serializados).
            $table->longText('exception'); // Mensaje de excepción del fallo.
            $table->timestamp('failed_at')->useCurrent(); // Marca de tiempo del fallo.
        });
    }

    /**
     * Revierte las migraciones. Elimina las tablas 'jobs', 'job_batches' y 'failed_jobs' de la base de datos.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
