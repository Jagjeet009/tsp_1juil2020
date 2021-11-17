<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php //print_r($districts);?>
<?php foreach($districts as $d){?>
<option value="<?php echo $d['id']; ?>">[<?php echo $d['id']; ?>] <?php echo $d['name']; ?></option>
<?php }?>
