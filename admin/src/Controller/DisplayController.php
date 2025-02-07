<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\ControllerInterface;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Factory;
use Joomla\Event\DispatcherAwareInterface;
use Joomla\Event\DispatcherAwareTrait;

use Joomla\CMS\Application\CMSApplication;

/**
 * Component Controller
 *
 * @since  4.0.0
 */
class DisplayController extends BaseController implements ControllerInterface, DispatcherAwareInterface
{
    use DispatcherAwareTrait;

    /**
    * The default view.
    *
    * @var    string
    * @since  1.6
    */
   protected $default_view = 'accounting';

   /**
     * Method to get a reference to the current view and load it if necessary.
     *
     * @param   string  $name    The view name. Optional, defaults to the controller name.
     * @param   string  $type    The view type. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for view. Optional.
     *
     * @return  \Joomla\CMS\MVC\View\ViewInterface  Reference to the view or an error.
     *
     * @since   3.0
     * @throws  \Exception
     */
    public function getView($name = '', $type = '', $prefix = '', $config = [])
    {
        // Force to load the admin view
        return parent::getView($name, $type, 'Administrator', $config);
    }

    /**
     * Typical view method for MVC based architecture
     *
     * This function is provide as a default implementation, in most cases
     * you will need to override it in your own controllers.
     *
     * @param   boolean  $cachable   If true, the view output will be cached
     * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link InputFilter::clean()}.
     *
     * @return  static  A \JControllerLegacy object to support chaining.
     *
     * @since   3.0
     * @throws  \Exception
     */
    public function display($cachable = false, $urlparams = [])
    {
        $document   = $this->app->getDocument();
        $viewType   = $document->getType();
        $viewName   = $this->input->get('view', $this->default_view);
        $viewLayout = $this->input->get('layout', 'default', 'string');

        $view = $this->getView($viewName, $viewType, '', ['base_path' => $this->basePath, 'layout' => $viewLayout]);

        // Get/Create the model
        if ($model = $this->getModel($viewName, '', ['base_path' => $this->basePath])) {
            // Push the model into the view (as default)
            $view->setModel($model, true);

            if ($viewName == 'receiptitem') {
                $rowsmodel = $this->getModel('ReceiptItemRows', 'administrator');
                $view->setModel($rowsmodel);
            }
        }

        if ($view instanceof DocumentAwareInterface && $document) {
            $view->setDocument($this->app->getDocument());
        } else {
            @trigger_error(
                'View should implement document aware interface.',
                E_USER_DEPRECATED
            );
            $view->document = $document;
        }

        // Display the view
        if ($cachable && $viewType !== 'feed' && $this->app->get('caching') >= 1) {
            $option = $this->input->get('option');

            if (\is_array($urlparams)) {
                if (!empty($this->app->registeredurlparams)) {
                    $registeredurlparams = $this->app->registeredurlparams;
                } else {
                    $registeredurlparams = new \stdClass();
                }

                foreach ($urlparams as $key => $value) {
                    // Add your safe URL parameters with variable type as value {@see InputFilter::clean()}.
                    $registeredurlparams->$key = $value;
                }

                $this->app->registeredurlparams = $registeredurlparams;
            }

            try {
                /** @var \Joomla\CMS\Cache\Controller\ViewController $cache */
                $cache = Factory::getCache($option, 'view');
                $cache->get($view, 'display');
            } catch (CacheExceptionInterface $exception) {
                $view->display();
            }
        } else {
            $view->display();
        }

        return $this;
    }
   
}