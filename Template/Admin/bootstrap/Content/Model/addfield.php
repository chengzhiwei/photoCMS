<script>
    $(function () {
        $('#field_type').change(function () {
            if ($(this).val() == 'radio' || $(this).val() == 'checkbox')
            {
                $('#field_val').show(400);
            }
            else
            {
                $('#field_val').hide();
            }
        });
    });</script>
<div class="page-content">
    <div class="page-header">
        <h1>

            <small>
                <i class="icon-double-angle-right"></i>
                <?php echo L('ADD_FIELD'); ?>
            </small>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form role="form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 字段名 </label>

                    <div class="col-sm-9">
                        <input type="text" name="title" id="title" class="col-xs-10 col-sm-5" placeholder="字段名 ">
                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-1" class="col-sm-3 control-label no-padding-right"> 字段 </label>

                    <div class="col-sm-9">
                        <input type="text" id="fieldname"  name="fieldname" class="col-xs-10 col-sm-5" placeholder="字段 ">
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="space-4"></div>
                <div class="form-group">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">字段类型</label>

                    <div class="col-sm-9">
                        <select id="field_type" name="type">
                            <option value="text">单行文本</option>
                            <option value="textarea">多行文本</option>
                            <option value="editor">编辑器</option>
                            <option value="thumb">缩略图</option>
                            <option value="multithumb">组图</option>
                            <option value="singleupload">单文件上传</option>
                            <option value="moreupload">多文件上传</option>
                            <option value="radio">单选框</option>
                            <option value="checkbox">多选框</option>
                        </select>
                    </div>
                </div>
                <div id="field_val" class="form-group" style="display: none">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">字段值</label>

                    <div class="col-sm-9">
                        <textarea name="fieldvalue" class="col-xs-10 col-sm-5"></textarea>

                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">允许为空</label>

                    <div class="col-sm-9">
                        <input type="checkbox" value="1" name="isnull" class="chkall ace  ace-checkbox-2" autocomplete="off">
                        <span class="lbl"></span>

                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">附加属性</label>

                    <div class="col-sm-9">
                        <input type="text" name='tackattr' class="col-xs-10 col-sm-5" placeholder="">

                    </div>
                </div>
                <div class="form-group">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">常用正则</label>

                    <div class="col-sm-9">
                        <input type="text" class="col-xs-10 col-sm-4" id="reg" name="reg" placeholder=""> 
                        <select class="col-xs-10 col-sm-1  sel_reg">
                            <option value="">请选择</option>
                            <option value="^[1-9]\d*$">数字</option>
                            <option value="\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*">电子邮件</option>
                            <option value="1[0-9]{10}">手机</option>
                        </select>

                    </div>
                </div>

                <div class="form-group">
                    <label for="form-field-2" class="col-sm-3 control-label no-padding-right">自定义控件</label>

                    <div class="col-sm-9">
                        <a data-toggle="modal" data-target=".bs-example-modal-lg" href="#" class=" btn btn-xs btn-info" style=" margin-top: 1px">
                            <b>选择控件</b>
                        </a>
                        <input type="hidden" value="" name='plugin' id='plugin' />
                        <strong name='plugintxt'  id='plugintxt' class="  " placeholder="" ></strong>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $mid ?>" name="mid"/>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-info">
                            <i class="icon-ok bigger-110"></i>
                            提交
                        </button>

                        &nbsp; &nbsp; &nbsp;
                        <button type="reset" class="btn">
                            <i class="icon-undo bigger-110"></i>
                            重置
                        </button>
                    </div>
                </div>

                <div class="hr hr-24"></div>



            </form>


        </div>
    </div>
</div>









<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button data-dismiss="modal" class="close close_js" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 id="myLargeModalLabel" class="modal-title">配置插件</h4>
            </div>
            <div class="modal-body" >
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="widget-header">
                        <h4 class="lighter smaller">
                            <i class="icon-rss orange"></i>
                            请选择控件
                        </h4>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main padding-4">
                            <div class="tab-content padding-8 overflow-visible">
                                <div class="tab-pane active" >

                                    <div class="tabbable tabs-left">
                                        <ul id="myTab" class="nav nav-tabs vhooklist">
                                            <?php
                                            foreach ($pluginlist as $k => $p)
                                            {
                                                ?>
                                                <li rel="<?php echo $p['id'] ?>"  class="<?php echo $k == 0 ? 'active' : '' ?>">
                                                    <a href="#profile<?php echo $p['id'] ?>" data-toggle="tab">
                                                        <?php echo $p['name']; ?>
                                                    </a>
                                                </li>
                                            <?php }
                                            ?>

                                        </ul>
                                        <div class="tab-content">
                                            <?php
                                            foreach ($pluginlist as $k => $p)
                                            {
                                                ?>
                                                <div class="tab-pane <?php echo $k == 0 ? 'active' : '' ?>" id="profile<?php echo $p['id'] ?>"></div>
                                            <?php }
                                            ?>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- /widget-main -->
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button  data-dismiss="modal" class="btn btn-primary sure_js" onclick="setplugin()" type="button">确定</button>
                <button data-dismiss="modal" class="btn btn-default close_js"  type="button">取消</button>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>

<script>
    $(function () {
        pid = $('.vhooklist').find('li').first().attr('rel');
        getvhook(pid, 'profile' + pid);
        $('.vhooklist').find('li').find('a').click(function () {
            var pid = $(this).parent().attr('rel');
            getvhook(pid, 'profile' + pid);
        });
    })
    function getvhook(pid, div)
    {

        $.ajax({
            type: "post",
            url: "<?php echo U('Content/Model/getvook'); ?>",
            data: {pid: pid},
            dataType: "json",
            success: function (data) {
                var html = '';
                $.each(data, function (i, item) {
                    html += '<lable class="col-sm-4 chk_lbl">';
                    html += '<input type="radio"  plugin="' + item.path + '/' + item.method + '" plugintxt="' + item.title + '"  class="ace " name="plugin_radio">';
                    html += '<span class = "lbl" > ' + item.title + ' </span>';
                    html += '</lable>';
                });
                $('#' + div).html(html);
            }

        });
    }

    $(function () {
        $('.sel_reg').change(function () {
            $('#reg').val($(this).val());
        });
    })

    function setplugin()
    {

        obj = $('input[name="plugin_radio"]:checked');
        $('#plugin').val(obj.attr('plugin'));
        $('#plugintxt').html(obj.attr('plugintxt'));

    }

</script>