<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\View\Receiptitem;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View to edit a document.
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The \JForm object
	 *
	 * @var  \JForm
	 */
	protected $form;

	/**
	 * The active item
	 *
	 * @var  object
	 */
	protected $item;
	protected $rows = [];

	/**
	 * The model state
	 *
	 * @var  object
	 */
	protected $state;

	/**
	 * The actions the user is authorised to perform
	 *
	 * @var  \JObject
	 */
	protected $canDo;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 *
	 * @throws \Exception
	 * @since   1.6
	 */
	public function display($tpl = null)
	{
		$model   = $this->getModel('ReceiptItem');
		$rowsmodel = $this->getModel('ReceiptItemRows');
		
		//$item = $model->getItem();
		$item = $model->getItemModified();
		$rows = $rowsmodel->getRows($item->id);
		
		$this->item  = $item;
		$this->rows  = $rows;
		$this->state = $this->get('State');
		$form = $this->getForm();
		
        if ($form) {
			$this->form = $form;
        }

		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		return parent::display($tpl);
	}

	/**
     * Method to bind data to the form.
     *
     * @param   mixed  $data  An array or object of data to bind to the form.
     *
     * @return  boolean  True on success.
     *
     * @since   1.7.0
     */
    public function bind($group, $data)
    {
        // Make sure there is a valid Form XML document.
        if (!($this->xml instanceof \SimpleXMLElement)) {
            throw new \UnexpectedValueException(sprintf('%s::%s `xml` is not an instance of SimpleXMLElement', \get_class($this), __METHOD__));
        }

        // The data must be an object or array.
        if (!\is_object($data) && !\is_array($data)) {
            return false;
        }

        $this->bindLevel($group, $data);

        return true;
    }

    /**
     * Method to bind data to the form for the group level.
     *
     * @param   string  $group  The dot-separated form group path on which to bind the data.
     * @param   mixed   $data   An array or object of data to bind to the form for the group level.
     *
     * @return  void
     *
     * @since   1.7.0
     */
    protected function bindLevel($group, $data)
    {
        // Ensure the input data is an array.
        if (\is_object($data)) {
            if ($data instanceof Registry) {
                // Handle a Registry.
                $data = $data->toArray();
            } elseif ($data instanceof CMSObject) {
                // Handle a CMSObject.
                $data = $data->getProperties();
            } else {
                // Handle other types of objects.
                $data = (array) $data;
            }
        }

        // Process the input data.
        foreach ($data as $k => $v) {
            $level = $group ? $group . '.' . $k : $k;

            if ($this->form->findField($k, $group)) {
                // If the field exists set the value.
                $this->form->data->set($level, $v);
            } elseif (\is_object($v) || ArrayHelper::isAssociative($v)) {
                // If the value is an object or an associative array, hand it off to the recursive bind level method.
                $this->bindLevel($level, $v);
            }
        }
    }

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @throws \Exception
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);
		$isNew      = ($this->item->id == 0);

		$canDo = ContentHelper::getActions('com_accounting');

		$toolbar = Toolbar::getInstance();

		ToolbarHelper::title(
			//Text::_('COM_ACCOUNTING_CATALOG_ITEM_TITLE' . ($isNew ? 'ADD' : 'EDIT'))
			//Text::_('Редагувати:')
			Text::_('Надходження товарів та послуг:')
		);

		if ($canDo->get('core.create'))
		{
			if ($isNew)
			{
				$toolbar->apply('item.save');
			}
			else
			{
				$toolbar->apply('item.apply');
			}
			$toolbar->save('item.save');

		}
		$toolbar->cancel('item.cancel', 'JTOOLBAR_CLOSE');

		ToolbarHelper::inlinehelp();
	}
}
