$(document).ready(function(){
	$('input.new-todo').on('keyup',function (event) {
        if (event.keyCode == '13' && $(this).val() != '') {
            sendToDo(this);
        }
	});

    $('ul.filters a').on('click',function () {
        getListTime($(this).html());
        return false;
    });

    $('#toggle-all').on('click',function () {
        var p = {};
        send('updateall',p,showUpdateMessage);
        $(this).prop('checked','')
    });

    $('.clear-completed').on('click',function () {
        var p = {};
        send('clear',p,showUpdateMessage);
    });
    getListTime($('#info').data('type'));
});

$(document).on('click','.todo-list input.toggle', function(){
    var p = {};
    p.status = $(this).prop('checked')?'1':'0';
    p.id = $(this).parents('li').data('id');
    send('update',p,showUpdateMessage);
});


$(document).on('click','.todo-list button.destroy', function(){
    var p = {};
    p.id = $(this).parents('li').data('id');
    send('remove',p,showUpdateMessage);
});


$(document).on('dblclick','.todo-list input.noEdit', function(){
    $(this).prop('readonly','');
    $(this).removeClass('noEdit');
    $(this).addClass('Edit');
});

$(document).on('keyup','.todo-list input.Edit', function(){
    if (event.keyCode == '13' && $(this).val() != '') {
        $(this).prop('readonly','readonly');
        $(this).addClass('noEdit');
        sendToDo(this);
    }
});

function getListTime(type) {
    if($('#info').data('time') == 0 || $('#info').data('type') != type){
        getList(type);
    }else {
        var p = {};
        p.type = type;
        $('#info').data('process','1');
        send('timelist', p, timeControl);
    }
}

function timeControl(data) {
    if($('#info').data('time') == data.time)
    {
        $('#info').data('process','0');
    }else{
        getList($('#info').data('type'));
    }
}

function getList(type) {
    var p = {};
    p.type = type;
    $('#info').data('process','1');
    $('#info').data('type',type);
    send('list',p,showList);
}

function showList(data) {
    $('#info').data('process','0');
    $('#info').data('time',data.time);
    $('.todo-list').html('');
    $('.main').hide();
    $('.clear-completed').hide();
    data.list.forEach(showItem);
    $('.todo-count > strong').html(data.left);
}

function showItem(item) {
    $('.main').show();
    var s =
        '<li class="!class!" data-id="!id!">\n' +
        '   <div class="view">\n' +
        '       <input class="toggle" type="checkbox" !checked!>\n' +
        '       <input readonly class="noEdit" value="!target!">\n' +
        '       <button class="destroy"></button>\n' +
        '   </div>\n' +
        '</li>';
    if(item.status == 1) {
        s = s.replace('!class!', 'completed').replace('!checked!','checked');
        $('.clear-completed').show();
    }else{
        s = s.replace('!class!', '').replace('!checked!','');
    }
    s = s.replace('!target!', item.target).replace('!id!', item.id);
    $('.todo-list').append(s);
}

function sendToDo(obj) {
    var p = {};
    p.message = $(obj).val();
    if ($(obj).parents('li').data('id')) {
        p.id = $(obj).parents('li').data('id');
    }
	send('sendtodo',p,showSendMessage);
    $('input.new-todo').val('');
}

function send(url,data,collback) {
    $.ajax({
        url: '?r=ajax/' + url,
        data : data,
        dataType : "json",
        success: collback,
		error:errorMessage
    });
}

function showSendMessage() {
    showMessage('Send ToDo.');
    getListTime('All');
}

function showUpdateMessage() {
    showMessage('Update ToDo.');
    getListTime($('#info').data('type'));
}

function errorMessage() {
    showMessage('Server is not connected.');
}

function showMessage(text) {
    $('#message').html(text);
    $('#message').show().animate({'opacity':'0'}, 1000,function() {
        $('#message').css('opacity','100');
        $(this).hide();
    });
}

function emptyMessage() {
    
}

setInterval  (function(){
    if($('#info').data('process') == 1){
        return false;
    }
    getListTime($('#info').data('type'));
}, 1000);