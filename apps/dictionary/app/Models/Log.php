<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Log
 *
 * @property int $id
 * @property string $loggable_type
 * @property int $loggable_id
 * @property string|null $body
 * @property string $url
 * @property string $method
 * @property string $ip
 * @property string|null $agent
 * @property int|null $user_id
 * @property string|null $comment
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $loggable
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLoggableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLoggableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUserId($value)
 * @mixin \Eloquent
 */
class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 'url', 'method', 'ip', 'agent', 'user_id', 'comment'
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function generateLog($body): Log
    {
        $log = new Log();
        $log->body = $body;
        $log->url = \request()->fullUrl();
        $log->method = \request()->method();
        $log->ip = \request()->ip();
        $log->agent = \request()->header('user-agent');
        $log->user_id = auth()->check() ? auth()->user()->id : null;
        return $log;
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value): string
    {
        $date = new Carbon($value);
        return $date->format('Y-m-d H:i:s');
    }
}
