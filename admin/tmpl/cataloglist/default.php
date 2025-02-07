<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (c) 2023 VladDVN
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
		<th scope="col"><?php echo Text::_('COM_ACCOUNTING_CODE'); ?></th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_NAME', 'a.name', $listDirn, $listOrder); ?>
		</th>
		<th scope="col"><?php echo Text::_('Категорія'); ?>
	</th>
		
	</tr>
	</thead>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		$canChange        = $user->authorise('core.edit.state', 'com_accounting.cataloglist.' . $item->id);
	if ($item->ismark) {;
	?>
	<tr class="text-decoration-line-through">
	<?php } else {; ?>
	<tr>
	<?php }; ?>
		<td class="text-center">
			<?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->id); ?>
		</td>
        <td ><?php echo $item->code; ?></td>
		
			<td>
				<a href="<?php echo Route::_('index.php?option=com_accounting&task=catalogitem.edit&id=' . $item->id . '&form=' . $itemForm . '&table=' . $itemTable . '&catid=' . $item->catid ); ?>"
					title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->name); ?>">
					<?php echo Text::_($item->name); ?></a>
			</td>
		<td><?php echo $item->catid; ?></td>
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