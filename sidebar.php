<?php
if (!is_active_sidebar('sidebar-courses')) return;
?>
<aside class="archive-sidebar" id="secondary">
    <?php dynamic_sidebar('sidebar-courses'); ?>
</aside>
