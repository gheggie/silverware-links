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

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\SS_List;
use SilverWare\Components\BaseComponent;
use SilverWare\FontIcons\Forms\FontIconField;
use SilverWare\Forms\FieldSection;
use SilverWare\Lists\ListSource;
use Page;

/**
 * An extension of the page class for a link page.
 *
 * @package SilverWare\Links\Pages
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-links
 */
class LinkPage extends Page implements ListSource
{
    /**
     * Define constants.
     */
    const SORT_ORDER = 'order';
    const SORT_TITLE = 'title';
    
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Link Page';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Link Pages';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'Holds a series of links organised into categories';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/links: admin/client/dist/images/icons/LinkPage.png';
    
    /**
     * Defines the table name to use for this object.
     *
     * @var string
     * @config
     */
    private static $table_name = 'SilverWare_LinkPage';
    
    /**
     * Defines the default child class for this object.
     *
     * @var string
     * @config
     */
    private static $default_child = LinkCategory::class;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'ListIcon' => 'FontIcon',
        'SortOrder' => 'Varchar(16)',
        'HeadingLevel' => 'Varchar(2)'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'ListIcon' => 'external-link'
    ];
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = [
        LinkCategory::class
    ];
    
    /**
     * Defines the default heading level to use.
     *
     * @var array
     * @config
     */
    private static $heading_level_default = 'h4';
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Define Placeholder:
        
        $placeholder = _t(__CLASS__ . '.DROPDOWNDEFAULT', '(default)');
        
        // Create Style Fields:
        
        $fields->addFieldsToTab(
            'Root.Style',
            [
                FieldSection::create(
                    'LinkStyle',
                    $this->fieldLabel('LinkStyle'),
                    [
                        FontIconField::create(
                            'ListIcon',
                            $this->fieldLabel('ListIcon')
                        ),
                        DropdownField::create(
                            'HeadingLevel',
                            $this->fieldLabel('HeadingLevel'),
                            BaseComponent::singleton()->getTitleLevelOptions()
                        )->setEmptyString(' ')->setAttribute('data-placeholder', $placeholder)
                    ]
                )
            ]
        );
        
        // Create Options Fields:
        
        $fields->addFieldsToTab(
            'Root.Options',
            [
                FieldSection::create(
                    'LinkOptions',
                    $this->fieldLabel('LinkOptions'),
                    [
                        DropdownField::create(
                            'SortOrder',
                            $this->fieldLabel('SortOrder'),
                            $this->getSortOrderOptions()
                        )->setEmptyString(' ')->setAttribute('data-placeholder', $placeholder)
                    ]
                )
            ]
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
        
        $labels['ListIcon'] = _t(__CLASS__ . '.LISTICON', 'List icon');
        $labels['SortOrder'] = _t(__CLASS__ . '.SORTORDER', 'Sort order');
        $labels['HeadingLevel'] = _t(__CLASS__ . '.CATEGORYHEADINGLEVEL', 'Category heading level');
        
        $labels['LinkStyle'] = $labels['LinkOptions'] = _t(__CLASS__ . '.LINKS', 'Links');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Answers the heading tag for the receiver.
     *
     * @return string
     */
    public function getHeadingTag()
    {
        if ($tag = $this->getField('HeadingLevel')) {
            return $tag;
        }
        
        return $this->config()->heading_level_default;
    }
    
    /**
     * Answers true if a list icon is to be shown in the template.
     *
     * @return boolean
     */
    public function hasListIcon()
    {
        return (boolean) $this->ListIcon;
    }
    
    /**
     * Answers all categories within the receiver.
     *
     * @return DataList
     */
    public function getAllCategories()
    {
        return $this->AllChildren()->filter('ClassName', LinkCategory::class);
    }
    
    /**
     * Answers all visible categories within the receiver.
     *
     * @return ArrayList
     */
    public function getVisibleCategories()
    {
        return $this->getAllCategories()->filterByCallback(function ($category) {
            return $category->hasEnabledLinks();
        });
    }
    
    /**
     * Answers a list of links within the page.
     *
     * @return DataList
     */
    public function getLinks()
    {
        return $this->sort(Link::get()->filter('ParentID', $this->AllChildren()->column('ID') ?: null));
    }
    
    /**
     * Answers a list of all enabled links within the receiver.
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
    
    /**
     * Answers an array of options for the sort order field.
     *
     * @return array
     */
    public function getSortOrderOptions()
    {
        return [
            self::SORT_ORDER => _t(__CLASS__ . '.ORDER', 'Order'),
            self::SORT_TITLE => _t(__CLASS__ . '.TITLE', 'Title')
        ];
    }
    
    /**
     * Sorts the given list of links.
     *
     * @param SS_List $list
     *
     * @return SS_List
     */
    public function sort(SS_List $list)
    {
        switch ($this->SortOrder) {
            case self::SORT_ORDER:
                return $list->sort('Sort');
            case self::SORT_TITLE:
                return $list->sort('Title', 'ASC');
        }
        
        return $list;
    }
}
