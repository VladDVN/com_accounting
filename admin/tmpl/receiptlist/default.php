<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (c) 2023-- VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Button\PublishedButton;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

$user      = Factory::getUser();
$itemForm  = $this->_models[$this->_name]->_forms[0];
$itemTable = $this->_models[$this->_name]->table;

?>

<form action="<?php echo Route::_('index.php?option=com_accounting'); ?>" method="post" name="adminForm" id="adminForm">

<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

<div class="table-responsive">
	<table class="table strike-able">
	
	<thead>
	<tr>
		<td class="w-1 text-center">
			<?php echo HTMLHelper::_('grid.checkall'); ?>
		</td>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_CODE', 'a.code', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'JDATE', 'a.date', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_CLIENTS', 'a.client', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_AMOUNT', 'a.amount', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_OWNFIRM', 'a.ownfirm', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'JAUTHOR', 'a.author', $listDirn, $listOrder); ?>
		</th>
		
	</tr>
	</thead>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		$canChange        = $user->authorise('core.edit.state', 'com_accounting.receiptlist.' . $item->id);
	?>
	<?php if ($item->ismark) {; ?>
	<tr class="text-decoration-line-through">
	<?php } else {; ?>
	<tr>	
	<?php }; ?>
		<td class="text-center">
			<?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->id); ?>
		</td>
		<td class="text-center"><?php echo Text::_($item->code); ?></td>
		<td class="text-center"><?php echo Text::_($item->date); ?></td>
		<td class="text-left">
		<a href="<?php echo Route::_('index.php?option=com_accounting&task=receiptitem.edit&id=' . $item->id . '&form=' . $itemForm . '&table=' . $itemTable ); ?>"
					title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->client); ?>">
					<?php echo Text::_($item->client); ?></a>	
		
		</td>
		<td class="text-right"><?php echo Text::_($item->amount); ?></td>
		<td class="text-left"><?php echo Text::_($item->ownfirm); ?></td>
		<td class="text-left"><?php echo Text::_($item->author); ?></td>

	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>

<?php echo $this->pagination->getListFooter(); ?>
<input type="hidden" name="task" value="">
<input type="hidden" name="boxchecked" value="0">
<?php echo HTMLHelper::_('form.token'); ?>

</form>