<?php /* SVN: $Id: admin_index.ctp 33254 2010-11-13 08:28:42Z sakthivel_135at10 $ */ ?>
<?php 
		if(!empty($this->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
?>

<div class="citySuggestions index">
<div class="js-response">
    <h2><?php echo __l('City Suggestions');?></h2>
	<?php echo $this->element('paging_counter');?>
        <table class="list">
            <tr>
                <th class = "dl"><div class="js-pagination"><?php echo $paginator->sort(__l('City Name'),'CitySuggestion.name');?></div></th>
                <th class = "dc"><?php echo __l('No. of Requests');?></th>
                
            </tr>
        <?php
        if (!empty($citySuggestions)):
        
        $i = 0;
        foreach ($citySuggestions as $citySuggestion):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
        ?>
            <tr<?php echo $class;?>>
                <td class = "dl"><?php echo $html->cText($citySuggestion['CitySuggestion']['name']);?></td>
                <td class = "dc"><?php echo $html->link($html->cInt($citySuggestion['0']['count'], false),array('controller'=>'city_suggestions', 'action'=>'index', 'type'=>'recent_suggestion', 'name'=>urlencode_rfc3986($citySuggestion['CitySuggestion']['name'])),array('class' => 'js-thickbox'));?></td>
            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="6" class="notice"><?php echo __l('No City Suggestions available');?></td>
            </tr>
        <?php
        endif;
        ?>
        </table>
        <div class="js-pagination">
    <?php
    if (!empty($citySuggestions)) {
		?>
            <?php echo $this->element('paging_links'); ?>
        <?php
    }
    ?>
    </div>
	<?php echo $this->element('city_suggest-index', array('cache' => array('time' => Configure::read('site.element_cache')))); ?>
</div>
</div>