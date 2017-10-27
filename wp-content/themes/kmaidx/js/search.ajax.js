/* Functions used in search forms */

$(".select2-omni-field").select2({
    placeholder: 'City, area, subdivision or zip',
    ajax: {
        url: 'https://mothership.kerigan.com/api/v1/omnibar',
        dataType: 'json',
        delay: 250,
        cache: true,
        data: function (params) {
            var query = {
                search: params.term,
                type: 'public'
            }
            return query;
        }
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 3,
    dropdownParent: $('.search-control')
});

$('.select2-property-type').select2({
    placeholder: 'Property type',
    dropdownParent: $('.search-control')
});

$('.select-other').select2({
    width: '100%',
    tags: true,
    dropdownParent: $('.search-control')
});

window.onload = function(){

    $('.criterion').click(function(){
        var removed = $(this).attr("data-call");
        removeParam(removed, window.location.href );
    });
}

$( document ).ready(function(){

    $(".lazy").Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    })

});

