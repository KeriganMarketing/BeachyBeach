/**
 * For Ajax Requests thru WP. Localized as wpAjax.
 */
function toggler(menuVar){
    $('#'+menuVar).toggle();
}

function loadIdxAjax(){
    $.ajax({
        type : 'post',
        dataType : 'json',
        url : wpAjax.ajaxurl,
        data : {
            action: 'loadMlsIdx'
        },
        success: function(data) {
            console.log(data);

            $(".area-select").select2({
                placeholder: 'City / Area / Subdivision / Zip',
                dataType: 'json',
                width: '100%',
                tags: true,
                data: data.areaArray
            });

            $('.prop-type-input').select2({
                placeholder: 'Property Type',
                dataType: 'json',
                width: '100%',
                data: data.typeArray
            });

        }

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