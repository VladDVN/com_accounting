<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Controller;

\defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Router\Route;


/**
 * Controller for a single record
 *
 * @since  1.6
 */
class ReceiptItemController extends FormController
{
    protected $view_list = 'receiptlist';
    protected $view_item = 'receiptitem';

	/**
     * Proxy Method to edit an existing record.
     *
     * @param   string  $key     The name of the primary key of the URL variable.
     * @param   string  $urlVar  The name of the URL variable if different from the primary key
     *                           (sometimes required to avoid router collisions).
     *
     * @return  boolean  True if access level check and checkout passes, false otherwise.
     *
     * @since   1.6
     */
    public function edit($key = null, $urlVar = null)
    {
        // Do not cache the response to this, its a redirect, and mod_expires and google chrome browser bugs cache it forever!
        $this->app->allowCache(false);
        // Get the document object.
        $document = $this->app->getDocument();
        $vFormat = $document->getType();

        $model   = $this->getModel('ReceiptItem', 'administrator');
        $rows    = $this->getModel('ReceiptItemRows', 'administrator');
        $table   = $model->getTable('Receipt_main');
        
		$cid     = (array) $this->input->post->get('cid', [], 'int');
        $context = "$this->option.edit.$this->context";

        $view = $this->getView('receiptitem', $vFormat, 'administrator'); 
        $view->setModel($model, true);
        $view->setModel($rows);

        // Determine the name of the primary key for the data.
        if (empty($key)) {
            $key = $table->getKeyName();
        }

        // To avoid data collisions the urlVar may be different from the primary key.
        if (empty($urlVar)) {
            $urlVar = $key;
        }

        // Get the previous record id (if any) and the current record id.
        $recordId = (int) (\count($cid) ? $cid[0] : $this->input->getInt($urlVar));
        $checkin  = $table->hasField('checked_out');

        // Access check.
        if (!$this->allowEdit([$key => $recordId], $key)) {
            $this->setMessage(Text::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'), 'error');

            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_list
                        . $this->getRedirectToListAppend(),
                    false
                )
            );

            return false;
        }

        // Attempt to check-out the new record for editing and redirect.
        if ($checkin && !$model->checkout($recordId)) {
            // Check-out failed, display a notice but allow the user to see the record.
            $this->setMessage(Text::sprintf('JLIB_APPLICATION_ERROR_CHECKOUT_FAILED', $model->getError()), 'error');

            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend($recordId, $urlVar),
                    false
                )
            );

            return false;
        } else {
            // Check-out succeeded, push the new record id into the session.
            $this->holdEditId($context, $recordId);
            $this->app->setUserState($context . '.data', null);

            $this->setRedirect(
                Route::_(
                    'index.php?option=' . $this->option . '&view=' . $this->view_item
                        . $this->getRedirectToItemAppend($recordId, $urlVar),
                    false
                )
            );

            return true;
        }
    }


}