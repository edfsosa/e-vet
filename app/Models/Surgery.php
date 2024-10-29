<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surgery extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Estos campos se pueden rellenar directamente al crear o actualizar una cirugía.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date', // Fecha de la cirugía
        'type', // Tipo de cirugía realizada
        'observation', // Observaciones adicionales sobre la cirugía
        'pet_id', // ID de la mascota a la que se le realizó la cirugía
        'user_id', // ID del veterinario que realizó la cirugía
    ];


    /**
     * Una cirugía pertenece a una mascota.
     * Esta relación define que cada cirugía está asociada con una mascota específica.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Una cirugía pertenece a un usuario (veterinario).
     * Esta relación define que cada cirugía está asociada con un veterinario específico.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
