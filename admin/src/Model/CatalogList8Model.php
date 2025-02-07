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
use Joomla\Database\ParameterType;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\DatabaseFactory;
use Joomla\Event\DispatcherInterface;
use Joomla\CMS\Pagination\Pagination;

/**
 * Methods to handle a list of records.
 * 
 * @since  1.6
 */
class CatalogList8Model extends ListModel
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
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'code', 'a._Code',
				'name', 'a._Description',
				'fullname', 'a._Fld383',
				'ismark', 'a._Marked',

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
	 * Get the name of table.
	 *
	 * @return  string Name of table.
	 *
	 * @since   1.6
	 */

	protected function getTableName()
	{
		$objectId = $_GET['id'];

		if ($objectId) {
			$db    = $this->getDatabase();
			$query = $db->getQuery(true)
				->select($db->quoteName('table'))
				->from($db->quoteName('#__acc_schema'))
				->where($db->quoteName('code') . ' = :objectId')
				->bind(':objectId', $objectId, ParameterType::INTEGER);
			$db->setQuery($query);

			try {
				$name = $db->loadResult();
			} catch (\RuntimeException $e) {
				$this->setError($e->getMessage());

				return false;
			}

			return $name;
		}

		return Text::_('COM_ACCOUNTING_NOOBJECT');
	}

	/**
     * Method to get an array of data items.
     *
     * @return  mixed  An array of data items on success, false on failure.
     *
     * @since   1.6
	 * _getList
     */
	public function getItems()
	{
		//$tableName = $this->getTableName();

		$options = [
			'driver'   => 'sqlsrv',
			'host'     => 'FUJITSU\\FJ',
			'user'     => 'sa',
			'password' => '123',
			'database' => 'BUH',
			'select'   => 'true'
			//'prefix'   => 'dbo._'
		];

		
		try {
			$db = DatabaseDriver::getInstance($options);
			//$db = new DatabaseFactory();
			//$db->getDriver('sqlsrv', $options);
			
			$db->setDispatcher($this->getDispatcher());

		} catch (\RuntimeException $e) {
			if (!headers_sent()) {
				header('HTTP/1.1 500 Internal Server Error');
			}

			jexit('Database Error: ' . $e->getMessage());
		}

		$query = $db->getQuery(true);

		
		// Select the required fields from the table.
		  $query->select(
		  		$this->getState(
		  				'list.select',
		  				[
		  						$db->quoteName('a._Code', 'code'),
		 						$db->quoteName('a._Description', 'name'),
		  						$db->quoteName('a._Fld383', 'fullname'),
		 						$db->quoteName('a._Marked', 'ismark')
		 						


		  				]
		  				)
		  		)
		 		 ->from($db->quoteName('_Reference19', 'a'));

		// Filter by search in name.
		 $search = $this->getState('filter.search');

		 if (!empty($search)) {
		 	$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
		 	$query->where('(a.name LIKE ' . $search . ')');
		 }
 
		// Add the list ordering clause.
	 	 $orderCol  = $this->state->get('list.ordering', 'a._Code');
	 	 $orderDirn = $this->state->get('list.direction', 'ASC');

	 	 $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		
		$db->setQuery($query);
		$results = $db->loadObjectList();

		$store = $this->getStoreId('getTotal');
		// Try to load the data from internal storage.
		try {
			// Load the list items and add the items to the internal cache.
			$this->cache[$store] = $db->getCount();
		} catch (\RuntimeException $e) {
			$this->setError($e->getMessage());

			return false;
		}
		
		// Get a storage key.
		$store = $this->getStoreId();

		// Try to load the data from internal storage.
		if (isset($this->cache[$store])) {
			return $this->cache[$store];
		}

		try {
			// Load the list items and add the items to the internal cache.
			$this->cache[$store] = $results;
		} catch (\RuntimeException $e) {
			$this->setError($e->getMessage());

			return false;
		}

		return $this->cache[$store];
	
	}

	/**
     * Method to get a \JPagination object for the data set.
     *
     * @return  Pagination  A Pagination object for the data set.
     *
     * @since   1.6
     */
    public function getPagination()
    {
        // Get a storage key.
        $store = $this->getStoreId('getPagination');

        // Try to load the data from internal storage.
        if (isset($this->cache[$store])) {
            return $this->cache[$store];
        }

        $limit = (int) $this->getState('list.limit') - (int) $this->getState('list.links');

        // Create the pagination object and add the object to the internal cache.
        $this->cache[$store] = new Pagination($this->getTotal(), $this->getStart(), $limit);

        return $this->cache[$store];
    }

	/**
     * Method to get the total number of items for the data set.
     *
     * @return  integer  The total number of items available in the data set.
     *
     * @since   1.6
     */
    public function getTotal()
    {
        // Get a storage key.
        $store = $this->getStoreId('getTotal');

        // Try to load the data from internal storage.
        if (isset($this->cache[$store])) {
            return $this->cache[$store];
        }

        try {
            // Load the total and add the total to the internal cache.
            $this->cache[$store] = (int) $this->_getListCount($this->_getListQuery());
        } catch (\RuntimeException $e) {
            $this->setError($e->getMessage());

            return false;
        }

        return $this->cache[$store];
    }

	

}
