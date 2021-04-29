<?php

/**
 * An extension of the page class for a link item.
 */
class LinkItem extends Page
{
    private static $singular_name = "Link";
    private static $plural_name   = "Links";
    
    private static $description = "An individual link within a link page";
    
    private static $icon = "silverware-links/images/icons/LinkItem.png";
    
    private static $allowed_children = "none";
    
    private static $can_be_root = false;
    
    private static $db = array(
        'LinkURL' => 'Varchar(2048)'
    );
    
    private static $defaults = array(
        'ShowInMenus' => 0,
        'ShowInSearch' => 0
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
        
        // Modify Field Objects:
        
        $fields->dataFieldByName('Title')->setTitle(_t('LinkItem.LINKNAME', 'Link name'));
        
        // Remove Field Objects:
        
        $fields->removeFieldsFromTab(
            'Root.Main',
            array(
                'Content',
                'Metadata',
                'MetaImageToggle',
                'MetaSummaryToggle'
            )
        );
        
        // Create Field Objects:
        
        $fields->addFieldsToTab(
            'Root.Main',
            array(
                TextField::create(
                    'LinkURL',
                    _t('LinkItem.LINKURL', 'Link URL')
                )
            )
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the parent category of the receiver (if it exists).
     *
     * @return LinkCategory
     */
    public function Category()
    {
        if ($this->Parent() instanceof LinkCategory) {
            return $this->Parent();
        }
    }
    
    /**
     * Answers the parent page of the receiver.
     *
     * @return LinkPage
     */
    public function ParentPage()
    {
        if ($this->Parent() instanceof LinkCategory) {
            return $this->Parent()->ParentPage();
        } elseif ($this->Parent() instanceof LinkPage) {
            return $this->Parent();
        }
    }
    
    /**
     * Answers a validator for the CMS interface.
     *
     * @return RequiredFields
     */
    public function getCMSValidator()
    {
        return RequiredFields::create(
            array(
                'LinkURL'
            )
        );
    }
    
    /**
     * Answers true if links are to open in a new tab.
     *
     * @return boolean
     */
    public function OpenInNewTab()
    {
        return $this->ParentPage()->OpenLinksInNewTab;
    }
}

/**
 * An extension of the page controller class for a link item.
 */
class LinkItem_Controller extends Page_Controller
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
    }
}
