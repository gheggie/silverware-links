<?php

/**
 * An extension of the page class for a link page.
 */
class LinkPage extends Page
{
    private static $singular_name = "Link Page";
    private static $plural_name   = "Link Pages";
    
    private static $description = "Holds a series of links";
    
    private static $icon = "silverware-links/images/icons/LinkPage.png";
    
    private static $default_child = "LinkCategory";
    
    private static $db = array(
        'CategoriesStart' => 'Varchar(16)',
        'ToggleCategories' => 'Boolean',
        'OpenLinksInNewTab' => 'Boolean',
        'HideEmptyCategories' => 'Boolean'
    );
    
    private static $defaults = array(
        'CategoriesStart' => 'open',
        'ToggleCategories' => 1,
        'OpenLinksInNewTab' => 1,
        'HideEmptyCategories' => 1
    );
    
    private static $allowed_children = array(
        'LinkItem',
        'LinkCategory'
    );
    
    /**
     * Answers a collection of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Create Options Tab:
        
        $fields->findOrMakeTab('Root.Options', _t('LinkPage.OPTIONS', 'Options'));
        
        // Create Options Fields:
        
        $fields->addFieldToTab(
            'Root.Options',
            ToggleCompositeField::create(
                'LinkPageOptions',
                $this->i18n_singular_name(),
                array(
                    CheckboxField::create(
                        'ToggleCategories',
                        _t('LinkPage.TOGGLECATEGORIES', 'Toggle categories')
                    ),
                    DropdownField::create(
                        'CategoriesStart',
                        _t('LinkPage.CATEGORIESSTART', 'Categories start'),
                        $this->getCategoriesStartOptions()
                    )->displayIf('ToggleCategories')->isChecked()->end(),
                    CheckboxField::create(
                        'OpenLinksInNewTab',
                        _t('LinkPage.OPENLINKSINNEWTAB', 'Open links in new tab')
                    ),
                    CheckboxField::create(
                        'HideEmptyCategories',
                        _t('LinkPage.HIDEEMPTYCATEGORIES', 'Hide empty categories')
                    )
                )
            )
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers an array of categories start options.
     *
     * @return array
     */
    public function getCategoriesStartOptions()
    {
        return array(
            'open'   => _t('LinkPage.OPEN', 'Open'),
            'closed' => _t('LinkPage.CLOSED', 'Closed')
        );
    }
    
    /**
     * Answers a list of the categories within the receiver.
     *
     * @return DataList
     */
    public function Categories()
    {
        $Categories = $this->AllChildren()->filter('ClassName', 'LinkCategory');
        
        if ($this->HideEmptyCategories) {
            
            $Categories = $Categories->filterByCallback(function ($Category) {
                return $Category->HasLinks();
            });
            
        }
        
        return $Categories;
    }

    /**
     * Answers the links within the receiver.
     *
     * @return DataList
     */
    public function Links()
    {
        return $this->AllChildren()->filter('ClassName', 'LinkItem');
    }
}

/**
 * An extension of the page controller class for a link page.
 */
class LinkPage_Controller extends Page_Controller
{
    /**
     * Defines the URLs handled by this controller.
     */
    private static $url_handlers = array(
        
    );
    
    /**
     * Defines the allowed actions for this controller.
     */
    private static $allowed_actions = array(
        
    );
    
    /**
     * Performs initialisation before any action is called on the receiver.
     */
    public function init()
    {
        // Initialise Parent:
        
        parent::init();
        
        // Load Requirements:
        
        Requirements::themedCSS('silverware-links', SILVERWARE_LINKS_DIR);
        
        Requirements::javascript(FRAMEWORK_DIR . '/thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
        Requirements::javascript(SILVERWARE_LINKS_DIR . '/javascript/silverware-links.js');
    }
}
