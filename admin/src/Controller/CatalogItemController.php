<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

/**
 * Controller for a single record
 *
 * @since  1.6
 */
class CatalogItemController extends FormController
{
    protected $view_list = 'cataloglist';
    
}