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

namespace pinoox\app\com_pinoox_insurance\model;

use pinoox\model\PinooxDatabase;

class LangModel extends PinooxDatabase
{

    public static function fetch_all()
    {
        return [
            'paper' => rlang('paper'),
            'front' => rlang('front'),
            'panel' => rlang('panel'),
            'category' => rlang('category'),
            'post' => rlang('post'),
            'user' => rlang('user'),
            'comment' => rlang('comment'),
            'contact' => rlang('contact'),
            'quiz' => rlang('quiz'),
        ];
    }


}