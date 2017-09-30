<?php
/* @var $items array */
?>

<div class="list">
    <?php foreach ($items as $item) : ?>
    <div class="row item">
        <div class="col-xs-1">
            <img src="<?= $item->getIcon() ?>" width="20px" alt="">
        </div>
        <div class="col-xs-7">
            <?= $item->name ?>
        </div>
        <?php if($item->type == 'geo') : ?>
        <button type="button" class="add-item btn btn-success btn-xs pull-right" data-id="<?= $item->id ?>" data-name="<?= $item->name?>">
            <i class="glyphicon glyphicon-plus"></i> Add
        </button>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>