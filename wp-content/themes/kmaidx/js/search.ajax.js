/* Functions used in search forms */

function loadIdxAjax(){
    $.ajax({
        type : 'post',
        dataType : 'json',
        url : wpAjax.ajaxurl,
        data : {
            action: 'loadMlsIdx'
        },
        success: function(data) {
            console.log(data.typeArray);

            $(".area-select").select2({
                placeholder: 'City, area, subdivision, or zip',
                minimumInputLength: 3,
                dataType: 'json',
                width: '100%',
                tags: true,
                data: data.areaArray
            });

            $('.prop-type-input').select2({
                placeholder: 'Property type',
                dataType: 'json',
                width: '100%',
                minimumResultsForSearch: -1,
                data: data.typeArray
            });

        }

    });
}

window.onload = function(){
	$('.area-select').select2({
        placeholder: 'City, area, subdivision, or zip',
        minimumInputLength: 3
    });
    $('.prop-type-input').select2({
        placeholder: 'Property type',
        minimumResultsForSearch: Infinity
    });
    $('.select-other').select2({
        width: '100%',
        tags: true
    });

    $('.criterion').click(function(){
        var removed = $(this).attr("data-call");
        removeParam(removed, window.location.href );
    });
}

$( document ).ready(function(){

    loadIdxAjax();

    $(".lazy").Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    })

});

