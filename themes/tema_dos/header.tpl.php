<div id="wrapper">
<div id="header">

<?php if ($logo): ?>
<div id="logo">
<img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>" title="< ?php print $site_name; ?>" id="logo" />
</div>
<?php endif; ?>

<?php print render( $page['header'] ); ?>
</div>
<div id="menu"><?php print render( $page['menu'] ); ?></div>