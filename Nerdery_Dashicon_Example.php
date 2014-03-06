<?php
/**
  * Plugin Name: Nerdery Dashicon Example
  * Description: Shows the various ways for you to use the new Dashicons in your project.
  * Version:     1.0
  * Author:      The Nerdery / Damion M Broadaway <dbroadaw@nerdery.com>
  * Author URI:  http://www.nerdery.com
  */

    //  Action hook to create a Custom Post Type.
    add_action('init', array('Nerdery_Dashicon_Example', 'dashicon_custom_post_type'));

    //  Action hook to add menu item to the Dashboard.
    add_action('admin_menu', array('Nerdery_Dashicon_Example','dashicon_menu'));

    //  Action hook to filter global $submenu to add Dashicon HTML.
    add_action('admin_menu', array('Nerdery_Dashicon_Example','dashicon_with_filter'));


/**
 *  Class holds plugin for adding a little dash of dashicons around.
 *
 * @package    wplatest.dev
 * @subpackage Nerdery_Dashicon_Example
 * @version    $Id$
 * @author     Damion M Broadaway <dbroadaw@nerdery.com>
 * @created    2/25/14 at 9:54 AM
 */
class Nerdery_Dashicon_Example
{

    /***************************************************************************
    ****    Adding a Dashicon to a Custom Menu Item
    ***************************************************************************/

    /**
     *  Utilizes add_menu_page() to add a custom menu item
     *      to the WordPress Dashboard.
     *
     * @link    http://codex.wordpress.org/Function_Reference/add_menu_page
     */
    public function dashicon_menu()
    {
        add_menu_page(
            'Documentation',
            'Documentation',
            'manage_options',
            'nerdery-documentation',
            array(
                'Nerdery_Dashicon_Example',
                'basic_menu_dashicon_callback'
            ),
            'dashicons-welcome-learn-more',     // <- Dashicon CSS class
            100
        );
    }

    public function basic_menu_dashicon_callback()
    {
        ?>
        <div class="wrap">
            <h2><div class="dashicons dashicons-welcome-learn-more"></div> Documentation</h2>
        </div>
        <?php
    }

    /***************************************************************************
    ****    Adding a Dashicon to a Custom Post Type
    ***************************************************************************/

    /**
     *  Create a 'Book' custom post type with a Dashicon.
     *
     * @link    http://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function dashicon_custom_post_type()
    {
        $labels = array(
            'name'                  => 'Books',
            'singular_name'         => 'Book',
            'add_new'               => 'Add New',
            'add_new_item'          => 'Add New Book',
            'edit_item'             => 'Edit Book',
            'new_item'              => 'New Book',
            'all_items'             => 'All Books',
            'view_item'             => 'View Book',
            'search_items'          => 'Search Books',
            'not_found'             => 'No books found',
            'not_found_in_trash'    => 'No books found in Trash',
            'parent_item_colon'     => '',
            'menu_name'             => 'Books'
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array( 'slug' => 'book' ),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 101,
            'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            'menu_icon'             => 'dashicons-book'     // <- Dashicon CSS class
        );

        register_post_type( 'book', $args );
    }

    /***************************************************************************
    ****    Adding a Dashicon to a submenu item using a filter.
    ***************************************************************************/

    /**
     *  Filter the WordPress Dashboard to add Dashicons
     *      to submenu items. Specifically a Custom Post Type
     *
     */
    public function dashicon_with_filter()
    {
        //  add the global variable that holds all
        //      Dashboard menu information
        global $submenu;

        //  make two variables to hold each of our Dashicons
        //      and set them equal to the snippet
        $dashicon_all = '<div class="dashicons dashicons-marker"></div> ';
        $dashicon_new = '<div class="dashicons dashicons-plus"></div> ';

        //  make an array that holds the URL of each
        //      menu item you want to filter
        $filtered_pages = array(
            'edit.php?post_type=book'
        );

        //  loop through $submenu
        //  match the pages you want to filter
        //  add the Dashicon variable to the array
        foreach ( $filtered_pages as $page ) {
            if (!isset($submenu[$page])) {continue;}
            $submenu[$page][5][0] = $dashicon_all . $submenu[$page][5][0];
            $submenu[$page][10][0] = $dashicon_new . $submenu[$page][10][0];
        }
    }

} 
