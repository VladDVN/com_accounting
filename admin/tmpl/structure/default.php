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

?>

<form action="<?php echo Route::_('index.php?option=com_accounting'); ?>" method="post" name="adminForm" id="adminForm">

<!--
 < ? php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ? >
-->

<div class="table-responsive">
	<table class="table table-striped">
	<caption><?php echo Text::_('COM_ACCOUNTING_STRUCTURE_TABLE_CAPTION'); ?></caption>
	<thead>
	<tr>
		<td class="w-1 text-center">
			<?php echo HTMLHelper::_('grid.checkall'); ?>
		</td>
		<!--
         <th scope="col" class="w-1 text-center">
			< ? php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ? >
		</th>
        -->
        <th scope="col"><?php echo Text::_('COM_ACCOUNTING_STRUCTURE_ID'); ?></th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_STRUCTURE_DESCRIPTION', 'a.name', $listDirn, $listOrder); ?>
		</th>
		<th scope="col"><?php echo Text::_('JCATEGORY'); ?></th>
        <th scope="col"><?php echo Text::_('COM_ACCOUNTING_STRUCTURE_TABLE'); ?></th>
        <th scope="col"><?php echo Text::_('COM_ACCOUNTING_SORT_ORDER'); ?></th>
		
	</tr>
	</thead>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		$canChange        = $user->authorise('core.edit.state', 'com_accounting.catalogs.' . $item->id);
	?>
	<tr>
		<td class="text-center">
			<?php echo HTMLHelper::_('grid.id', $i, $item->id, false, 'cid', 'cb', $item->localization); ?>
		</td>
        <td><?php echo $item->id; ?></td>
		<!--
        <td class="article-status text-center">
			< ? php
				$options = [
					'task_prefix' => 'structure.',
					//'disabled' => $workflow_state || !$canChange,
					'id' => 'state-' . $item->id
				];

				echo (new PublishedButton)->render((int) $item->state, $i, $options);
			? >
		</td>
        -->
		<td><?php echo Text::_($item->localization); ?></td>
		<td><?php echo $item->catid; ?></td>
		<td><?php echo $item->table; ?></td>
        <td><?php echo $item->sort_order; ?></td>
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