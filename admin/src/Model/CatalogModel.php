<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\Model\ListModelInterface;
use Joomla\Database\ParameterType;

/**
 * Methods to handle a list of records.
 * 
 * @since  1.6
 */
class CatalogModel extends ListModel 
{
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
        if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
					'id', 'a.id',
					'name', 'a.name',
					'category', 'a.catid',
					'localization', 'a.localization',
					'table', 'a.table',
					'table', 'a.table',
					'form_name', 'a.form_name',
					'struct_table', 'a.struct_table',
					'owner_table', 'a.owner_table',
					'sort_order', 'a.sort_order',
					
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
	protected function populateState($ordering = 'sort_order', $direction = 'ASC')
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
	 * Get the master query for retrieving a list of countries subject to the model state.
	 *
	 * @return  \Joomla\Database\DatabaseQuery
	 *
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
				$this->getState(
						'list.select',
						[
								$db->quoteName('a.id'),
								$db->quoteName('a.name'),
								$db->quoteName('a.catid'),
								$db->quoteName('a.localization'),
								$db->quoteName('a.table'),
								$db->quoteName('a.rows_table'),
								$db->quoteName('a.form_name'),
								$db->quoteName('a.struct_table'),
								$db->quoteName('a.owner_table'),
								$db->quoteName('a.sort_order'),
								
						]
						)
				)
				->from($db->quoteName('#__acc_schema', 'a'));
		$query->where('(a.catid = 14)');		

		// Filter by search in name.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
			$query->where('(a.name LIKE ' . $search . ')');
		}

		

		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'a.sort_order');
		$orderDirn = $this->state->get('list.direction', 'ASC');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		return $query;
	}
      
}

