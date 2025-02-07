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

<?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

<div class="table-responsive">
	<table class="table strike-able">
	<caption><?php echo Text::_('COM_ACCOUNTING_CAPTION'); ?></caption>
	<thead>
	<tr>
		<td class="w-1 text-center">
			<?php echo HTMLHelper::_('grid.checkall'); ?>
		</td>
		<th scope="col"><?php echo Text::_('COM_ACCOUNTING_CODE'); ?></th>
		<th scope="col">
			<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_NAME', 'name', $listDirn, $listOrder); ?>
		</th>
		<th scope="col">
			<?php echo Text::_('COM_ACCOUNTING_FULLNAME'); ?>
		</th>
		
	</tr>
	</thead>
	<tbody>
	<?php foreach ($this->items as $i => $item) :
		$canChange        = $user->authorise('core.edit.state', 'com_accounting.cataloglist8.' . $item->code);
	?>
	<tr>
		<td class="text-center">
			<?php echo HTMLHelper::_('grid.id', $i, $item->code, false, 'cid', 'cb', $item->code); ?>
		</td>
        <td ><?php echo $item->code; ?></td>
		
		<?php if ((int)$item->ismark) {; ?>
		<td>
			<strike>
			<a href="<?php echo Route::_('index.php?option=com_accounting&task=catalogitem.edit&id=' . $item->id); ?>"
			title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->localization); ?>">
			<?php echo Text::_($item->name); ?></a>
			</strike>
		</td>
		<td >
			<strike>
				<?php echo $item->fullname; ?>
			</strike>
		</td>
		
		<?php } else {; ?>
			<td>
				<a href="<?php echo Route::_('index.php?option=com_accounting&task=catalogitem.edit&id=' . $item->code); ?>"
					title="<?php echo Text::_('JACTION_EDIT'); ?> <?php echo $this->escape($item->localization); ?>">
					<?php echo Text::_($item->name); ?></a>
			</td>
			<td >
				<?php echo $item->fullname; ?>
			</td>
		<?php }; ?>
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