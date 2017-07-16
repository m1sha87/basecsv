<?php
use yii\helpers\Url;

/* @var $root */
/* @var $current */

if (empty($category))
    return '';
?>
<div class="row category-widget">
    <div class="panel panel-default col-sm-5">
        <div class="panel-body" id="categoryContainer">
            
        </div>
    </div>
    <div class="panel panel-default col-sm-7">
        <div class="panel-body">
            
        </div>
    </div>
</div>

<script>
    var rootCategory = <?= $root ?>;
    
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
    
    function drawChilds(categories, id) {
        var parent;
        if (id == rootCategory)
            parent = $('#categoryContainer');
        else {
            parent = $('.category-block[data-id=' + id + ']');
            parent.find('i.glyphicon-plus').toggleClass('glyphicon-plus glyphicon-minus');
        }
        for (var i = 0, len = categories.length; i < len; i++) {
            var block = $('<div />', {
                'data-id': categories[i]['id'],
                'class': 'category-block',
            });
            var item = $('<div />', {
                'data-id': categories[i]['id'],
                'text': categories[i]['name'],
            });
            item.addClass('category');
            if (categories[i].hasOwnProperty('childs')) {
                block.addClass('has-childs').one('click', getChilds);
                item.prepend('<i class="glyphicon glyphicon-plus"></i>');
            }
            block.append(item);
            parent.append(block);
        }
    }
    
    function hideCategories() {
        $(this).toggleClass('glyphicon-plus glyphicon-minus').parent().parent().find('>div.category-block').hide();
    }

    function showCategories() {
        $(this).toggleClass('glyphicon-plus glyphicon-minus').parent().parent().find('>div.category-block').show();
    }
    
    $(document).on('click', 'i.glyphicon-minus', hideCategories)
        .on('click', 'i.glyphicon-plus', showCategories)
        .on('click', '.category', function () {
            $('.category.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#categoryId').val($(this).data('id'));
        });
    
    $(document).ready(function () {
        getChilds();
    });
</script>