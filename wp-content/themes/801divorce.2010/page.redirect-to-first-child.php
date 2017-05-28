<?php /* Template Name: Redirect To First SubPage */
if (have_posts()) {
  while (have_posts()) {
    the_post();
    $pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
    $firstchild = $pagekids[0];
    wp_redirect(get_permalink($firstchild->ID));
  }
}
/*
ADD THIS TO WP CONTENT FOR PAGE:
------------------------------
NOTE:

This page is a navigation "placeholder". When you click it, it redirects to it's first sub-page.

To make this an actual page with content, switch the template (to the right under "Attributes" from "Redirects to First SubPage" to "Default Template" and add content (and click "Update"!).
*/
?>