<?php

namespace App\Models;

use App\Helpers\TextHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static create(array $all)
 */
class NotificationTemplate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * @param $code
     * @param $values
     * @return array
     * @throws \Exception
     */
    public static function generateMessage($code, $values): array
    {
        $response['success'] = false;
        $template            = self::where('code', $code)->first();

        if (!$template) {
            $response['message'] = 'Шаблон письма не найден!';
            return $response;
        }

        $template_body           = TextHelper::bladeCompile($template->body_ru, $values);
        $response['success']     = true;
        $response['title']       = TextHelper::bladeCompile($template->theme_ru, $values);
        $response['message']     = $template_body;
        $response['template_id'] = $template->id;
        return $response;
    }
}
