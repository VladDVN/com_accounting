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

use Joomla\CMS\Date\Date;
use Joomla\CMS\Document\FactoryInterface;
use Joomla\CMS\Event\AbstractEvent;
use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\MVC\Model\WorkflowBehaviorTrait;
use Joomla\CMS\MVC\Model\WorkflowModelInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\String\PunycodeHelper;
use Joomla\CMS\Table\TableInterface;
use Joomla\CMS\Tag\TaggableTableInterface;
use Joomla\CMS\UCM\UCMType;
use Joomla\CMS\Versioning\VersionableModelTrait;
use Joomla\CMS\Workflow\Workflow;
use Joomla\Component\Categories\Administrator\Helper\CategoriesHelper;
use Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
use Joomla\Database\ParameterType;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Accountingroot\Component\Accounting\Administrator\Field;

include JPATH_ADMINISTRATOR . "/components/com_accounting/field/clientfield.php";

/**
 * Item Model.
 * 
 * @since  1.6
 */
class ReceiptItemModel extends AdminModel
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_ACCOUNTING_DOCUMENT_RECEIPT';
    
	
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  Form|boolean  A Form object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_accounting.receipt_details', 'receipt_details', array('control' => 'jform', 'load_data' => $loadData));
        
		if (empty($form))
		{
			return false;
		}
                
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app = Factory::getApplication();
		$data = $app->getUserState('com_accounting.edit.receiptitem.data', array());

		if (empty($data))
		{
			$data = $this->getItemModified();

		}

		return $data;
	}

	 /**
     * Proxy Method to get a table object, load it if necessary.
     *
     * @param   string  $name     The table name. Optional.
     * @param   string  $prefix   The class prefix. Optional.
     * @param   array   $options  Configuration array for model. Optional.
     *
     * @return  Table  A Table object
     *
     * @since   3.0
     * @throws  \Exception
     */
    public function getTable($name = 'Receipt_main', $prefix = '', $options = [])
    {
        $table = parent::_createTable($name, $prefix, $options);            
        
        return $table;
        

        
    }
	
	/**
     * Proxy Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  CMSObject|boolean  Object on success, false on failure.
     *
     * @since   1.6
     */
    public function getItemModified($pk = null)
    {
        $pk    = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
        
        $db    = $this->getDatabase();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(array(
                $db->quoteName('a.id', 'id'),
                $db->quoteName('a.date', 'date'),
                $db->quoteName('a.code', 'code'),
                $db->quoteName('a.contract', 'contract'),
                $db->quoteName('a.amount', 'amount'),
                $db->quoteName('a.currency', 'currency'),
                $db->quoteName('a.comment', 'comment'),
                $db->quoteName('b.name','ownfirm_name'),
                $db->quoteName('b.id','ownfirm'),
                $db->quoteName('d.name','client_name'),
                $db->quoteName('d.id','client'),
                $db->quoteName('c.username','username'),
                $db->quoteName('c.id','user')
                ))
                ->from($db->quoteName('#__acc_receipt', 'a'))
                ->where('a.id' . ' = :objectId')
				->bind(':objectId', $pk, ParameterType::INTEGER)
		
		        ->join('LEFT', $db->quoteName('#__acc_firms', 'b'), $db->quoteName('a.ownfirm') . ' = ' . $db->quoteName('b.id'))
		        ->join('LEFT', $db->quoteName('#__users', 'c'), $db->quoteName('a.author') . ' = ' . $db->quoteName('c.id'))
		        ->join('LEFT', $db->quoteName('#__acc_clients', 'd'), $db->quoteName('a.client') . ' = ' . $db->quoteName('d.id'));
        
        $db->setQuery($query);

        $table = $db->loadAssoc();
        
        $item = ArrayHelper::toObject($table, CMSObject::class);

        if (property_exists($item, 'params')) {
            $registry     = new Registry($item->params);
            $item->params = $registry->toArray();
        }

        return $item;
    }

    /**
     * Proxy Method to get a single record.
     *
     * @param   integer  $pk  The id of the primary key.
     *
     * @return  CMSObject|boolean  Object on success, false on failure.
     *
     * @since   1.6
     */
    public function getItem($pk = null)
    {
        $pk    = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
        $table = $this->getTable('Receipt_main');
		
        if ($pk > 0) {
            // Attempt to load the row.
            $return = $table->load($pk);
        
            // Check for a table object error.
            if ($return === false) {
                // If there was no underlying error, then the false means there simply was not a row in the db for this $pk.
                if (!$table->getError()) {
                    $this->setError(Text::_('JLIB_APPLICATION_ERROR_NOT_EXIST'));
                } else {
                    $this->setError($table->getError());
                }

                return false;
            }
        }

        // Convert to the CMSObject before adding other data.
        $properties = $table->getProperties(1);
        $item       = ArrayHelper::toObject($properties, CMSObject::class);

        if (property_exists($item, 'params')) {
            $registry     = new Registry($item->params);
            $item->params = $registry->toArray();
        }

        return $item;
    }
}