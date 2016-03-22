$(function() {
    addEvents();
});
    
var removeEvents = function() {
    $('.team-add-button').off('click');
    $('.group-remove-button').off('click');
    $('.group-add-button').off('click');
    $( 'tbody tr td:not(:first-child)').off('click');
    $( '.group-change-button').off('click');
    $('table tbody').sortable( {} );
    $('div.tab-pane .panels').sortable( {} );
    $( "table tfoot.delete" ).droppable({});
}

var addEvents = function() {

    //Group Name Edit 
    $( ".group-change-button").click(function() {
        var title = $(this).parent().children('.gtitle');
        var id = $(this).parent().parent().attr('id').replace('panel-','');
        var value = $.trim($(title).text());

        var name = prompt('Сменете името на групата:', value);
        if(name == null) {
            return;
        }

        var data = {
            action: 'update',
            table: 'group',
            data: {
                name: name
            },
            where: {
                id: id,
            }
        };

        var post = "";

        var i=0;
        $.each(data, function(index, val) {
            if (i !== 0) {
                post += "&";
            }
            var k=0;
            if($.isPlainObject(val)) {
                $.each(val, function(index2, val2) {
                    if (k !== 0) {
                        post += "&";
                    }
                    post += index + "[" + index2 + "]" + "=" + val2;
                    k++;
                });
            } else {
                post += index + "=" + val;
            }
            i++;
        });

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                console.log(data);
                $(title).html(name);
            },
            error:  function(data)
            {
                console.log(data);
            }
        });
    });

    //FIeld Edit 
    $( "tbody tr td:not(:first-child)").click(function() {
        var tr = $(this).parent();
        var id = $(tr).attr('id').replace('row-','');
        var ths = $(this);
        var value = $.trim($(this).text());

        var index = $( this ).index();
        var field = '';

        switch (index) {
            case 1:
                field = 'Име на отбор';
                fieldkey = 'name';
                break;
            case 2:
                field = 'Статистика (М-П-З-Р)';
                fieldkey = 'stats';
                break;
            case 3:
                field = 'Голова разлика';
                fieldkey = 'goals';
                break;
            case 4:
                field = 'Точки';
                fieldkey = 'points';
                break;
        }

        var name = prompt('Сменете '+field+':', value);
        if(name == null) {
            return;
        }

        var datadata = {};

        datadata[fieldkey] = name;

        var data = {
            action: 'update',
            table: 'team',
            data: datadata,
            where: {
                id: id,
            }
        };

        var post = "";

        var i=0;
        $.each(data, function(index, val) {
            if (i !== 0) {
                post += "&";
            }
            var k=0;
            if($.isPlainObject(val)) {
                $.each(val, function(index2, val2) {
                    if (k !== 0) {
                        post += "&";
                    }
                    post += index + "[" + index2 + "]" + "=" + val2;
                    k++;
                });
            } else {
                post += index + "=" + val;
            }
            i++;
        });

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                console.log(data);
                $(ths).html(name);
            },
            error:  function(data)
            {
                console.log(data);
            }
        });
    });

    //Teams Delete
    $( "table tfoot.delete" ).droppable({
      drop: function( event, ui ) {

        var name = $('td:nth(1)', ui.draggable).html();
        var id = $(ui.draggable).attr('id').replace('row-','');

        if (!confirm('Искате да изтриете ' + name + '?')) {
            return;
        }

        var resultSpan = $( this )
          .find( "td span.result" );

        var data = {
            action: 'update',
            table: 'team',
            data: {
                hidden: 1
            },
            where: {
                id: id,
            }
        };

        var post = "";

        var i=0;
        $.each(data, function(index, val) {
            if (i !== 0) {
                post += "&";
            }
            var k=0;
            if($.isPlainObject(val)) {
                $.each(val, function(index2, val2) {
                    if (k !== 0) {
                        post += "&";
                    }
                    post += index + "[" + index2 + "]" + "=" + val2;
                    k++;
                });
            } else {
                post += index + "=" + val;
            }
            i++;
        });

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                $(ui.draggable).fadeOut();
                resultSpan.append( document.createTextNode(name + " е изтрит! ") );
            }
        });
      }
    });

    //Teams Sort
    $('table tbody').sortable({
        // Only make the .panel-heading child elements support dragging.
        // Omit this to make then entire <li>...</li> draggable.
        handle: 'td:first-child', 
        update: function() {

            var action = "tablesort";
            var table = "team";
            //var key = "gid";

            var info = $(this).sortable('toArray');
            //var id = $(this).parent().attr('id');

            var post = "table=" + table;
            post += "&action="+action;
            //post += "&key="+key;
            //post += "&id="+id.replace("table-","");

            $(info).each(function(index, val){
                post += "&sort[" + index + "]=" + val.replace("row-","");
            });

            $.ajax ({
                type: "POST",
                url: "ajax.php",
                data: post,
                dataType: "json",
                cache: false,
                success: function(data)
                {
                    console.log(data);
                }
            });

            $('td:first-child',$(this)).each(function(index) {
                $(this).html(index+1);
            });
        }
    });

    //Teams Create
    $('.team-add-button').click(function() {
        var namefield = $(this).parent().prev();
        var name = $(namefield).val();
        var table = $(this).closest('table');
        var gid = table.parent().attr('id').replace('panel-','');

        var tbody = $('tbody',table);
        var count = $('tr',tbody).length;

        var data = {
            action: 'insert',
            table: 'team',
            action2: 'insert',
            data: {
                name: name,
                gid: gid,
                sort: (count+1)
            }
        };

        var post = "";

        var i=0;
        $.each(data, function(index, val) {
            if (i !== 0) {
                post += "&";
            }
            var k=0;
            if($.isPlainObject(val)) {
                $.each(val, function(index2, val2) {
                    if (k !== 0) {
                        post += "&";
                    }
                    post += index + "[" + index2 + "]" + "=" + val2;
                    k++;
                });
            } else {
                post += index + "=" + val;
            }
            i++;
        });

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                console.log(data);
                $(tbody).append( '<tr id="row-'+data.newid+'"><td>' + (count+1) + '<td>' + name + '</td><td>0-0-0-0</td><td>0</td><td>0</td></tr>' );
                $(namefield).val('');
            },
            error:  function(data)
            {
                console.log(data);
            }
        });

    });

    //Groups Sort
    $('div.tab-pane .panels').sortable({
        // Only make the .panel-heading child elements support dragging.
        // Omit this to make then entire <li>...</li> draggable.
        handle: '.panel-heading', 
        update: function() {
            var info = $(this).sortable('toArray');

            var action = "tablesort";
            var table = "group";
            //var key = "gid";

            var post = "table=" + table;
            post += "&action="+action;
            //post += "&key="+key;
            //post += "&id="+id.replace("table-","");

            $(info).each(function(index, val){
                post += "&sort[" + index + "]=" + val.replace("panel-","");
            });

            $.ajax ({
                type: "POST",
                url: "ajax.php",
                data: post,
                dataType: "json",
                cache: false,
                success: function(data)
                {
                    console.log(data);
                },
                error: function(data)
                {
                    console.log(data);
                }

            });
        }
    });

    //Delete Group
    $('.group-remove-button').click(function() {
        var group = $(this).parent().parent();
        var id = $(group).attr('id').replace('panel-','');
        var name = $.trim($(this).parent().children('.gtitle').text());

        if (!confirm('Искате да изтриете ' + name + '?')) {
            return;
        }

        var action = "delete";
        var table = "group";
        var key = "id";

        var post = "table=" + table;
        post += "&action="+action;
        post += "&key="+key;
        post += "&id="+id;

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                $(group).fadeOut();
            }
        });
    });

    //Group
    $('.group-add-button').click(function() {
        var tab = $(this).parent().parent().parent();
        var gid = tab.attr('id').replace('tab','');

        var namefield = $(this).parent().next();
        var name = $(namefield).val();

        var count = $('.panel',tab).length;
        var holder = $('.panels',tab);

        var data = {
            action: 'insert',
            table: 'group',
            data: {
                name: name,
                gid: gid,
                sort: (count+1)
            }
        };

        var post = "";

        var i=0;
        $.each(data, function(index, val) {
            if (i !== 0) {
                post += "&";
            }
            var k=0;
            if($.isPlainObject(val)) {
                $.each(val, function(index2, val2) {
                    if (k !== 0) {
                        post += "&";
                    }
                    post += index + "[" + index2 + "]" + "=" + val2;
                    k++;
                });
            } else {
                post += index + "=" + val;
            }
            i++;
        });

        $.ajax ({
            type: "POST",
            url: "ajax.php",
            data: post,
            dataType: "json",
            cache: false,
            success: function(data)
            {
                console.log(data);
                $(holder).append( 
                    '<div class="panel panel-default" id="panel-'+data.newid+'"><div class="panel-heading"><span class="glyphicon glyphicon-tower"></span><span class="gtitle">'+name+'</span><button class="btn btn-danger group-remove-button" type="button"><span class="glyphicon glyphicon-remove"></span></button><button class="btn btn-warning group-change-button" type="button"><span class="glyphicon glyphicon-pencil"></span></button></div><table class="table" id="table-'+data.newid+'"><thead><tr><th>№</th><th width="30%">Отбор</th><th><span class="more">(Мачове-Победи-Загуби-Равенства)</span><span class="less">(М-П-З-Р)</span></th><th><span class="more">(Голова Разлика)</span><span class="less">(ГР)</span></th><th><span class="more">(Точки)</span><span class="less">(Т)</span></th></tr></thead><tbody class="ui-sortable"></tbody><tfoot class="delete ui-droppable"><tr><td colspan="5">Преместете тук отбор за да го изтриете! <span class="result">ИНТЕР е изтрит! </span> <div class="input-group pull-right team-add"><input type="text" name="name" value="" placeholder="Име на отбор" class="team-name form-control"><span class="input-group-btn"><button class="btn btn-success team-add-button" type="button"><span class="glyphicon glyphicon-plus"></span></button></span></div><!-- /input-group --></td></tr></tfoot></table></div>'
                 );
                $(namefield).val('');
                removeEvents();
                addEvents();
            },
            error:  function(data)
            {
                console.log(data);
            }
        });

    });
};