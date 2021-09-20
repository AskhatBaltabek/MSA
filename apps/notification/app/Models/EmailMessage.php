<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string send_from
 * @property string send_to
 * @property string $title
 * @property string $message
 * @property mixed attachments
 * @property int $status_id
 * @property string $error
 * @property Carbon|null sent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * Class EmailMessage
 * @package App\Models
 */

class EmailMessage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const STATUS_NOT_SENT         = 0;
    const STATUS_SENT             = 1;
    const STATUS_ERROR_ON_SENDING = 2;

}
