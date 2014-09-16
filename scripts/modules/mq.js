var Mq = {

  addQueue : function() {

    var queue_id = $(".queues:last").attr("id")

    var new_queue_id = parseInt(queue_id) + 1

    var html = '<div class="queues" id="' + new_queue_id + '">'
             + '<input type="hidden" name="mq_queues[' + new_queue_id + '][mq_queue_id]" value="" />'
             + '<div class="form-group">'
             + '<label class="col-sm-2 control-label">队列名称</label>'
             + '<div class="col-sm-5">'
             + '<input class="form-control" type="text" name="mq_queues[' + new_queue_id + '][name]" value="" />'
             + '</div>'
             + '</div>'
             + '<div class="form-group">'
             + '<label class="col-sm-2 control-label">队列描述</label>'
             + '<div class="col-sm-5">'
             + '<input class="form-control" type="text" name="mq_queues[' + new_queue_id + '][description]" value="" />'
             + '</div>'
             + '</div>'
             + '<div class="form-group">'
             + '<label class="col-sm-2 control-label">回调接口</label>'
             + '<div class="col-sm-5">'
             + '<input class="form-control" type="text" name="mq_queues[' + new_queue_id + '][callback]" value="" />'
             + '</div>'
             + '</div>'
             + '<div class="form-group">'
             + '<label class="col-sm-2 control-label"></label>'
             + '<span class="btn btn-danger" onclick="Mq.deleteQueue(' + new_queue_id + ')">删除队列</span>'
             + '</div>'
             + '<hr>'
             + '</div>'

    $(".queues:last").after(html)
  },

  deleteQueue : function(queue_id) {
    var queues_length = $(".queues").length
    if(queues_length == 1) {
      var html = '<div class="modal-content">'
               + '<div class="modal-body">'
               + '<button type="button" class="close" onclick="$.fancybox.close();"><span aria-hidden="true">×</span></button>'
               + '<h4>至少保留一个队列</h4>'
               + '</div>'
               + '<div class="modal-footer">'
               + '<button class="btn btn-primary" onclick="$.fancybox.close();">确定</button>'
               + '</div></div>'
    } else {
      var html = '<div class="modal-content">'
               + '<div class="modal-body">'
               + '<button type="button" class="close" onclick="$.fancybox.close();"><span aria-hidden="true">×</span></button>'
               + '<h4>确定删除这个队列吗？</h4>'
               + '</div>'
               + '<div class="modal-footer">'
               + '<button class="btn btn-default" onclick="$.fancybox.close();">取消</button>'
               + '<button class="btn btn-danger" onclick="Mq.delete(\''+queue_id+'\')">确定</button>'
               + '</div></div>'
    }

    $.fancybox({
      'padding' : 0,
      'topRatio': 0.2,
      'autoSize': false,
      'width': '400px',
      'height': '136px',
      'closeBtn' : false,
      'content': html,
    });
    return false;
  },

  delete : function(queue_id) {
  	$("#"+queue_id).remove();
    $.fancybox.close();
  },

};
