$(function () {
    /*var data = {
        tiles: [{
            tileId: 651,
            infraId: 2
        }, {
            tileId: 652,
            infraId: 3
        }]
    };
    console.log(data);
    console.log(JSON.stringify(data));
    $.ajax({
        dataType: "json",
        url: "http://localhost:8000/infrastructure/build",
        data: data,
        success: function (data) {
            console.log(data);
        }

    });*/

    $.ajax({
        dataType: "json",
        url: 'http://localhost:8000/buildings/all',
        success: function (data) {
            //console.log(data);
            var html = '';
            $.each(data, function (i, element) {
                //console.log(element);
                html += '<div class="menutile" data-id="' + element.id + '">' + element.name + '</div>'
            });

            $('#menubar').html(html);

            $('#menubar .menutile').click(function (e) {
                $('#cursor').data('id', $(this).data('id'));
                $('#cursor').data('type', 'building');
                $('.menutile').removeClass('active');
                $(this).addClass('active');
            });
        }
    });

    $.ajax({
        dataType: "json",
        url: 'http://localhost:8000/infrastructure/all',
        success: function (data) {
            var html = '';
            $.each(data, function (i, element) {
                html += '<div class="menutile" data-id="' + i + '">' + element + '</div>'
            });

            $('#menubar-infra').html(html);

            $('#menubar-infra .menutile').click(function (e) {
                $('#cursor').data('id', $(this).data('id'));
                $('#cursor').data('type', 'infra');
                $('.menutile').removeClass('active');
                $(this).addClass('active');
            });
        }
    });

    $.ajax({
        dataType: "json",
        url: 'http://localhost:8000/tiles/all',
        success: function (data) {
            var html = '';
            //console.log(data);
            $.each(data, function (i, element) {
                //console.log(element);
                html += '<div class="tile"' +
                    'data-id="' + element.id +
                    '" data-x="' + element.x +
                    '" data-y="' + element.y +
                    '" data-building="' + element.builtObject +
                    '" data-infra="' + element.infrastructure +
                    '" data-terrain="' + element.terrain +
                    '" style="left: ' + element.x * 55 + 'px; top: ' + element.y * 55 + 'px"></div>';
                //console.log(html);
            });
            $('#field').html(html);
            rewriteTiles();

            $('.tile').click(function (e) {
                var cursor = $('#cursor');
                var tile = $(this);
                var id = cursor.data('id');
                var type = cursor.data('type');


                if (type === 'building') {
                    url = 'tile/' + tile.data('id') + '/build/building/' + id;
                    console.log(url);
                    success = function (data) {
                        console.log(data);
                        if (!data['code']) {
                            tile.data('building', data[0]['id']);
                            rewriteTiles();
                        }
                    };
                    doAjax(url, null, success);
                }
                else if (type === 'infra') {
                    url = 'tile/' + tile.data('id') + '/build/infrastructure/' + id;
                    console.log(url);
                    success = function (data) {
                        console.log(data);
                        if (!data['code']) {
                            tile.data('infra', data[0]['infrastructure']);
                            rewriteTiles();
                        }
                    };
                    doAjax(url, null, success);
                }

            });
        }
    });
});

function doAjax(url, data, success) {
    $.ajax({
        dataType: "json",
        data: data,
        url: 'http://localhost:8000/' + url,
        success: success,
        statusCode: {
            404: function () {
                console.log("page not found");
            },
            500: function () {
                console.log("server error");
            }
        }
    });
}

function isHousePlaceable(house_id, tile) {
    return true;
    if (tile.data('house') !== '' && tile.data('blocked-by') !== '') {
        console.log('Can\'t you see the house ' + tile.data('house') + ' on this tile?');
        return false;
    }
    var house = $('#menu-' + house_id);
    var house_width = house.data('width');
    var house_height = house.data('height');
    if (house_width > 1) {
        if (tile.data('x') + house_width - 1 > 5) {
            return false;
        }
    }
    if (house_height > 1) {
        if (tile.data('y') + house_height - 1 > 5) {
            return false;
        }
    }
    return true;
}

function getAffectedTiles(house_id, tile) {
}

function rewriteTiles() {
    $('.tile').each(function (i, element) {
        html = 'B: ' + ($(this).data('building') ? $(this).data('building') : '') + '<br />';
        html += 'I: ' + ($(this).data('infra') ? $(this).data('infra') : '') + '<br />';
        html += 'T: ' + ($(this).data('terrain') ? $(this).data('terrain') : '') + '<br />';
        $(this).html(html);
    });
}

