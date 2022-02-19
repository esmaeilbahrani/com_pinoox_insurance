<?php
/**
 *      ****  *  *     *  ****  ****  *    *
 *      *  *  *  * *   *  *  *  *  *   *  *
 *      ****  *  *  *  *  *  *  *  *    *
 *      *     *  *   * *  *  *  *  *   *  *
 *      *     *  *    **  ****  ****  *    *
 * @author   Pinoox
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace pinoox\app\com_pinoox_insurance\model;

use pinoox\model\PinooxDatabase;

class AppDatabase extends PinooxDatabase
{

    const prefix = 'com_pinoox_insurance_';

    //tables
    const settings = self::prefix . 'settings';
    const tag = self::prefix . 'tag';
    const category = self::prefix . 'category';
    const group = self::prefix . 'group';
    const menu = self::prefix . 'menu';
    const user_app = self::prefix . 'user';
    const statistic = self::prefix . 'statistic';


}
