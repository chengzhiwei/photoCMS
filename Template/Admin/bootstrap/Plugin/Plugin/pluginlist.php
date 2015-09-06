<style>
    .profile-activity .tools{display:block;}

    .modal-content{border-radius:5px;}
    .modal-body {
        max-height: 800px;
    }fieldset{ padding-bottom: 20px;}
    .form-horizontal .control-label .chk_lbl{text-align:left}
</style>
<script>
    $(function () {
        $('#install_plugin').on('click', function () {
            $(this).html('loading');
        });
    });

</script>
<div class="page-content">
    <div class="page-header">
        <h1>

            <small>
                <i class="icon-double-angle-right"></i>
                插件列表
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="widget-body">
                <div class="widget-main padding-8">
                    <div  >
                        <div class="profile-feed" id="profile-feed-1" >

                            <?php
                            foreach ($plugin_arr as $k => $p)
                            {
                                ?>
                                <div class="profile-activity clearfix">
                                    <div>

                                        <img class="pull-left   no-hover" src="<?php echo __ROOT__ ?>/Template/Plugin/<?php echo (string) $p->plugin ?>/Res/thumb.png" />
                                        <a href="#" class="user"> <?php echo (String) $p->name; ?> </a>
                                        作者：<?php echo $p_arr['author'] ?> EMAIL：<a href="mailto"><?php echo $p_arr['contact'] ?></a>


                                        <div class="time">
                                            <?php echo (String) $p->desc; ?>
                                        </div>
                                    </div>

                                    <div class="tools action-buttons">
                                        <?php
                                        if (key_exists((string) $p->plugin, $plugin_install))
                                        {
                                            ?>
                                        <a  class="btn btn-xs btn-warning modal_btn" href="javascript:void(0)" title="" rel="<?php echo $plugin_install[(string) $p->plugin]['id'] ?>"  >
                                                配置
                                            </a>
                                            <a class="btn btn-xs btn-danger" href="javascript:uninstall('<?php echo (string) $p->plugin ?>')">
                                                卸载
                                            </a>
                                            <?php
                                        } else
                                        {
                                            ?>
                                            <a class="btn btn-xs btn-success" id="install_plugin" href="<?php echo U('Plugin/Plugin/install', array('plugin' => (String) $p->plugin)) ?>" >
                                                安装
                                            </a>
                                            <a class="btn btn-xs btn-danger" href="#">
                                                删除
                                            </a>
                                            <?php
                                        }
                                        ?>



                                    </div>
                                </div>
                            <?php }
                            ?>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<form id="configform">
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="myModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close close_js" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="myLargeModalLabel" class="modal-title">配置插件</h4>
                </div>
                <div style=" padding: 10px 20px 0 20px;color: green" >选中状态为启用</div>
                <div class="modal-body" >
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="widget-header">
                            <h4 class="lighter smaller">
                                <i class="icon-rss orange"></i>
                                百度编辑器
                            </h4>

                            <div class="widget-toolbar no-border">
                                <ul id="recent-tab" class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#siteplugin" data-toggle="tab">插件前台</a>
                                    </li>

                                    <li class="">
                                        <a href="#adminplugin" data-toggle="tab">插件后台</a>
                                    </li>

                                    <li class="">
                                        <a href="#vhookpane" data-toggle="tab">视图钩子</a>
                                    </li>
                                    <li class="">
                                        <a href="#bhookpane" data-toggle="tab">业务钩子</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main padding-4">
                                <div class="tab-content padding-8 overflow-visible">
                                    <div class="tab-pane active" id="siteplugin">
                                        <div class="tabbable tabs-left">
                                            <ul id="sitepluginTab" class="nav nav-tabs">



                                            </ul>

                                            <div class="tab-content" id="sitepluginTabinfo">



                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="adminplugin">
                                        <div class="tabbable tabs-left">
                                            <ul id="adminpluginTab" class="nav nav-tabs">

                                            </ul>

                                            <div class="tab-content" id="adminpluginTabinfo">


                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="vhookpane">

                                        <div class="tabbable tabs-left">
                                            <ul id="vhookTab" class="nav nav-tabs">

                                            </ul>

                                            <div class="tab-content" id="vhookTabinfo">


                                            </div>
                                        </div>


                                    </div>

                                    <div class="tab-pane" id="bhookpane">

                                        <div class="tabbable tabs-left">
                                            <ul id="bhookTab" class="nav nav-tabs">

                                            </ul>

                                            <div class="tab-content" id="bhookTabinfo">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" value="" name="pid" id="configpid" />
                <div class="modal-footer">
                    <button   class="btn btn-primary sure_js" type="button">确定</button>
                    <button data-dismiss="modal" class="btn btn-default close_js"  type="button">取消</button>
                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
