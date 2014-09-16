var User = {
  bindFancybox : function() {
    $('[name="edit"]').click(function() {
      $.fancybox({
        'padding' : 0,
        'type' : 'iframe',
        'closeBtn' : false,
        'href' : $(this).attr('data-link')
      });
    });
    $('[name="category"]').click(function() {
      $.fancybox({
        'padding' : 0,
        'autoSize': false,
        'width' : '400px',
        'height' : '500px',
        'type' : 'iframe',
        'closeBtn' : false,
        'href' : $(this).attr('data-link')
      });
    });
  },

  reject : function(text, redirect) {
    var html = '<div class="modal-content">'
             + '<div class="modal-body">'
             + '<button type="button" class="close" onclick="$.fancybox.close();"><span aria-hidden="true">×</span></button>'
             + '<h4>'+text+'</h4>'
             + '<div class="row">'
             + '<div class="col-sm-8"><div class="input-group">'
             + '<span class="input-group-addon">*原因</span>'
             + '<select class="form-control" id="remark" name="remark" onclick="User.changeRemark()">'
             + '<option value="机构信息不符合要求">机构信息不符合要求</option>'
             + '<option value="视频不符合要求">视频不符合要求</option>'
             + '<option value="custom">自定义</option>'
             + '</select>'
             + '</div></div>'
             + '<div class="col-sm-4">'
             + '<input class="form-control hide" id="customRemark" name="remark" type="text" placeholder="自定义原因"></value>'
             + '</div>'
             + '</div>'
             + '</div>'
             + '<div class="modal-footer">'
             + '<button class="btn btn-default" onclick="$.fancybox.close();">取消</button>'
             + '<button class="btn btn-danger" onclick="User.clickReject(\''+redirect+'\')">确定</button>'
             + '</div></div>'
    $.fancybox({
      'padding' : 0,
      'topRatio': 0.2,
      'autoSize': false,
      'width': '400px',
      'height': '170px',
      'closeBtn' : false,
      'content': html,
    });
    return false;
  },
  clickReject : function(link) {
    var defaultValue = $('#remark option:selected').val();
    var customValue = $.trim($('#customRemark').val());

    if(defaultValue == 'custom') {
      var remark = customValue
    } else {
      var remark = defaultValue
    }

    if(remark == '') {
      alert('原因不能为空')
    } else {
      link += '&remark=' + remark
      $.ajax({
        url : link,
      }).done(function(response, status) {
        $('body').html(response)
      });
    }
  },
  changeRemark : function() {
    var value = $("#remark option:selected").val();
    if(value == 'custom') {
      $("#customRemark").removeClass("hide")
    } else {
      $("#customRemark").addClass("hide")
      $("#customRemark").val("")
    }
  },

  newCategory : function() {
    $('#CategoryRow').removeClass('hide');
    $('#AddCategoryRow').addClass('hide');
    $('#CategoryMessageBox').addClass('hide');
  },
  cancelCategory : function() {
    $('#CategoryRow').addClass('hide');
    $('#AddCategoryRow').removeClass('hide');
  },
  addCategory : function() {
    var categoryName = $("#CategoryName").val();
    $.ajax({
      type:"POST",
      url:"/shijiao/user/addCategory",
      data:{name: categoryName},
      datatype: "json",
      success:function(data){
        var data = jQuery.parseJSON(data);
        if(data.code == 1) {
          var newCategory = '<div class="row" id="CategoryList">';
          newCategory += '<div class="col-sm-8 col-sm-offset-2">';
          newCategory += '<label><input type="radio" name="category_id" value="' + data.data.category_id + '">' + data.data.name + '</label>';
          newCategory += '</div></div>';
          $(newCategory).insertBefore('#AddCategoryRow');
          $('#CategoryRow').addClass('hide');
          $('#AddCategoryRow').removeClass('hide');
        }
        if(data.code == 0) {
          $('#CategoryMessageBox').removeClass('hide');
          $('#CategoryMessageBox').empty();
          var categoryError = '<div class="alert alert-warning alert-dismissable">';
          categoryError += '<h4 class="alert-heading">'+data.messages+'</h4>';
          categoryError += '</div>';
          $('#CategoryMessageBox').append(categoryError);
        }
      },
    });
  },
};
