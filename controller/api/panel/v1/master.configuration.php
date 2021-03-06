<?php
/**
 *      ****  *  *     *  ****  ****  *    *
 *      *  *  *  * *   *  *  *  *  *   *  *
 *      ****  *  *  *  *  *  *  *  *    *
 *      *     *  *   * *  *  *  *  *   *  *
 *      *     *  *    **  ****  ****  *    *
 * @author   Pinoox
 * @link https://www.pinoox.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace pinoox\app\com_pinoox_insurance\controller\api\panel\v1;

use pinoox\app\com_pinoox_insurance\component\Permission;
use pinoox\app\com_pinoox_insurance\controller\api\ApiConfiguration;
use pinoox\component\HelperString;
use pinoox\component\Response;
use pinoox\component\Router;
use pinoox\component\User;

class MasterConfiguration extends ApiConfiguration
{

    const api_v1 = 'api/panel/v1/';

    protected static $user_id;
    protected $isCheckAccess = true;
    private $allowsUrls = [
        self::api_v1 . 'account',
    ];

    public function __construct()
    {
        parent::__construct();
        self::$user_id = User::get('user_id');
        $this->checkAccess();
    }

    private function checkAccess()
    {
        if (!$this->isCheckAccess) return;

        $url = Router::selfUrl();

        if ($this->checkFirstUrls($url)) return;

        if (!User::isLoggedIn() || !Permission::api('panel'))
            Response::json(['message' => 'NEED_LOGIN', 'statusCode' => 403], false);

        if (!Permission::api($url))
            $this->error();
    }

    private function checkFirstUrls($url)
    {
        $url = str_replace(['\\', ':', '@', '>'], '/', $url) . '/';
        if (!empty($this->allowsUrls)) {
            foreach ($this->allowsUrls as $_url) {
                $_url = str_replace(['\\', ':', '@', '>'], '/', $_url) . '/';

                if (HelperString::firstHas($url, $_url)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function error()
    {
        Response::json('not found', 404);
    }

    public function errorAccess()
    {
        Response::json(['message' => 'Forbidden', 'statusCode' => 403], false);
    }
}
    
