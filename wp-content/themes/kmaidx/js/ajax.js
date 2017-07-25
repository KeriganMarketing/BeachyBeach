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
                placeholder: 'City, area, subdivision, or zip',
                dataType: 'json',
                width: '100%',
                tags: true,
                data: data.areaArray
            });

            $('.prop-type-input').select2({
                placeholder: 'Property type',
                dataType: 'json',
                width: '100%',
                data: data.typeArray
            });

        }

    });
}

//go get pins for community map
function loadCommMap(){
    $.ajax({
        type : 'post',
        dataType : 'json',
        url : wpAjax.ajaxurl,
        data : {
            action: 'loadCommMapPins'
        },
        success: function(data) {
            console.log(data);

            for (i = 0; i < data.length; i++) {
                var lat = data[i].lat,
                    lng = data[i].lng,
                    type = data[i].type,
                    name = data[i].name;

                addMarker(lat,lng,type,name);
            }
        }

    });
}

$( document ).ready(function(){

    loadIdxAjax();
    loadCommMap();

    $(".lazy").Lazy({
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    })

});

