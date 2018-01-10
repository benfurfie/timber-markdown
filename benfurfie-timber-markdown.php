<?php

namespace BenFurfie\TimberMarkdown;

/**
 * Add markdown support to Timber.
 * 
 * Plugin Name: Timber Markdown
 * Description: Add markdown support to Timber.
 * Author: Ben Furfie
 * Author URI: https://www.benfurfie.co.uk
 * License: MIT
 * Version: 0.1.0
 * 
 * @package WordPress
 * @subpackage Timber Markdown
 * @version 0.1.0
 * @copyright Copyright © 2018 Ben Furfie
 */

/**
 * Include Parsedown.
 * 
 * @since 0.1.0
 */

require_once('inc/parsedown.php');

/**
 * Add filter class.
 * 
 * @since 0.1.0
 */

if ( ! class_exists( 'Timber_Twig_Markdown_Filter' ) && class_exists( 'Timber' ) && class_exists( 'Parsedown' ) ) :

    class Timber_Twig_Markdown_Filter {
    
        /**
         * Constructor
         * 
         * @since 0.1.0
         */
        public function __construct( ) {
            add_filter( 'get_twig', array( $this, 'define_filter' ) );
        }
    
    
        /**
         * Filter Definition
         * 
         * @since 0.1.0
         */
        public function define_filter( $twig ) {
            $twig->addFilter( new \Twig_SimpleFilter( 'markdown', array( $this, 'parse_markdown' ) ) );
    
            return $twig;
        }
    
        /**
         * Markdown Parser
         * 
         * @since 0.1.0
         */
        public function parse_markdown( $text ) {
            $parser = new \Parsedown();
    
            return $parser->text( $text );
        }
    }
    
    new Timber_Twig_Markdown_Filter();

else:

    function timber_markdown_admin_notice_error()
    {
        ?>
        <div class="notice notice-error is-dismissible">
            <p>Error: Can't find Parsedown class.</p>
        </div>
        <?php
    }
    add_action( 'admin_notices', 'BenFurfie\TimberMarkdown\timber_markdown_admin_notice_error' );

endif;