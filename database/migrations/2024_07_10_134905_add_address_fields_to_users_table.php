<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     * Esta función modifica la tabla existente 'users' agregando campos relacionados con la ubicación geográfica (ciudad, departamento, barrio y dirección).
     * También establece relaciones de clave foránea con las tablas correspondientes.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('cascade'); // Agrega una columna 'city_id' (clave foránea) que puede ser nula.
            $table->foreignId('department_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('cascade'); // Agrega una columna 'department_id' (clave foránea) que puede ser nula.
            $table->foreignId('neighborhood_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('cascade'); // Agrega una columna 'neighborhood_id' (clave foránea) que puede ser nula.
            $table->string('address')->nullable(); // Agrega una columna 'address' para almacenar la dirección del usuario.
        });
    }

    /**
     * Revierte las migraciones.
     * Esta función elimina las columnas y restricciones de clave foránea agregadas en la función 'up'.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']); // Elimina la restricción de clave foránea que relaciona la columna 'city_id' con la tabla 'cities'.
            $table->dropColumn('city_id'); // Elimina la columna 'city_id' de la tabla 'users'.

            $table->dropForeign(['department_id']); // Elimina la restricción de clave foránea que relaciona la columna 'department_id' con la tabla 'departments'.
            $table->dropColumn('department_id'); // Elimina la columna 'department_id' de la tabla 'users'.

            $table->dropForeign(['neighborhood_id']); // Elimina la restricción de clave foránea que relaciona la columna 'neighborhood_id' con la tabla 'neighborhoods'.
            $table->dropColumn('neighborhood_id'); // Elimina la columna 'neighborhood_id' de la tabla 'users'.

            $table->dropColumn('address'); // Elimina la columna 'address' de la tabla 'users'.
        });
    }
};
