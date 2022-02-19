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

namespace pinoox\app\com_pinoox_insurance\controller;

use pinoox\component\Dir;
use pinoox\component\File;
use pinoox\component\HelperHeader;
use pinoox\component\Pagination;
use pinoox\component\Request;
use pinoox\component\Response;
use pinoox\component\Router;
use pinoox\component\Tree;
use pinoox\component\Url;
use pinoox\component\User;
use pinoox\component\Validation;

class MainController extends MasterConfiguration
{
    public function __construct()
    {
        parent::__construct();
    }

    public function _exception($page_key = null)
    {
        $this->index();
    }

    public function dist()
    {
        $url = implode('/', Router::params());
        if ($url === 'pinoox.js') {
            self::visitStatus(false);
            HelperHeader::contentType('application/javascript', 'UTF-8');
            self::$template->offView('index');
            self::$template->view('dist/pinoox.js');
        } else {
            self::error404();
        }
    }

    public function _main()
    {
        $this->index();
    }

    private function index()
    {
        self::_show('index');
    }
}
