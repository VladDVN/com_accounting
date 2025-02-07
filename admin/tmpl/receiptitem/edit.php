<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('behavior.keepalive');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('core')
->useScript('keepalive')
->useScript('form.validate')
->useStyle('com_accounting.accounting');
//->useScript('com_banners.admin-banner-edit');
?>

<form action="<?php echo Route::_('index.php?option=com_accounting&view=receiptitem&id=' . (int) $this->item->id); ?>"
	method="post" name="adminForm" id="receipt-form" class="form-validate">

	<?php echo LayoutHelper::render('joomla.edit.title_alias', $this); ?>

	<div>
		<?php echo HTMLHelper::_('uitab.startTabSet', 'mainTab'); ?>
		<table class="table table-borderless">
		<!-- <?php echo $this->form->renderFieldset('params'); ?> -->
		<tr>
			<td style="padding: 15px; margin: 2px;">
				<?php echo $this->form->renderField('code'); ?>
			</td>
			<td style="padding: 2px; margin-left: 20px; text-align:center;">
				<?php echo $this->form->renderField('date'); ?>
			</td>
			<td style="width: 20%; padding:2px; margin:2px;">
			</td>
		</tr>
		<tr>
			<td style="padding: 15px; margin: 2px;">
				<?php 
					$button = $this->form->renderField('ownfirm_name'); 
					$button = str_replace("Обрати","",$button); 
					$button = str_replace("Select","",$button); 
					echo $button; 
				?> 
			</td>
			<td style="padding: 2px; margin: 2px;">
			</td>
			<td style="padding: 2px; margin: 2px;">
			</td>
		</tr>
		<tr>
			<td style="padding: 15px; margin: 2px;">
				<?php 
					$button =  $this->form->renderField('client_name');
					$button = str_replace("Обрати","",$button); 
					$button = str_replace("Select","",$button); 
					echo $button; 
				?>
			</td>
			<td style="padding: 2px; margin: 2px;">
			</td>
			<td style="padding: 2px; margin: 2px;">
			</td>
		</tr>
		</table>
		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
		
		<?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php 
			echo HTMLHelper::_('uitab.addTab', 'myTab', 'details', Text::_('COM_ACCOUNTING_TAB_GOODS'));
			
		?>
		<div>
			<table class="table table-bordered mt-0">
			
			<thead>
			<tr>
				<th scope="col">
					<?php echo '№'; ?>
				</th>
				
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_GOODS', 'b.good_name', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_UNIT', 'a.unit', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_QUANTITY', 'a.quantity', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_PRICE', 'a.price', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_AMOUNT', 'a.amount', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_TAX', 'a.tax', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_AMOUNT_TAX', 'a.amountTAX', $listDirn, $listOrder); ?>
				</th>
				<th scope="col">
					<?php echo HTMLHelper::_('searchtools.sort', 'COM_ACCOUNTING_WAREHOUSE', 'a.warehouse', $listDirn, $listOrder); ?>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($this->rows as $i => $row) :
				
			?>	
			<tr scope="row">	
				<td>
					<?php echo $row->num_line; ?>
				</td>
				
				<td>
					<?php 
						$button = $this->form->renderField('good_name','',$row->good_name); 
						$button = str_replace("Обрати","",$button); 
						$button = str_replace("Select","",$button); 
						echo $button; 
					?>
					
				</td>
				<td>
					<?php 
						$button = $this->form->renderField('unit_name','',$row->unit_name); 
						$button = str_replace("Обрати","",$button); 
						$button = str_replace("Select","",$button); 
						echo $button; 
					?>
				</td>
				<td>
					<?php echo $this->form->renderField('quantity','',$row->quantity); ?>
				</td>
				<td>
					<?php echo $this->form->renderField('price','',$row->price); ?>
				</td>
				<td>
					<?php echo $this->form->renderField('amount','',$row->amount); ?>
				</td>
				<td>
					<?php 
						$button =  $this->form->renderField('tax_name','',$row->tax_name); 
						$button = str_replace("Обрати","",$button); 
						$button = str_replace("Select","",$button); 
						echo $button; 
					?>
				</td>
				<td>
					<?php echo $this->form->renderField('amountTAX','',$row->amountTAX); ?>
				</td>
				<td>
					<?php 
						$button = $this->form->renderField('warehouse_name','',$row->warehouse); 
						$button = str_replace("Обрати","",$button); 
						$button = str_replace("Select","",$button); 
						echo $button; 
					?>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
		
		<?php echo HTMLHelper::_('uitab.endTab'); ?>

		<?php echo HTMLHelper::_('uitab.endTabSet'); ?>
	</div>
	<input type="hidden" name="task" value="">
	<?php echo HTMLHelper::_('form.token'); ?>
</form>
