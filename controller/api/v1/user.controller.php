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

namespace pinoox\app\com_pinoox_insurance\controller\api\v1;


use pinoox\component\Cookie;
use pinoox\component\HelperString;
use pinoox\component\Response;

class UserController extends MasterConfiguration
{

    public function get()
    {
        $user_id = Cookie::get('user_id');
        if (empty($user_id)) {
            $user_id = $this->createGuestId();
        }

        $data = $this->buildUser([
            'user_id' => $user_id,
            'guest' => true,
        ]);

        Response::json($data);
    }

    private function buildUser($pushData)
    {
        $data = [
            'access' => true,
        ];

        return array_merge($data, $pushData);
    }

    private function createGuestId()
    {
        $guest_id = HelperString::generateRandom(20);
        Cookie::set('guest_id', $guest_id);
        return $guest_id;
    }

}