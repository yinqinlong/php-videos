var Form = {

  messageBox : '#ServerMessageBox',
  
  callback : null,
  
  inFancybox : false,
  
  data : {},
  
  setCallback : function(callback) {
    this.callback = callback;
    return this;
  },

  submit : function(element) {
    
    function success(messages, data, redirect) {
      var html = '<div class="modal-content">'
               + '<div class="modal-body">'
               + '<h3 class="center">'+ messages +'</h3>'
               + '<p class="center">3秒后跳转至 '+ redirect +'</p>'
               + '<div class="center"><a class="btn btn-warning btn-big" href="'+ redirect +'"> 立即跳转… </a></div>'
               + '</div></div>'

      if(Form.inFancybox) {
        //setTimeout('(function(uri) {parent.jQuery.fancybox.close()})()', 3000);
        var args = $.toJSON(Form.data);
        eval('('+ Form.callback +'('+ args +')' +')');
        parent.jQuery.fancybox.close();
      } else {
        $.fancybox({
          'padding' : 0,
          'modal' : true,
          'topRatio': 0.2,
          'autoSize': false,
          'width': '400px',
          'height': '147px',
          'content': html,
        });

        setTimeout('(function(uri) {location.href = uri;})("'+ redirect +'")', 3000);
      }
    };


    //  Warning: 'alert alert-block';
    //  Error: 'alert alert-error alert-block';
    //  Info: 'alert alert-info alert-block';
    //  Success: 'alert alert-success alert-block';
    function failed(messages, data, redirect) {
      $(Form.messageBox).html('');

      $(Form.messageBox).removeClass('hide');
      $(Form.messageBox).addClass('alert alert-danger alert-dismissable');
      $(Form.messageBox).append('<a class="close" href="#" onclick="$(this).parent().hide();">×</a>');
      $(Form.messageBox).append('<h4 class="alert-heading">Error!</h4>');

      var ul = $('<ul></ul>');
      for(var i = 0; i < messages.length; i++) {
        ul.append('<li>'+ messages[i] +'</li>');
      }
      $(Form.messageBox).append(ul);
      $(Form.messageBox).show();
    }
    
    function response(result, status) {
      if(status !== 'success') {
        $(Form.messageBox).find('h4').html('操作失败');
        return false;
      }

      result = eval('('+ result +')');

      if(result.code == 0) {
        failed(result.messages, result.data, result.redirect);
      }

      if(result.code == 1) {
        success(result.messages, result.data, result.redirect);
      }
    };
    
    this.data = $(element).serializeArray();
    
    $(Form.messageBox).hide();
    $(element).ajaxSubmit({
      success : response,  // post-submit callback 
      dataType : null,     // 'xml', 'script', or 'json' (expected server response type)
      timeout : 3000,
      //callback : callback
      //target : Form.messageBox,  // target element(s) to be updated with server response 
      //url : $(this).action,      // override for form's 'action' attribute 
      //type : 'post',             // 'get' or 'post', override for form's 'method' attribute 
      //clearForm: true            // clear all form fields after successful submit 
      //resetForm: true            // reset the form after successful submit 
    }); 
    return false;
  }

};
