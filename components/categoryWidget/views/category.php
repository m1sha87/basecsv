<?php
use yii\helpers\Url;

/* @var $model \app\components\categoryWidget\CategoryWidget */

?>
<div class="row category-widget" id="<?= $model->id ?>">
    <div class="panel panel-default col-sm-5">
        <div class="panel-body categoryContainer">
            
        </div>
    </div>
    <div class="panel panel-default col-sm-7">
        <div class="panel-heading categoryToolbar">
            <?= $model->toolbar ?>
        </div>
        <div class="panel-body">
            <div class="itemContainer">
            
            </div>
        </div>
    </div>
</div>

<script>
    var rootCategory = <?= $model->root ?>;
    var mainCategory = <?= $model->main ? $model->main : 'false' ?>;
    var current = <?= $model->current ? $model->current : 'false' ?>;
    var hide = <?= $model->hide ? $model->hide : 'false' ?>;
    var types = <?= $model->types ? json_encode($model->types) : 'false' ?>;
    var parents = false;
    var parentCounter = 0;
    
    function getChilds() {
        var id = $(this).data('id') || rootCategory;
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/category/get-childs' ?>',
            type: 'POST',
            data: {
                id: id,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                if (data.categories)
                    drawChilds(data.categories, id);
            }
        });
    }

    function getParents() {
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/category/get-parents' ?>',
            type: 'POST',
            data: {
                id: current,
                root: rootCategory,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                if (data.categories) {
                    parents = data.categories;
                    getChilds();
                }
            }
        });
    }
    
    function drawChilds(categories, id) {
        var parent;
        if (id == rootCategory)
            parent = $('.categoryContainer');
        else {
            parent = $('.category-block[data-id=' + id + ']');
            parent.find('i.glyphicon-plus').toggleClass('glyphicon-plus glyphicon-minus');
        }
        for (var i = 0, len = categories.length; i < len; i++) {
            if (hide && hide == categories[i]['id'])
                continue;
            if (mainCategory && categories[i]['parent_id'] == rootCategory && categories[i]['id'] != mainCategory)
                continue;
            var block = $('<div />', {
                'data-id': categories[i]['id'],
                'class': 'category-block'
            });
            var item = $('<div />', {
                'data-id': categories[i]['id'],
                'data-name': categories[i]['name'],
                'text': categories[i]['name']
            });
            item.addClass('category');
            if (categories[i].has_childs) {
                block.addClass('has-childs').one('click', getChilds);
                item.prepend('<i class="glyphicon glyphicon-plus"></i>');
            }
            block.append(item);
            parent.append(block);
        }
        if (parents && parents[parentCounter]) {
            if (parents.length == parentCounter+1) {
                $('.category[data-id=' + parents[parentCounter] + ']').trigger('click');
                parents = false;
            }
            else
                $('.category-block[data-id=' + parents[parentCounter++] + ']').trigger('click');
        } else {
            if ($('.category').length == 1)
                $('.category').trigger('click');
        }
    }
    
    function hideCategories() {
        $(this).toggleClass('glyphicon-plus glyphicon-minus').parent().parent().find('>div.category-block').hide();
    }

    function showCategories() {
        $(this).toggleClass('glyphicon-plus glyphicon-minus').parent().parent().find('>div.category-block').show();
    }
    
    function getItems(category) {
        var id = category.data('id') || rootCategory;
        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl . '/category/get-items' ?>',
            type: 'POST',
            data: {
                id: id,
                types: types,
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                $('.itemContainer').html(data);
                $('.category-widget').triggerHandler('afterAddItems', $(this));
            }
        });
    }
    
    $(document).on('click', 'i.glyphicon-minus', hideCategories)
        .on('click', 'i.glyphicon-plus', showCategories)
        .on('click', '.category', function () {
            $('.category.selected').removeClass('selected');
            $(this).addClass('selected');
            $('.category-widget').triggerHandler('afterSelectCategory', $(this));
            if (types)
                getItems($(this));
        }).on('click', '.item', function () {
            $('.item.selected').removeClass('selected');
            $(this).addClass('selected');
        });
    
    $(document).ready(function () {
        if (current && current != rootCategory) {
            getParents();
        } else {
            getChilds();
        }
    });
</script>