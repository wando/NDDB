<?php   
/**
 * Add Lookup page
 * @Author: Quang Do (quangdh81@gmail.com)
 */

wp_enqueue_style('admin-bar');
wp_enqueue_style('wp-admin');
wp_enqueue_style('editor-buttons');

//get input values posted
$name = isset($this->params['data']['Lookup']['name']) ? $this->params['data']['Lookup']['name'] : '';
$value = isset($this->params['data']['Lookup']['value']) ? $this->params['data']['Lookup']['value'] : '';
$keywords = isset($this->params['data']['Lookup']['keywords']) ? $this->params['data']['Lookup']['keywords'] : '';
?>

<div class="icon32" id="icon-lookups"><br></div>
<h2>Add New Lookup</h2>

<div id="poststuff">
    <div class="postbox ">
        <h3 class="hndle"><span>Lookup Information</span></h3>
        <div class="inside">
            <?php echo $this->form->create($model->name); ?>
            <?php echo $this->form->input('name', array('label' => 'Name (<font color="red">*</font>)', 'value' =>$name, 'before' => '<div class="row">', 'after' => '</div>')); ?>
            <?php echo $this->form->input('value', array('label' => 'Value (<font color="red">*</font>)', 'value' =>$value, 'before' => '<div class="row">', 'after' => '</div>')); ?>
            <?php echo $this->form->input('keywords', array('label' => 'Keywords (<font color="red">*</font>)', 'value' =>$keywords, 'before' => '<div class="row">', 'after' => '</div>')); ?>
            <div class="clear" style="height:8px;"></div>
            <div><input type="submit" class='button button-primary' value="Add New Lookup"></div>
            <div class="clear" style="height:8px;"></div>
        </div>
    </div>
</div>
