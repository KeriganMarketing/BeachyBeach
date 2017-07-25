<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package KMA_DEMO
 */
$mls = new MLS();
if($_POST['doit']){
    $mls->updateAllAgents();
}

get_header(); ?>
    <div id="content">


        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <div style="padding-top: 200px;">
                    <form action="/bcar" method="post">
                        <input type="hidden" name="doit" value="true">
                        <button type="submit">Update BCAR</button>
                    </form>
                    <form action="/ecar" method="post">
                        <input type="hidden" name="doit" value="true">
                        <button type="submit">Update ECAR</button>
                    </form>
                    <form action="/ecar-photos" method="post">
                        <input type="hidden" name="doit" value="true">
                        <button type="submit">Update ECAR photos</button>
                    </form>
                    <form action="" method="post">
                        <input type="hidden" name="doit" value="true">
                        <button type="submit">Update Agents</button>
                    </form>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->


    </div>
<?php get_footer();
