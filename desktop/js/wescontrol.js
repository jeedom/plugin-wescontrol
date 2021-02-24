/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

$('.eqLogicAttr[data-l1key=configuration][data-l2key=type]').on('change',function(){
  type = $(this).value()
  if (type != '') {
    for (var i in typeid) {
      if (type == i){
        $('.show'+i).show();
      } else {
        $('.show'+i).hide();
      }
    }
  }
});

$(".wescontrolTab").on('click',function(){
  setTimeout(function(){
    $('.packery').packery({
      itemSelector: ".eqLogicDisplayCard"
    });
  },50);
});

$('.eqLogicAttr[data-l2key=usecustomcgx]').on('click', function(){
  if ($(this).is(':checked')) {
    $('#div_alert').showAlert({message: '{{N\'oubliez pas de cliquer sur le bouton "Envoyer fichier CGX" pour utiliser le fichier CGX personnalisé Jeedom et ainsi avoir accès à davantage de données.}}', level: 'warning'});
  }
  else {
    $.hideAlert()
  }
})

$('.eqLogicAction[data-action=sendCGX]').off().on('click', function (){
  $.ajax({
    type: "POST",
    url: "plugins/wescontrol/core/ajax/wescontrol.ajax.php",
    data: {
      eqLogicId: $('.eqLogicAttr[data-l1key=id]').value(),
      ftpIp: $('.eqLogicAttr[data-l2key=ip]').value(),
      ftpUser: $('.eqLogicAttr[data-l2key=ftpusername]').value(),
      ftpPass: $('.eqLogicAttr[data-l2key=ftppassword]').value(),
      action: "sendCGX",
    },
    dataType: 'json',
    global: false,
    error: function (request, status, error) {
      handleAjaxError(request, status, error);
    },
    success: function (data) {
      if (data.state != 'ok') {
        $('#div_alert').showAlert({message: data.result, level: 'danger'});
        return;
      }
      $('#div_alert').showAlert({message: '{{Fichier CGX envoyé avec succès.}}', level: 'success'});
    }
  });
})

$('#bt_goCarte').on('click', function() {
  $.hideAlert()
  let ip = $('.eqLogicAttr[data-l2key=ip]').value()
  let username = $('.eqLogicAttr[data-l2key=username]').value()
  let password = $('.eqLogicAttr[data-l2key=password]').value()
  let port = ($('.eqLogicAttr[data-l2key=port]').value() != '') ? ':'+$('.eqLogicAttr[data-l2key=port]').value() : ''

  if (ip != '' && username != '' && password != '') {
    window.open('http://'+username+':'+password+'@'+ip+port+'/'+typeid[$('.eqLogicAttr[data-l1key=configuration][data-l2key=type]').value()])
  }
  else {
    $('#div_alert').showAlert({message: '{{Veuillez renseigner les informations de connexion HTTP pour accéder à l\'interface du serveur wescontrol.}}', level: 'danger'});
  }
});

$('#in_searchwescontrol').keyup(function() {
  var search = $(this).value()
  if (search == '') {
    $('.eqLogicDisplayCard').show()
    return;
  }
  search = normTextLower(search)
  $('.eqLogicThumbnailContainer.packery .eqLogicDisplayCard').hide()
  $('.panel-collapse').attr('data-show',0)
  var text
  $('.eqLogicDisplayCard .name').each(function() {
    text = normTextLower($(this).text())
    if (text.indexOf(search) >= 0) {
      $(this).closest('.eqLogicDisplayCard').show()
      $(this).closest('.panel-collapse').attr('data-show',1)
    }
  })
  $('.panel-collapse[data-show=1]').collapse('show')
  $('.panel-collapse[data-show=0]').collapse('hide')
  $('.packery').packery()
})

$('#bt_openAllwescontrol').off('click').on('click', function() {
  $("div.panel-title > .accordion-toggle[aria-expanded='false']").click()
})
$('#bt_closeAllwescontrol').off('click').on('click', function() {
  $("div.panel-title > .accordion-toggle[aria-expanded='true']").click()
})
$('#bt_resetwescontrolSearch').off('click').on('click', function() {
  $('#in_searchwescontrol').val('').keyup()
})

$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {configuration: {}};
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {};
  }
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
  tr += '<td>';
  tr += '<div class="row">';
  tr += '<div class="col-sm-6">';
  tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icône</a>';
  tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
  tr += '</div>';
  tr += '<div class="col-sm-6">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
  tr += '</div>';
  tr += '</div>';
  tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display : none;margin-top : 5px;" title="La valeur de la commande vaut par défaut la commande">';
  tr += '<option value="">Aucune</option>';
  tr += '</select>';
  tr += '</td>';
  tr += '<td>';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="id" style="display : none;">';
  tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
  tr += '</td>';
  tr += '<td><input class="cmdAttr form-control input-sm" data-l1key="logicalId" value="0" style="width : 70%; display : inline-block;" placeholder="{{Commande}}"><br/>';
  tr += '</td>';
  tr += '<td>';
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;display:inline-block;">';
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;display:inline-block;">';
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;display:inline-block;margin-left:2px;">';
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="listValue" placeholder="{{Liste de valeur|texte séparé par ;}}" title="{{Liste}}">';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isHistorized" checked/>{{Historiser}}</label></span> ';
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label></span> ';
  tr += '</td>';
  tr += '<td>';
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> ';
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
  }
  tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
  tr += '</td>';
  tr += '</tr>';
  $('#table_cmd tbody').append(tr);
  var tr = $('#table_cmd tbody tr').last();
  jeedom.eqLogic.builSelectCmd({
    id: $('.eqLogicAttr[data-l1key=id]').value(),
    filter: {type: 'info'},
    error: function (error) {
      $('#div_alert').showAlert({message: error.message, level: 'danger'});
    },
    success: function (result) {
      tr.find('.cmdAttr[data-l1key=value]').append(result);
      tr.setValues(_cmd, '.cmdAttr');
      jeedom.cmd.changeType(tr, init(_cmd.subType));
    }
  });
}
