<?php

// prevent the direct access
defined('_PREVENT-DIRECT-ACCESS') or die ("Access restrict");

?>

<?php if(isset($_SESSION['flash']['notice'])): ?>
	
    <div class="message success closeable">
        <p><?php echo $_SESSION['flash']['notice'] ;?></p>
    </div>
	
<?php endif; ?>

<?php if(isset($_SESSION['flash']['warning'])): ?>
	
    <div class="message error closeable">
        <p><?php echo $_SESSION['flash']['warning'] ?></p>
    </div>
    
<?php endif; ?>

<?php if(isset($_SESSION['flash']['tip'])): ?>
	
    <div class="message tip closeable">
        <p><?php echo $_SESSION['flash']['tip'] ?></p>
    </div>
    
<?php endif; ?>