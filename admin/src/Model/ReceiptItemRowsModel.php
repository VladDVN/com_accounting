<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023-2024 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Model;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;

/**
 * Item Model.
 * 
 * @since  1.6
 */
class ReceiptItemRowsModel extends ListModel
{
	public $objectName;

	/**
	 * Constructor.
	 * 
	 * @param   array   $config An optional associative array of configuration settings.
	 * 
	 * @see \JController
	 * @since  1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.parent_id',
				'num_line', 'a.num_line',
				'warehouse', 'a.warehouse',
				'kindgood', 'a.kindgood',
				'good', 'a.good',
                'quantity', 'a.quantity',
                'unit', 'a.unit',
                'price', 'a.price',
                'amount', 'a.amount',
                'amountTAX', 'a.amountTAX',
                'tax', 'a.tax',
                'lot', 'a.lot',
				'catid', 'a.catid',
				
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * This method should only be called once per instantiation and is designed
	 * to be called on the first call to the getState() method unless the model
	 * configuration flag to ignore the request is set.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   3.0.1
	 */
	protected function populateState($ordering = 'name', $direction = 'ASC')
	{
		$app = Factory::getApplication();

		// List state information
		$value = $app->input->get('limit', $app->get('list_limit', 0), 'uint');
		$this->setState('list.limit', $value);

		$value = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $value);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . serialize($this->getState('filter.name'));
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . serialize($this->getState('filter.tag'));

		return parent::getStoreId($id);
	}

	/**
	 * Get the master query for retrieving a list of catalog to the model state.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 * @return  \Joomla\Database\DatabaseQuery
	 *
	 * @since   1.6
	 */

	public function getRows($pk = null)
	{
		$pk    = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
		// Create a new query object.
		$db    = $this->getDatabase();
		$query = $db->getQuery(true);

		
		// Select the required fields from the table.
		 $query ->select('a.*')
		 		->select(array(
					$db->quoteName('good.name','good_name'),
					$db->quoteName('good.id','good'),
					$db->quoteName('kind.title','kindgood_name'),
					$db->quoteName('kind.id','kindgood'),
					$db->quoteName('warehouse.name','warehouse_name'),
					$db->quoteName('warehouse.id','warehouse'),
					$db->quoteName('unit.name','unit_name'),
					$db->quoteName('unit.id','unit'),
					$db->quoteName('tax.name','tax_name'),
					$db->quoteName('tax.id','tax')
					)
		 		)
		 		->from($db->quoteName('#__acc_receipt_rows', 'a'))
				->where('(a.parent_id = ' . $pk . ')')
				->join('LEFT', $db->quoteName('#__acc_goods', 'good'), $db->quoteName('a.good') . ' = ' . $db->quoteName('good.id'))
				->join('LEFT', $db->quoteName('#__categories', 'kind'), $db->quoteName('a.kindgood') . ' = ' . $db->quoteName('kind.id'))
				->join('LEFT', $db->quoteName('#__acc_unitsmeasuring', 'unit'), $db->quoteName('a.unit') . ' = ' . $db->quoteName('unit.id'))
				->join('LEFT', $db->quoteName('#__acc_taxes', 'tax'), $db->quoteName('a.tax') . ' = ' . $db->quoteName('tax.id'))
				->join('LEFT', $db->quoteName('#__acc_warehouses', 'warehouse'), $db->quoteName('a.warehouse') . ' = ' . $db->quoteName('warehouse.id'));
				

		// // Filter by search in name.
		// $search = $this->getState('filter.search');

		// if (!empty($search)) {
		// 	$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
		// 	$query->where('(a.num_line LIKE ' . $search . ')');
		// }



		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.num_line');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		
		$db->setQuery($query);

        return $db->loadObjectList();

		//return $query;
	}
}
