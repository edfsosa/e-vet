<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones. Esta función es responsable de crear las tablas
     * necesarias en la base de datos para la aplicación.
     */
    public function up(): void
    {
        // Crea la tabla 'users' para almacenar la información de los usuarios (veterinarios).
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Columna autoincremental que sirve como clave primaria.
            $table->string('name'); // Nombre del usuario.
            $table->string('email')->unique(); // Correo electrónico único del usuario.
            $table->timestamp('email_verified_at')->nullable(); // Marca de tiempo de verificación del correo.
            $table->string('password'); // Contraseña del usuario (hash).
            $table->rememberToken(); // Token para la funcionalidad "Recordarme".
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' para registrar la creación y modificación del registro.
        });

        // Crea la tabla 'password_reset_tokens' para almacenar tokens de restablecimiento de contraseña.
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Correo electrónico (clave primaria).
            $table->string('token'); // Token de restablecimiento
            $table->timestamp('created_at')->nullable(); // Marca de tiempo de creación del token
        });

        // Crea la tabla 'sessions' para almacenar sesiones de usuario.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión (clave primaria).
            $table->foreignId('user_id')->nullable()->index(); // ID del usuario asociado a la sesión (nullable para sesiones de invitados).
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario.
            $table->text('user_agent')->nullable(); // Información del navegador/dispositivo.
            $table->longText('payload'); // Datos de la sesión.
            $table->integer('last_activity')->index(); // Marca de tiempo de la última actividad.
        });
    }

    /**
     * Revierte las migraciones. Esta función es responsable de eliminar las tablas
     * que fueron creadas en la función 'up'.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
