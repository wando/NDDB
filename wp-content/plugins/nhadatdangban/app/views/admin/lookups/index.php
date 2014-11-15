<?php   
/**
 * Lookups index page
 * @Author: Quang Do (quangdh81@gmail.com)
 */

 $this->load_helper('FormEx');
 $query_vars = $this->form_ex->getQueryVars();
 $paginate_links = paginate_links($pagination);
 if (!isset($query_vars['orderby'])) $query_vars['orderby'] = '';
 if (!isset($query_vars['order'])) $query_vars['order'] = '';
?>

<div class="icon32" id="icon-lookups"><br></div>
<h2>Lookups <a class="add-new-h2" href="<?php echo MvcRouter::admin_url(array('controller'=>'lookups','action' => 'add')) ?>">Add New</a></h2>

<form id="posts-filter" action="<?php echo MvcRouter::admin_url(); ?>" method="get">
    <p class="search-box">
        <label class="screen-reader-text" for="q">Lookups:</label>
        <input type="hidden" name="page" value="<?php echo MvcRouter::admin_page_param($model->name); ?>"/>
        <input type="text" id="q" name="q" value="<?php echo empty($params['q']) ? '' : str_replace("\%","%",$params['q']); ?>"/>
        <input type="submit" value="Search Lookups" class="button"/>
    </p>
</form>

<div class="tablenav">
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo ($record_count); ?> items</span>
        <?php echo $paginate_links; ?>
    </div>
    <div class="alignleft actions">
        
    </div>
</div>
<div class="clear"></div>

<table class="widefat post fixed" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='name'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='name'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'name', 'order'=>($query_vars['orderby']=='name'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Name</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='value'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='value'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'value', 'order'=>($query_vars['orderby']=='value'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Value</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='keywords'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='keywords'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'keywords', 'order'=>($query_vars['orderby']=='keywords'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Keywords</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='name'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='name'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'name', 'order'=>($query_vars['orderby']=='name'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Name</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='value'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='value'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'value', 'order'=>($query_vars['orderby']=='value'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Value</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope="col" width="25%" class="manage-column <?php echo ($query_vars['orderby']=='keywords'?'sorted':'sortable') ?>
                                                             <?php echo ($query_vars['orderby']=='keywords'&&$query_vars['order']=='asc'?'asc':'desc') ?>">
                <a href="?<?php echo $this->form_ex->getURLWithQueryVars(array('orderby'=>'keywords', 'order'=>($query_vars['orderby']=='keywords'&&$query_vars['order']=='asc'?'desc':'asc'))); ?>">
                <span>Keywords</span>
                <span class="sorting-indicator"></span>
                </a>
            </th>
        </tr>
    </tfoot>
    <tbody>
        <?php if (count($objects) == 0) { ?>
            <tr>
                <td colspan="3">
                    <?php echo MSG_NO_DATA_FOUND; ?>
                </td>
            </tr>
        <?php } ?>
        <?php foreach ($objects as $object): ?>
            <tr>
                <td>
                    <?php echo $object->name; ?>
                    <div class="row-actions">
                        <span class="edit"><?php echo $this->form_ex->edit_delete_link($this, $object); ?></span>
                    </div>
                </td>
                <td>
                    <?php echo $object->value; ?>
                </td>
                <td>
                    <?php echo $object->keywords; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php echo paginate_links($pagination); ?>
    </div>
</div>

