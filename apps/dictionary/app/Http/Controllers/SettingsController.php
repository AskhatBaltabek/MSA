<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    /**
     * @param Request $request
     * @param string $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateByKey(Request $request, string $key)
    {
        $setting = (new Setting)->findBy('key', $key);
        $setting->update(['setting->value' => $request->value]);

        return $this->sendResponse($setting->key . ': Успешено изменен!', $setting);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function showByKey(string $key)
    {
        $data = (new Setting)->findBy('key', $key);
        if (is_object($data)) {
            return $this->sendResponse('Настройка успешно получена.', $data);
        } else {
            return $this->sendError('Настройка не найдена.', $data);
        }
    }

    public function getValueByKey(string $key)
    {
        return (new Setting)->findBy('key', $key)->setting;
    }
}
