<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\View\Receiptlist;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View class for Docs Receipt list.
 *
 * @since  4.0
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The search tools form
	 *
	 * @var    Form
	 * @since  1.6
	 */
	public $filterForm;

	/**
	 * The active search filters
	 *
	 * @var    array
	 * @since  1.6
	 */
	public $activeFilters = [];

	/**
	 * Category data
	 *
	 * @var    array
	 * @since  1.6
	 */
	protected $categories = [];

	/**
	 * An array of items
	 *
	 * @var    array
	 * @since  1.6
	 */
	protected $items = [];

	/**
	 * The pagination object
	 *
	 * @var    Pagination
	 * @since  1.6
	 */
	protected $pagination;

	/**
	 * The model state
	 *
	 * @var    Registry
	 * @since  1.6
	 */
	protected $state;

	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  void
	 *
	 * @since   1.6
	 * @throws  Exception
	 */
	public function display($tpl = null): void
	{

		$this->state      = $this->get('State');
		$this->items      = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		//$app = Factory::getApplication();

		ToolbarHelper::title(Text::_('COM_ACCOUNTING_DOCUMENT_RECEIPT'));
		$toolbar = Toolbar::getInstance('toolbar');
		

		$dropdownCatalogs = $toolbar->dropdownButton('catalogs')
			->text('COM_ACCOUNTING_CATALOGS')
			->toggleSplit(false)
			->icon('fa fa-ellipsis-h')
			->buttonClass('btn btn-action');

		$childBar = $dropdownCatalogs->getChildToolbar();
		$childBar->link('COM_ACCOUNTING_CLIENTS','index.php?option=com_accounting&amp;view=cataloglist&id=5','COM_ACCOUNTING_CLIENTS');
		//$childBar->link('COM_ACCOUNTING_FIRMSCLIENTS','index.php?option=com_accounting&amp;view=cataloglist&id=1','COM_ACCOUNTING_FIRMSCLIENTS');
		$childBar->link('COM_ACCOUNTING_CLIENTS8','index.php?option=com_accounting&amp;view=cataloglist8&id=51','COM_ACCOUNTING_CLIENTS8');
		$childBar->link('COM_ACCOUNTING_CONTRACTS','index.php?option=com_accounting&amp;view=cataloglist&id=2','COM_ACCOUNTING_CONTRACTS');
		$childBar->link('COM_ACCOUNTING_GOODS','index.php?option=com_accounting&amp;view=cataloglist&id=3','COM_ACCOUNTING_GOODS');

		$dropdownDocuments = $toolbar->dropdownButton('documents')
			->text('COM_ACCOUNTING_DOCUMENTS')
			->toggleSplit(false)
			->icon('fa fa-ellipsis-h')
			->buttonClass('btn btn-action');

		$childBar = $dropdownDocuments->getChildToolbar();
		$childBar->link('COM_ACCOUNTING_DOCUMENT_RECEIPT','index.php?option=com_accounting&amp;view=receiptlist&catid=51','COM_ACCOUNTING_DOCUMENT_RECEIPT');
		$childBar->link('COM_ACCOUNTING_DOCUMENT_PURCHASE_INVOICE','index.php?option=com_accounting&amp;view=docpurchaseinvoicelist&id=51','COM_ACCOUNTING_DOCUMENT_PURCHASE_INVOICE');

		$dropdownReports = $toolbar->dropdownButton('reports')
			->text('COM_ACCOUNTING_REPORTS')
			->toggleSplit(false)
			->icon('fa fa-ellipsis-h')
			->buttonClass('btn btn-action');

		$childBar = $dropdownReports->getChildToolbar();
		$childBar->link('COM_ACCOUNTING_REPORT_TURNOVER_BALANCE_SHEET','index.php?option=com_accounting&amp;view=cataloglist&id=1','COM_ACCOUNTING_REPORT_TURNOVER_BALANCE_SHEET');
	}	
	 	
}

