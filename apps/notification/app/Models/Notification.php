<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find($id)
 * @method static findOrFail($id)
 * @property NotificationTemplate template
 * @property mixed attachments
 * @property mixed theme
 * @property mixed send_to
 * @property mixed send_from
 * @property mixed|string error
 * @property int|mixed status
 */
class Notification extends Model
{
    use HasFactory;

    const STATUS_SENT = 1;
    const STATUS_ERROR = 2;

    protected $guarded = ['id'];

    protected $casts = [
        'attachments' => 'array'
    ];

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }
}
