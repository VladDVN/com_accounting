<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Services;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;

class Category extends Categories
{
  public function __construct($options)
  {
    $options = array_merge($options,
	  [
      'extension'  => 'com_accounting',
      'table'      => 'acc_catalogs',
      'field'      => 'catid',
      'key'        => 'id',
      'statefield' => 'state',
      ],
	  [
		'extension'  => 'com_accounting',
		'table'      => 'acc_clients',
		'field'      => 'catid',
		'key'        => 'id',
		'statefield' => 'state',
		]
	);

    parent::__construct($options);
  }

}