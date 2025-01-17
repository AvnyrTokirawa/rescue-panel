<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class Facture
 * @package App\Models
 * @property int id
 * @property int patient_id
 * @property int rapport_id
 * @property boolean payed
 * @property int price
 * @property int payement_confirm_id
 * @property int discord_msg_id
 * @method static where(string $column, string $operator = null, mixed $value = null)
 * @method static orderByDesc(string $string)
 *
 */
class Facture extends Model
{

    use Searchable;

    use HasFactory;
    protected $table = "Factures";
    protected $casts = [
        'payed'=>'boolean',
        'created_at'=>'datetime:d/m/Y H:i'
    ];

    protected $fillable = ['patient_id', 'rapport_id', 'payed', 'price', 'payement_confirm_id', 'service','discord_msg_id'];

    public function GetConfirmUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'payement_confirm_id');
    }
    public function GetPatient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function GetRapport(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Rapport::class, 'rapport_id');
    }

    public function getScoutKey()
    {
        return $this->id;
    }

    public function getScoutKeyName()
    {
        return 'id';
    }

    public function toSearchableArray()
    {
        if(!$this->payed){
            return [
                'id'=>$this->id,
                'patient'=>$this->GetPatient->name,
                'price'=>$this->price,
                'created_at'=>$this->created_at
            ];
        }else{
            return [];
        }
    }
}
