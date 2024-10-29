<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Estos campos se pueden rellenar directamente al crear o actualizar una mascota.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Nombre de la mascota
        'species', // Especie de la mascota
        'breed', // Raza de la mascota
        'gender', // Género de la mascota
        'birthdate', // Fecha de nacimiento de la mascota
        'size', // Tamaño de la mascota
        'weight', // Peso de la mascota
        'fur', // Tipo de pelaje de la mascota
        'reproduction', // Estado reproductivo de la mascota
        'active', // Indica si la mascota está activa o no
        'image', // Ruta de la imagen de la mascota
        'owner_id', // ID del dueño de la mascota
        'user_id', // ID del veterinario que registró la mascota
    ];

    /**
     * Una mascota pertenece a un dueño.
     * Esta relación define que cada mascota está asociada con un dueño específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Una mascota pertenece a un usuario (veterinario).
     * Esta relación define que cada mascota está asociada con un veterinario específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Una mascota tiene muchas vacunaciones.
     * Esta relación define que una mascota puede tener múltiples registros de vacunación asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class);
    }

    /**
     * Una mascota tiene muchas consultas.
     * Esta relación define que una mascota puede tener múltiples consultas médicas asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    /**
     * Una mascota tiene muchas cirugías.
     * Esta relación define que una mascota puede tener múltiples cirugías asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function surgeries(): HasMany
    {
        return $this->hasMany(Surgery::class);

/**
     * Una mascota tiene muchos exámenes.
     * Esta relación define que una mascota puede tener múltiples exámenes de laboratorio asociados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
