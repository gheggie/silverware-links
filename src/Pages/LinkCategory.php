<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Links\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-links
 */

namespace SilverWare\Links\Pages;

use SilverStripe\Forms\CheckboxField;
use SilverWare\Forms\FieldSection;
use SilverWare\Lists\ListSource;
use SilverWare\Model\Link;
use SilverWare\Tools\ViewTools;
use Page;

/**
 * An extension of the page class for a link category.
 *
 * @package SilverWare\Links\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-links
 */
class LinkCategory extends Page implements ListSource
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Link Category';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Link Categories';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A category within a link page which holds a series of links';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/links: admin/client/dist/images/icons/LinkCategory.png';
    
    /**
     * Defines the table name to use for this object.
     *
     * @var string
     * @config
     */
    private static $table_name = 'SilverWare_LinkCategory';
    
    /**
     * Defines the default child class for this object.
     *
     * @var string
     * @config
     */
    private static $default_child = Link::class;
    
    /**
     * Determines whether this object can exist at the root level.
     *
     * @var boolean
     * @config
     */
    private static $can_be_root = false;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'StartOpen' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'StartOpen' => 1,
        'ShowInMenus' => 0,
        'HideFromMainMenu' => 1
    ];
    
    /**
     * Maps field and method names to the class names of casting objects.
     *
     * @var array
     * @config
     */
    private static $casting = [
        'AttributesHTML' => 'HTMLFragment'
    ];
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = [
        Link::class
    ];
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Create Options Fields:
        
        $fields->addFieldToTab(
            'Root.Options',
            FieldSection::create(
                'CategoryOptions',
                $this->fieldLabel('CategoryOptions'),
                [
                    CheckboxField::create(
                        'StartOpen',
                        $this->fieldLabel('StartOpen')
                    )
                ]
            )
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the labels for the fields of the receiver.
     *
     * @param boolean $includerelations Include labels for relations.
     *
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        // Obtain Field Labels (from parent):
        
        $labels = parent::fieldLabels($includerelations);
        
        // Define Field Labels:
        
        $labels['StartOpen'] = _t(__CLASS__ . '.STARTOPEN', 'Start open');
        $labels['CategoryOptions'] = _t(__CLASS__ . '.CATEGORY', 'Category');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Answers an array of attributes for the template.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = [
            'class' => $this->getHTMLClass(),
            'data-start-open' => $this->dbObject('StartOpen')->NiceAsBoolean()
        ];
        
        $this->extend('updateAttributes', $attributes);
        
        return $attributes;
    }
    
    /**
     * Answers the HTML tag attributes of the object as a string.
     *
     * @return string
     */
    public function getAttributesHTML()
    {
        return ViewTools::singleton()->getAttributesHTML($this->getAttributes());
    }
    
    /**
     * Answers an array of class names for the HTML template.
     *
     * @return array
     */
    public function getClassNames()
    {
        $classes = [
            'category',
            $this->getCategoryClassName()
        ];
        
        $this->extend('updateClassNames', $classes);
        
        return $classes;
    }
    
    /**
     * Answers a class name for the category.
     *
     * @return string
     */
    public function getCategoryClassName()
    {
        return sprintf('category-%s', $this->URLSegment);
    }
    
    /**
     * Answers a string of class names for the HTML template.
     *
     * @return string
     */
    public function getHTMLClass()
    {
        return ViewTools::singleton()->array2att($this->getClassNames());
    }
    
    /**
     * Answers an string of class names for the list element.
     *
     * @return string
     */
    public function getListClass()
    {
        return implode(' ', $this->getListClassNames());
    }
    
    /**
     * Answers an array of list class names for the HTML template.
     *
     * @return array
     */
    public function getListClassNames()
    {
        $classes = ['links'];
        
        if ($this->hasListIcon()) {
            $classes[] = 'fa-ul';
        }
        
        return $classes;
    }
    
    /**
     * Answers the name of the icon defined for the list.
     *
     * @return string
     */
    public function getListIcon()
    {
        return $this->getParent()->ListIcon;
    }
    
    /**
     * Answers true if a list icon is to be shown in the template.
     *
     * @return boolean
     */
    public function hasListIcon()
    {
        return $this->getParent()->hasListIcon();
    }
    
    /**
     * Answers a list of links within the category.
     *
     * @return DataList
     */
    public function getLinks()
    {
        return $this->getParent()->sort(Link::get()->filter('ParentID', $this->ID));
    }
    
    /**
     * Answers a list of the enabled links within the receiver.
     *
     * @return ArrayList
     */
    public function getEnabledLinks()
    {
        return $this->getLinks()->filterByCallback(function ($link) {
            return $link->isEnabled();
        });
    }
    
    /**
     * Answers true if the receiver has at least one enabled link.
     *
     * @return boolean
     */
    public function hasEnabledLinks()
    {
        return $this->getEnabledLinks()->exists();
    }
    
    /**
     * Answers a list of links within the receiver.
     *
     * @return DataList
     */
    public function getListItems()
    {
        return $this->getEnabledLinks();
    }
    
    /**
     * Answers a message string to be shown when no data is available.
     *
     * @return string
     */
    public function getNoDataMessage()
    {
        return _t(__CLASS__ . '.NODATAAVAILABLE', 'No data available.');
    }
}
