<?php
/**
 * @package     Accounting.Administrator
 * @subpackage  com_accounting
 *
 * @copyright   (C) 2023 VladDVN
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Accountingroot\Component\Accounting\Administrator\Extension;

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Categories\CategoryServiceInterface;
use Joomla\CMS\Categories\CategoryServiceTrait;
use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Component\Router\RouterServiceTrait;
use Joomla\CMS\Extension\BootableExtensionInterface;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLRegistryAwareTrait;
use Psr\Container\ContainerInterface;
use Joomla\CMS\Tag\TagServiceInterface;
use Joomla\CMS\Tag\TagServiceTrait;


/**
 * Component class for com_accounting
 *
 * @since  4.0.0
 */
class AccountingComponent extends MVCComponent implements
	BootableExtensionInterface,
	CategoryServiceInterface,
	RouterServiceInterface,
	TagServiceInterface
{
	use RouterServiceTrait;
	use HTMLRegistryAwareTrait;
	use CategoryServiceTrait, TagServiceTrait {
        CategoryServiceTrait::getTableNameForSection insteadof TagServiceTrait;
        CategoryServiceTrait::getStateColumnForSection insteadof TagServiceTrait;
    }

	/**
	 * Booting the extension. This is the function to set up the environment of the extension like
	 * registering new class loaders, etc.
	 *
	 * If required, some initial set up can be done from services of the container, eg.
	 * registering HTML services.
	 *
	 * @param   ContainerInterface  $container  The container
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function boot(ContainerInterface $container)
	{
		//$this->getRegistry()->register('accountingadministrator', new AdministratorService);
		
		// $accounting = new AccountingComponent();
        // $accounting->setDatabase($container->get(DatabaseInterface::class));

        // $this->getRegistry()->register('accounting', $accounting);
	}

	/**
     * Returns the table for the count items functions for the given section.
     *
     * @param   ?string  $section  The section
     *
     * @return  string|null
     *
     * @since   4.0.0
     */
    protected function getTableNameForSection(string $section = null)
    {
        return 'acc_schema';
    }
}
