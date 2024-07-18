<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones. Esta función crea las tablas necesarias en la base de datos para gestionar el almacenamiento en caché de Laravel.
     */
    public function up(): void
    {
        // Crea la tabla 'cache', que almacena los datos en caché.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Clave única que identifica el elemento en caché.
            $table->mediumText('value'); // Valor almacenado en caché (datos serializados).
            $table->integer('expiration'); // Marca de tiempo UNIX que indica cuándo expira el caché.
        });

        // Crea la tabla 'cache_locks', que gestiona bloqueos para operaciones atómicas en la caché.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Clave que identifica el elemento bloqueado.
            $table->string('owner'); // Identificador del proceso que posee el bloqueo.
            $table->integer('expiration'); // Marca de tiempo UNIX que indica cuándo expira el bloqueo.
        });
    }

    /**
     * Revierte las migraciones. Esta función elimina las tablas 'cache' y 'cache_locks' de la base de datos.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
