<?php
/*
 * Template Name: MLS_Search
 *
 * @package idx
 */

get_header(); ?>

<?php

$mls = new MLS();

?>
    <form action="/search-results" method="post">
        <input type="hidden" name="cmd" value="mlssearch">
        <?php
        echo '<select name="city">';
        echo '<option value="">Select one</option>';
        foreach ($mls->getDistinctColumn('city') as $listing) {
            echo '<option value="' . $listing->city . '">' . $listing->city . '</option>';
        }
        echo '</select>';

        echo '<select name="price">';
        echo '<option value="">Select one</option>';
        for($i = 0; $i < 1000000; $i+=10000){
            echo '<option value="' . $i . '">$' . $i . '</option>';
        }
        echo '</select>';

        echo '<select name="bedrooms">';
        echo '<option value="">Select one</option>';
        foreach ($mls->getDistinctColumn('bedrooms') as $listing) {
            echo '<option value="' . $listing->bedrooms . '">' . $listing->bedrooms . '+</option>';
        }
        echo '</select>';

        echo '<select name="class">';
        echo '<option value="">Select one</option>';
        foreach ($mls->getDistinctColumn('class') as $listing) {
            echo '<option value="' . $listing->class . '">' . $listing->class . '</option>';
        }
        echo '</select>';

        ?>
        <button type="submit">Submit</button>
    </form>

<?php


get_footer();
