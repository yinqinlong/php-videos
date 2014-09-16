$(document).ready(function() {
  sourcesNum = new Array();
  sourcesCount = new Array();
  sceneCount = $('#scene_num').val();
  sceneNum = sceneCount - 1;
  for(var i = 0;i <= sceneNum;i ++) {
  	sourcesTotal = 0;
    for(var j = 0;j <= 3 ;j++){
      var sourcesLength = document.getElementsByName("sources["+i+"]["+j+"][definition]").length;
      if(sourcesLength){
        sourcesTotal ++;
      }
    }
    sourcesNum[i] = sourcesTotal - 1;
    sourcesCount[i] = sourcesTotal - 1;
  }
  optionObj = '';
  for(var clarityKey in clarity ){
    optionObj += '<option value="'+clarityKey+'" >'+clarity[clarityKey]+'</option>';
  }

  /*
  $("[type*='checkbox']").click(
    function() {
      sceneName = this.name;
      var checkBoxNum = sceneName.charAt(sceneName.indexOf('[')+1);
      checkedAttr = document.getElementById('scenes['+checkBoxNum+'][is_default]');
      console.log($(checkedAttr).attr('value'));
      if(checkedAttr.checked) {
        // console.log($(this).attr('value'));
        for(var i = 0;i < sceneNum;i++) {
          if(i == checkBoxNum || !document.getElementById('scenes['+i+'][is_default]')) continue;
          document.getElementById('scenes['+i+'][is_default]').checked = false;
          // document.getElementById('scenes['+i+'][is_default]').attr(value,0);
        }
      }
    })
*/

  $('#sub_data').click(
    function(){
      Form.submit(this.form);
    });
});

function addRow(addPointer) {
  var sceneRank = $(addPointer).attr('data-value');
  if(sourcesCount[sceneRank] >= 3) {
    return false;
  }
  sourcesNum[sceneRank] ++;
  sourcesCount[sceneRank] ++;
  var html = '<div class="padding-control" name = "sources_config"><div class="row"><div class="col-sm-3"><div class="input-group"><span class="input-group-addon">流类型</span><select class="form-control" name="sources['+sceneRank+']['+sourcesNum[sceneRank]+'][definition]" val="'+sceneRank+'"><option value="">请选择</option>'+optionObj+'</select></div></div><div class="col-sm-4"><div class="input-group"><span class="input-group-addon">流地址</span><input type="text" class="form-control" name="sources['+sceneRank+']['+sourcesNum[sceneRank]+'][address]" value=""><span class="input-group-addon pointer " onclick="deleteRow(this);" data-value="'+sceneRank+'"><i class="glyphicon glyphicon-minus" ></i></span></div></div></div><br></div>';
  $(html).insertAfter($(addPointer).parents(".panel-body").children(".padding-control").last());
}

function deleteRow(delRowObj) {
  var sceneRank = $(delRowObj).attr('data-value');
  if(sourcesCount[sceneRank] == 0) {
    alert('节目流不能少于1个');
    return false;
  }
  sourcesCount[sceneRank] --;
  $(delRowObj).parents("div:eq(3)").remove();
}

function addUnit() {
  sceneNum ++;
  sceneCount ++;
  sourcesNum[sceneNum] = 0;
  sourcesCount[sceneNum] = 0;
  var checkedBoxChecked = 'checked';
  var checkedBoxValue = 1;
  for(var i = 0;i < sceneNum;i++) {
    var checkBoxAttr = document.getElementById('scenes['+i+'][is_default]');
    if(!checkBoxAttr) continue;
    if(checkBoxAttr.checked) {
      checkedBoxChecked = '';
      checkedBoxValue = 0;
    }
  }
  var sceneDefault ='<div class="form-group"><label class="col-sm-2 control-label">默认画面:</label><div class="col-sm-5"><label class="radio-inline"><input type="checkbox" name="scenes['+sceneNum+'][is_default]" id="scenes['+sceneNum+'][is_default]" value="'+checkedBoxValue+'" onclick="changeChecked(this)" '+checkedBoxChecked+'> 是</label></div></div>';
  var html = '<div class="panel-body panel rim-color"><div class="form-actions"><div class="input-group up-right-corner"><span class="btn btn-default " onclick="deleteUnit(this)"><i class="glyphicon glyphicon-remove"></i></span></div></div><div class="form-group"><label class="col-sm-2 control-label">画面名称:</label><div class="col-sm-2"><input class="form-control" type="text" name="scenes['+sceneNum+'][name]" value="画面'+(sceneNum+1)+'" /></div></div>'+sceneDefault+'<div class="form-group"><label class="col-sm-2 control-label">配置流地址:</label></div><div class="padding-control" name = "sources_config"><div class="row"><div class="col-sm-3"><div class="input-group"><span class="input-group-addon">流类型</span><select class="form-control" name="sources['+sceneNum+']['+sourcesNum[sceneNum]+'][definition]" ><option value="">请选择</option>'+optionObj+'</select></div></div><div class="col-sm-4"><div class="input-group"><span class="input-group-addon">流地址</span><input type="text" class="form-control" name="sources['+sceneNum+']['+sourcesNum[sceneNum]+'][address]" value=""><span class="input-group-addon pointer " onclick="deleteRow(this)" data-value="'+sceneNum+'"><i class="glyphicon glyphicon-minus" ></i></span></div></div></div><br></div><div class="center-div"><span class="btn btn-default" onclick="addRow(this)" data-value="'+sceneNum+'"><i class="glyphicon glyphicon-plus" ></i><strong> 增加流</strong></span></div></div>';
  $(html).insertAfter($(".panel-body").last());
}

function deleteUnit(delUnitObj) {
  if(sceneCount <= 1) {
    alert('节目画面不能少于1个');
    return false;
  }
  sceneCount --;
  $(delUnitObj).parents("div:eq(2)").remove();
}


function changeChecked(checkboxObj) {
  var sceneName = checkboxObj.name;
  var checkBoxNum = sceneName.charAt(sceneName.indexOf('[')+1);
  var checkedAttr = document.getElementById('scenes['+checkBoxNum+'][is_default]');
  if(checkedAttr.checked) {
    $(checkedAttr).attr('value',1);
    for(var i = 0;i <= sceneNum;i++) {
      var checkBoxAttr = document.getElementById('scenes['+i+'][is_default]');
      if(i == checkBoxNum || !checkBoxAttr) continue;
      checkBoxAttr.checked = false;
      $(checkBoxAttr).attr('value',0);
    }
  } else {
    $(checkedAttr).attr('value',0);
  }
}

