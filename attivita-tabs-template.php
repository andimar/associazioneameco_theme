
  <?php /* ------ RICORDA CHE C'E' UN PLUGIN CHE PERMETTE QUESTO TEMPLATING  -------- */?>

  <?php /* ------ tabs -------- */?>
  <div class="large-12 medium-12 small-12 columns act-tabs">
    <h2><?php echo single_cat_title(); ?></h2>
    <ul>
      <?php
        $tabmenu = wp_get_nav_menu_items( 'tabmenu');
        foreach($tabmenu as $menuitem): ?>

<?php /*if(is_user_logged_in()) : ?>
<pre>
<?php
 //  var_dump($tabmenu);
?>

</pre>
<?php endif; */?>

        
        <?php
          $title = trim($menuitem->title);
          $class = trim(strtolower(cleanString($menuitem->title) ) );

          $class = str_replace('luned', 'gioved', $class );
        ?>
        <li class="<?=$class?>">


          <a href="<?php echo $menuitem->url?>"><?=$title?></a>
        </li>
     <?php endforeach;?>
   </ul>
  </div>