</form>
<script>
    function parsePlgConfig(obj, Indextab, showtabid,type)
    {
        $('#' + Indextab).html('');
        $('#' + Indextab + 'info').html('');
        if (obj === null)
        {
            return;
        }

        var tabli = "";//tab
        var jscss = '';//jscss
        $.each(obj, function (i, items) {
            var active = '';
            if (i == 0)
            {
                active = 'active';
            }
            id=items.id;
            usejs = items.usejs;
            tabli += '<li  class="' + active + '"><a href="#' + showtabid + 'jscss' + i + '" data-toggle="tab">' + items.title + '</a></li>';
            jscss += '<div class="tab-pane ' + active + '" id="' + showtabid + 'jscss' + i + '"><div><u>JS</u></div><div>';
            $.each(items.js, function (i, jsitem) {
                if (jsitem)
                {
                    var checked = '';
                    if (usejs != null)
                    {
                        if (usejs.toString().indexOf(jsitem) > -1) {
                            checked = 'checked';
                        }
                    }
                    jscss += '<lable class="col-sm-6 chk_lbl">\n\
                                        <input type="checkbox" ' + checked + ' class="ace-checkbox-2 ace  " value="'+jsitem+'" name="'+type+'js'+id+'[]"> \n\
                                        <span class="lbl">' + jsitem + ' </span>\n\
                                    </lable>';
                }
            });
            jscss += '</div>';

            jscss += '<div style="clear:both"></div><div><u>CSS</u></div><div>';
            usecss = items.usecss;
            $.each(items.css, function (i, cssitem) {
                if (cssitem)
                {
                    var checked = '';
                    if (usecss != null)
                    {
                        if (usecss.toString().indexOf(cssitem) > -1) {
                            checked = 'checked';
                        }
                    }
                    jscss += '<lable class="col-sm-6 chk_lbl">\n\
                                        <input type="checkbox" ' + checked + '  class="ace-checkbox-2 ace  " value="'+cssitem+'" name="'+type+"css"+id+'[]"> \n\
                                        <span class="lbl">' + cssitem + ' </span>\n\
                                    </lable>';
                }
            });
            jscss += '</div></div>';
        });

        $('#' + Indextab).html(tabli);
        $('#' + Indextab + 'info').html(jscss);
    }

    $(function () {
        $('.modal_btn').click(function () {
            pid = $(this).attr('rel');
            $('#configpid').val(pid);
            $.ajax({
                type: 'POST',
                url: '<?php echo U('Plugin/Plugin/getconfigure'); ?>',
                data: {pid: pid},
                dataType: 'json',
                success: function (data) {
                    $('#myModal').modal('show');
                    /*****************前台插件******************/
                    parsePlgConfig(data.siteplugin, 'sitepluginTab', 'site','plg');
                    /*****************后台插件******************/
                    parsePlgConfig(data.adminplugin, 'adminpluginTab', 'admin','plg');
                    /*****************视图钩子******************/
                    parsePlgConfig(data.vhooklist, 'vhookTab', 'vhook','hook');
                    /*****************业务钩子******************/
                    parsePlgConfig(data.bhooklist, 'bhookTab', 'bhook','hook');
                    
                }

            });
        });
        $('.sure_js').click(function () {
            data = $("#configform").serialize();
            $.ajax({
                type: 'POST',
                url: '<?php echo U('Plugin/Plugin/doconfigure'); ?>',
                data: data,
                success: function (result) {
                    if(result!='1')
                    {
                        
                    }$('#myModal').modal('hide');
                }
            });
        });
    });



    function uninstall(file)
    {
        if (confirm('<?php echo L('IS_TRUE_UNINSTALL') ?>'))
        {
            window.location.href = '<?php echo __APP__ ?>?s=Plugin/Plugin/uninstall&file=' + file;
        }
    }

</script>