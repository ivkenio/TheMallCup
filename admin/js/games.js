$(function() {
    addEvents();
});
    
var removeEvents = function() {
    $('.game-add-button').off('click');
    $('.game-delete-button').off('click');
    $('tbody tr td').off('click');
}

var addEvents = function() {


    //Field Edit 
    $( "tbody tr td").click(function() {
        
        var index = $( this ).index();
        if(index < 2 || index > 4) return;
        
        var tr = $(this).parent();
        var id = $(tr).attr('id').replace('row-','');
        var ths = $(this);
        var value = $.trim($(this).text().replace(' ч.',''));

        var field = '';

        switch (index) {
            case 2:
                field = 'Дата';
                fieldkey = 'date';
                break;
            case 3:
                field = 'Час';
                fieldkey = 'time';
                break;
            case 4:
                field = 'Резултат (Пример - 1:0)';
                fieldkey = 'score';
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
            table: 'game',
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
                if(fieldkey == 'time') {
                    $(ths).html(name + " ч.");
                } else {
                    $(ths).html(name);
                }
            },
            error:  function(data)
            {
                console.log(data);
            }
        });
    });
    
    //Delete Game
    $( ".game-delete-button").click(function() {
        var tr = $(this).parent().parent();
        var id = $(tr).attr('id').replace('row-','');
        var gamenames = $('td:nth(1)',tr).text();

        if (!confirm('Искате да изтриете мача ' + gamenames + '?')) {
            return;
        }
        
        var data = {
            action: 'delete',
            table: 'game',
            key: 'id',
            id: id
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
                $(tr).fadeOut();
                console.log(data);
            },
            error:  function(data)
            {
                console.log(data);
            }
        });
    });

    //Create Game
    $( ".game-add-button").click(function() {
        var tr = $(this).parent().parent();
        var tbody = $(tr).parent().prev();
        var panel = $(tr).parent().parent().parent();
        var holder = $(tr).parent().parent().children('tbody');
        console.log(tbody.html());
        var count = $(tbody).children('tr').length;

        //var id = $(tr).attr('id').replace('row-','');
        var hteamf = $('select[name=hteamid]',tr);
        var vteamf = $('select[name=vteamid]',tr);
        var datef = $('input[name=date]',tr);
        var timef = $('input[name=time]',tr);

        //var id = $(tr).attr('id').replace('row-','');
        var hteam = $(hteamf).val();
        var vteam = $(vteamf).val();
        
        if(hteam == vteam) {
            alert('Не може един отбор да играе срещу себе си!!!');
            return;
        }
        
        var hteamn = $(hteamf).children('option:selected').text();
        var vteamn = $(vteamf).children('option:selected').text();
        var date = $(datef).val();
        var time = $(timef).val() + ":00";
        var gid = $(panel).attr('id').replace('panel-','');

        var data = {
            action: 'insert',
            table: 'game',
            data: {
                gid: gid,
                h_team_id: hteam,
                v_team_id: vteam,
                date: date,
                time: time,
                score: '',
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
                var id = data.newid;
                $(holder).append( '<tr id="row-'+id+'"> <td>'+(count+1)+'</td> <td>'+hteamn+' - '+vteamn+'</td> <td>'+date+'</td> <td>'+$(timef).val()+' ч.</td> <td></td> <td><button class="btn btn-danger game-delete-button" type="button"><span class="glyphicon glyphicon-trash"></span></button></td> </tr>' );
                
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