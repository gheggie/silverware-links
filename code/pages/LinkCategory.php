<?php

/**
 * An extension of the page class for a link category.
 */
class LinkCategory extends Page
{
    private static $singular_name = "Link Category";
    private static $plural_name   = "Link Categories";
    
    private static $description = "A category of links within a link page";
    
    private static $icon = "silverware-links/images/icons/LinkCategory.png";
    
    private static $default_child = "LinkItem";
    
    private static $can_be_root = false;
    
    private static $db = array(
        
    );
    
    private static $defaults = array(
        'ShowInMenus' => 0,
        'ShowInSearch' => 0
    );
    
    private static $allowed_children = array(
        'LinkItem'
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
        
        // Create Field Objects:
        
        
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the parent page of the receiver.
     *
     * @return PublicationPage
     */
    public function ParentPage()
    {
        if ($this->Parent() instanceof LinkPage) {
            return $this->Parent();
        }
    }
    
    /**
     * Answers the link items within the category.
     *
     * @return DataList
     */
    public function Links()
    {
        return $this->AllChildren();
    }
    
    /**
     * Answers true if the category has links.
     *
     * @return boolean
     */
    public function HasLinks()
    {
        return $this->Links()->exists();
    }
}

/**
 * An extension of the page controller class for a link category.
 */
class LinkCategory_Controller extends Page_Controller
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
    }
}
