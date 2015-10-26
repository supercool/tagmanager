<?php

namespace Craft;

/**
 * Tag Manager Plugin.
 *
 * Gives tags a nice element interface for quick 'n easy editing.
 *
 * @author    Bob Olde Hampsink <b.oldehampsink@itmundi.nl>
 * @copyright Copyright (c) 2015, Bob Olde Hampsink
 * @license   http://buildwithcraft.com/license Craft License Agreement
 *
 * @link      http://github.com/boboldehampsink
 */
class TagManagerPlugin extends BasePlugin
{
    /**
     * Get plugin name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Tag Manager');
    }

    /**
     * Get plugin version.
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.2.0';
    }

    /**
     * Get plugin developer.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'Bob Olde Hampsink';
    }

    /**
     * Get plugin developer url.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://www.itmundi.nl';
    }

    /**
     * Has cp section.
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }

    /**
     * Register routes for Control Panel.
     *
     * @return array
     */
    public function registerCpRoutes()
    {
        return array(
            'tagmanager'                                          => array('action' => 'tagManager/tagIndex'),
            'tagmanager/(?P<groupHandle>{handle})/new'            => array('action' => 'tagManager/editTag'),
            'tagmanager/(?P<groupHandle>{handle})/(?P<tagId>\d+)' => array('action' => 'tagManager/editTag'),
        );
    }

    /**
     * Allow Pimp My Matrix to be configured from the tag group field layouts
     *
     * @return array
     */
    public function loadPimpMyMatrixConfigurator()
    {

        $segments = craft()->request->getSegments();

        if ( count($segments) == 3
             && $segments[0] == 'settings'
             && $segments[1] == 'tags'
             && $segments[2] != 'new'
           )
        {
            return array(
                'container' => '#fieldlayoutform',
                'context' => 'taggroup:'.$segments[2]
            );
        }

    }

    /**
     * Allow Pimp My Matrix to run on the edit pages
     *
     * @return string
     */
    public function loadPimpMyMatrixFieldManipulator()
    {

      $segments = craft()->request->getSegments();

      if ( count($segments) == 3 && $segments[0] == 'tagmanager' )
      {
        $tagGroup = craft()->tags->getTagGroupByHandle($segments[1]);
        if ($tagGroup)
        {
          return 'taggroup:'.$tagGroup->id;
        }
      }

    }

}
