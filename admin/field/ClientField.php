<?php

namespace Accountingroot\Component\Accounting\Administrator\Field;

defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

class ClientField extends FormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  1.6
     */
    public $type = 'client';

    /**
     * Filtering groups
     *
     * @var   array
     * @since 3.5
     * @deprecated  4.4 will be removed in 6.0 without replacement
     */
    protected $groups = null;

    /**
     * Users to exclude from the list of users
     *
     * @var   array
     * @since 3.5
     * @deprecated  4.4 will be removed in 6.0 without replacement
     */
    protected $excluded = null;

    /**
     * Layout to render
     *
     * @var   string
     * @since 3.5
     */
    protected $layout = 'clientfield';
    
    /**
     * Method to attach a Form object to the field.
     *
     * @param   \SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
     * @param   mixed              $value    The form field value to validate.
     * @param   string             $group    The field name group control value. This acts as an array container for the field.
     *                                       For example if the field has name="foo" and the group value is set to "bar" then the
     *                                       full field name would end up being "bar[foo]".
     *
     * @return  boolean  True on success.
     *
     * @since   3.7.0
     *
     * @see     FormField::setup()
     */
    public function setup(\SimpleXMLElement $element, $value, $group = null)
    {
        $return = parent::setup($element, $value, $group);

        // If user can't access com_users the field should be readonly.
        if ($return && !$this->readonly) {
            $this->readonly = !$this->getCurrentUser()->authorise('core.manage', 'com_users');
        }

        return $return;
    }

    /**
     * Method to get the client field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.6
     */
    protected function getInput()
    {
        if (empty($this->layout)) {
            throw new \UnexpectedValueException(sprintf('%s has no layout assigned.', $this->name));
        }

        return $this->getRenderer($this->layout)->render($this->collectLayoutData());
    }

    /**
     * Get the data that is going to be passed to the layout
     *
     * @return  array
     *
     * @since   3.5
     */
    public function getLayoutData()
    {
        // Get the basic field data
        $data = parent::getLayoutData();

        // Initialize value
        $name = Text::_('COM_ACCOUNTING_FORM_SELECT_CLIENT');

        if ($this->value) {
            $name = $this->value;
        }

        return $data;
    }
}