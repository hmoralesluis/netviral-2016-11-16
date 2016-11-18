var Codes = function () {

    var count_messages = 0;
    var count_notifications = 0;

    return {
        init: function () {
            if ($.cookie('first_level') != null && $.cookie('first_level') != '') {
                var li = $('#' + $.cookie("first_level"));
                li.addClass('active');
                var span = $('<span class="selected"></span>');
                li.children('a').append(span);

            }

            if ($.cookie('second_level') != null && $.cookie('second_level') != '') {
                var a = $('#' + $.cookie('second_level') + '');
                a.parent('li').addClass('active');
                var ul = a.next();
                if (ul.is('.sub-menu')) {
                    ul.attr('style', 'display:block').addClass('menu-open');
                }
            }

            if (($.cookie('third_level') != null && $.cookie('third_level') != '')) {
                var a = $('#' + $.cookie('third_level') + '');
                a.parent('li').addClass('active');
            }

            $('.not-required').removeAttr('required');
        },

        initOptions: function () {
            $('li.treeview > a').bind('click', function () {
                var $this = $(this);
                var checkElement = $this.next();
                if (checkElement.is('.sub-menu')) {
                    $.cookie("levels", [$this.parent("li").attr('id')], {expires: 1});
                } else {
                    $.cookie("first_level", $this.parent("li").attr('id'), {expires: 1});
                    $.removeCookie('second_level');
                    $.removeCookie('third_level');
                }
            });

            $('.sub-menu li a').bind('click', function () {
                var $this = $(this);
                var checkElement = $this.next();
                if (checkElement.is('.sub-menu')) {
                    var levels = [$.cookie('levels')];
                    levels.push($this.attr('id'));
                    $.cookie('levels', levels, {expires: 1});
                } else {
                    var levels = $.cookie('levels');
                    levels = levels.split(',');
                    if (levels.length == 1) {
                        $.cookie('second_level', $this.attr('id'));
                        $.cookie('first_level', levels[0]);
                    } else {
                        $.cookie('third_level', $this.attr('id'));
                        $.cookie('second_level', levels[1]);
                        $.cookie('first_level', levels[0]);
                    }
                }
            });
        },

        showMessage: function (title, message) {
            setTimeout(function () {
                var unique_id = $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: title,
                    // (string | mandatory) the text inside the notification
                    text: message,
                    // (bool | optional) if you want it to fade out on its own or just sit there
                    sticky: true,
                    // (int | optional) the time you want it to be alive for before fading out
                    time: '',
                    // (string | optional) the class name you want to apply to that specific message
                    class_name: 'my-sticky-class'
                });

                // You can have it return a unique id, this can be used to manually remove it later using
                setTimeout(function () {
                    $.gritter.remove(unique_id, {
                        fade: true,
                        speed: 'slow'
                    });
                }, 6000);
            }, 1);
        },

        updateSales: function (id, url) {
            $.ajax({
                url: url,
                data: {'id': id},
                type: 'POST',
                dataType: 'json',
                success: function (data, status, xhr) {
                    var json_d = data;
                    $('#daily-sale').text(json_d.daily.length);
                    $('#weekly-sale').text(json_d.weekly.length);
                    $('#earning').text('$' + json_d.earning);
                }
            });
        },

        updateMessagesNotification: function (id, url) {
            $.ajax({
                url: url,
                data: {'id': id},
                type: 'POST',
                dataType: 'json',
                success: function (data, status, xhr) {
                    var json_d = data;
                    if(json_d[id].amount != 0){
                        var amount_area = $('#nofitication_message_amount_area');
                        var span = $('#nofitication_message_amount');
                        span.remove();
                        var notification_message_amount = $('<span></span>').text(json_d[id].amount);
                        notification_message_amount.attr('id', "notification_messages_amount").addClass("badge");
                        amount_area.append(notification_message_amount);
                        var notifications_list = $('.inbox');

                        if(json_d[id].amount == 1){
                            $('#notification-message-title').text('Usted tiene  ' + json_d[id].amount + ' mensaje');
                        } else {
                            $('#notification-message-title').text('Usted tiene  ' + json_d[id].amount + ' mensajes');
                        }


                        for (var m in json_d[id].messages) {

                            var li = $('<li></li>');
                            var a = $('<a></a>');
                            var span_photo = $('<span></span>').addClass('photo');
                            var img = $('<img/>').attr('src', json_d[id].messages[m].photo);
                            var span_subject = $('<span></span>').addClass('subject');
                            var span_from = $('<span></span>').addClass('from').text(json_d[id].messages[m].sender);
                            var span_time = $('<span></span>').addClass('time').text(json_d[id].messages[m].time);
                            var span_message = $('<span></span>').addClass('message').text(json_d[id].messages[m].topic);
                            span_photo.append(img);
                            span_subject.append(span_from);
                            span_subject.append(span_time);
                            a.append(span_photo);
                            a.append(span_subject);
                            a.append(span_message);
                            li.append(a);

                            notifications_list.append(li);
                        }

                        var li_external = $('<li></li>').addClass('external');
                        var all_message = $('<a></a>').text('Ver todos los mensajes');
                        var i = $('<i></i>').addClass("m-icon-swapright");
                        all_message.append(i);
                        li_external.append(all_message);

                        notifications_list.append(li_external);

                        $('#message-info .number').text(json_d[id].amount);

                        if (json_d[id].amount == 1){
                            $('#message-info .desc').text('Nuevo Mensaje');
                        }

                        if(count_messages < json_d[id].amount ){
                            var count_new_messages = parseInt(json_d[id].amount) - parseInt(count_messages);
                            $.extend($.gritter.options, {
                                position: 'top-left'
                            });

                            if (count_new_messages == 1){
                                var Textomensaje = 'Usted tiene ' + count_new_messages + ' nuevo mensaje'
                            }else {
                                var Textomensaje = 'Usted tiene ' + count_new_messages + ' nuevos mensajes'
                            }

                            var unique_id = $.gritter.add({
                                title: 'Bandeja de entrada',
                                text: Textomensaje ,
                                image1: json_d[id].image,
                                sticky: true,
                                time: '',
                                class_name: 'my-sticky-class'
                            });

                            $.extend($.gritter.options, {
                                position: 'top-left'
                            });

                            setTimeout(function () {
                                $.gritter.remove(unique_id, {
                                    fade: true,
                                    speed: 'slow'
                                });
                            }, 5000);

                            $('#header_inbox_bar').pulsate({
                                color: "#dd5131",
                                repeat: 5
                            });
                        }

                        count_messages = json_d[id].amount;
                    }
                }
            });
        },

        updateGeneralNotification: function (id, url) {
            $.ajax({
                url: url,
                data: {'id': id},
                type: 'POST',
                dataType: 'json',
                success: function (data, status, xhr) {
                    var json_d = data;
                    if(json_d[id].amount != 0){
                        var amount_area = $('#nofitication_amount_area');
                        var span = $('#nofitication_amount');
                        span.remove();
                        var notification_amount = $('<span></span>').text(json_d[id].amount);
                        notification_amount.attr('id', "notification_amount").addClass("badge");
                        amount_area.append(notification_amount);
                        var notifications_list = $('ul.notification');

                        $('#notification-title').text('Usted tiene  ' + json_d[id].amount + ' notificaciones');

                        var counter = 1;
                        for (var n in json_d[id].notifications) {
                            if(counter < 6){
                                var li = $('<li></li>');
                                var a = $('<a></a>');
                                var span_label = $('<span></span>').addClass('label ' + json_d[id].notifications[n].label);
                                var icon = $('<i></i>').addClass(json_d[id].notifications[n].icon);
                                var span_time = $('<span></span>').addClass('time').text(' - ' + json_d[id].notifications[n].time);
                                span_label.append(icon);
                                a.append(span_label);
                                a.append(json_d[id].notifications[n].title);
                                a.append(span_time);
                                li.append(a);

                                notifications_list.append(li);
                            }
                            counter++;
                        }

                        $('#user-info .number').text(json_d[id].types2);
                        $('#sale-info .number').text(json_d[id].types3);
                        $('#product-info .number').text(json_d[id].types4);
                        $('#ganancias').text(json_d[id].ganancias);

                        if (json_d[id].types2 == 1){
                            $('#user-info .desc').text('Nuevo Usuario');
                        }

                        if (json_d[id].types3 == 1) {
                            $('#sale-info .desc').text('Nueva Venta');
                        }

                        if (json_d[id].types4 == 1) {
                            $('#product-info .desc').text('Nuevo Contenido');
                        }

                        var li_external = $('<li></li>').addClass('external');
                        var all_notifications = $('<a></a>').text('Ver todos las notificaciones');
                        var i = $('<i></i>').addClass("m-icon-swapright");
                        all_notifications.append(i);
                        li_external.append(all_notifications);

                        notifications_list.append(li_external);

                        //$('#user-info .number').text(json_d[id].amount);

                        if(count_notifications < json_d[id].amount ){
                            var count_new_notifications = parseInt(json_d[id].amount) - parseInt(count_notifications);
                            $.extend($.gritter.options, {
                                position: 'top-left'
                            });

                            var unique_id = $.gritter.add({
                                title: 'Notificaciones',
                                text: 'Usted tiene ' + count_new_notifications + ' nuevas notificaciones',
                                image1: json_d[id].image,
                                sticky: true,
                                time: '',
                                class_name: 'my-sticky-class'
                            });

                            setTimeout(function () {
                                $.gritter.remove(unique_id, {
                                    fade: true,
                                    speed: 'slow'
                                });
                            }, 5000);

                            $.extend($.gritter.options, {
                                position: 'top-left'
                            });

                            $('#header_notification_bar').pulsate({
                                color: "#66bce6",
                                repeat: 5
                            });
                        }

                        count_notifications = json_d[id].amount;
                    }
                }
            });
        },
    }
}();

