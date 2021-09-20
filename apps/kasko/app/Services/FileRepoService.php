<?php


namespace App\Services;

use App\Traits\ApiClient;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * @method postUrl(string $string, array $params)
 */
class FileRepoService
{
    use ApiClient;

    public $baseUri;
    public array $headers;
    public $secret;
    const GRANT_TYPE = 'password';
    const CLIENT_ID = 5;
    const CLIENT_SECRET = '251e42b4114537dcf29522444f79ead7';


    /**
     * Create instance new object.
     *
     */
    public function __construct()
    {
        $this->baseUri = env('FILEREPO_HOST_REST_URL');
        $this->headers = ['Content-Type' => 'application/json'];
        $this->secret  = $this->auth();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function auth()
    {
        if(!Cache::has('filerepo_token'))
        {
            $params = [
                'grant_type' => self::GRANT_TYPE,
                'username' => env('FILEREPO_LOGIN'),
                'password' => env('FILEREPO_PASSWORD'),
                'client_id' => self::CLIENT_ID,
                'client_secret' => self::CLIENT_SECRET,
            ];

            $res = $this->post('api/v1/oauth/token', ['body' => json_encode($params)]);
            if(!$res) return $res;

            Cache::put('filerepo_token', $res['access_token'], $seconds = 3600);
        }

        return Cache::get('filerepo_token');
    }


    public function saveFile($fileName, $file)
    {
        $params = [
            'multipart' => [
                [
                    'name'     => 'name',
                    'contents' => $fileName,
                ],
                [
                    'name'     => 'tags[]',
                    'contents' => $fileName,
                ],
                [
                    'name'     => 'file',
                    'contents' => $file,
                    'filename' => $fileName . '.pdf'
                ]
            ],
            'headers'   => [
                'Authorization' => 'Bearer ' . Cache::get('filerepo_token')
            ]
        ];
        return $this->request('POST', 'api/v1/document/', $params, true);
    }

}
