<?php /* SVN FILE: $Id: default.ctp 3 2010-04-07 06:03:46Z siva_063at09 $ */ ?>
<?php
header('Content-Disposition: inline; filename="' . str_replace('/', '_', $this->params['url']['url']) . '"');
?>
<?php echo $content_for_layout; ?>