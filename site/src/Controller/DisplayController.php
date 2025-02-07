<?php
/**
 * @package     Accounting.Site
 * @subpackage  com_accounting
 *
 * @copyright   (c) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace AccountingRoot\Component\Accounting\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

/**
 * Accounting Component Controller
 *
 * @since  4.0.0
 */
class DisplayController extends BaseController
{
	/**
	 * The default view.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $default_view = 'navigator';

	protected $app;
}