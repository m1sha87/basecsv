<button class="btn btn-success btn-xs" id="categorySelect">Выбрать текущую категорию</button>

<script>
    $('#categorySelect').on('click', function (e) {
        e.preventDefault();
        var selectedCategory = $('.category.selected');
        var categoryId = selectedCategory.data('id');
        var categoryName = getCategoryPath(selectedCategory);
        $('#categoryId').val(categoryId);
        $('#categoryName').val(categoryName);
    });
    
    function getCategoryPath(category, path) {
        var parent = category.parent().parent('.category-block').find('>.category');
        if (parent.length > 0) {
            path = getCategoryPath(parent, path) + '/' + category.data('name');
        }
        return path || '' + category.data('name');
    }
    
    $(document).ready(function () {
        $('#categorySelect').trigger('click');
    });
</script>