<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php //print_r($states);?>
<?php foreach($states as $s){?>
<option value="<?php echo $s['id']; ?>">[<?php echo $s['id']; ?>] <?php echo $s['name']; ?></option>
<?php }?>