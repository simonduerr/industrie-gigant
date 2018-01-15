$(function () {
    var data = {
        tiles: [{
            tileId: 651,
            infraId: 2
        }, {
            tileId: 652
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

    });

    $.ajax({
        dataType: "json",
        url: 'http://localhost:8000/buildings/all',
        success: function (data) {
            console.log(data);
            var html = '';
            $.each(data, function (i, element) {
                console.log(element);
                html += '<div class="menutile" data-id="' + element.id + '">' + element.name + '</div>'
            });

            $('#menubar').html(html);

            $('.menutile').click(function (e) {
                $('#cursor').data('id', $(this).data('id'));
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
            console.log(data);
            $.each(data, function (i, element) {
                console.log(element);
                html += '<div class="tile" data-id="' + element.id + '" data-x="' + element.x + '" data-y="' +
                    element.y + '" style="left: ' + element.x * 55 + 'px; top: ' + element.y * 55 + 'px"></div>';
                console.log(html);
            });
            $('#field').html(html);

            $('.tile').click(function (e) {
                var cursor = $('#cursor');
                var tile = $(this);
                if (isHousePlaceable(cursor.data('id'), tile)) {
                    $.ajax({
                        dataType: "json",
                        url: 'http://localhost:8000/tile/' + tile.data('id') + '/add/building   /' + cursor.data('id'),
                        success: function (data) {
                            if (data.validation === 1) {
                                if (data.error === 0) {
                                    console.log('Das Haus ' + cursor.data('action') + ' steht jetzt auf Platz ' + tile.data('x') + "/" + tile.data('y'));
                                    tile.addClass(cursor.data('action'));
                                    tile.data('house', cursor.data('action'));
                                    $.each(getAffectedTiles(cursor.data('action'), tile), function (i, element) {
                                        element.addClass(cursor.data('action'));
                                        element.data('blocked-by', cursor.data('action'));
                                    });
                                    cursor.data('action', '');
                                    $('.menutile').removeClass('active');
                                }
                            }
                            console.log(data.message);
                        },
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
            });
        }
    });
});


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


