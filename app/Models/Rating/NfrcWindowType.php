<?php
// app/Models/NfrcWindowType.php
namespace App\Models\Rating;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NfrcWindowType extends Model
{
    protected $connection = 'elitevw_ratings_nfrc'; // set this in config/database.php
    protected $table = 'nfrc_window_types';
    protected $fillable = ['slug','name'];

    public function productLines(): HasMany
    {
        return $this->hasMany(NfrcProductLine::class, 'window_type_id');
    }
}
