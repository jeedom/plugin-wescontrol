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

function printEqLogic(_eqLogic) {
  const hideGeneral = document.querySelectorAll('.hidegeneral')
  hideGeneral.unseen()
  // 4.5.4 mini: document.getElementById('CGXParams').unseen()
  document.getElementById('CGXParams').addClass('hidden')

  let type = _eqLogic.configuration.type
  for (const i in _typeid) {
    if (type !== i) {
      document.querySelectorAll('.show' + i).unseen()
    } else {
      document.querySelectorAll('.show' + type).seen()
    }
  }

  if (type === 'general') {
    if (_eqLogic.configuration.usecustomcgx == 1) {
      // 4.5.4 mini: document.getElementById('CGXParams').seen()
      document.getElementById('CGXParams').removeClass('hidden')
    }
  } else {
    hideGeneral.seen()
    document.getElementById('span_type').innerText = _typeid[type]['type']
    let eqImg = document.querySelector('.eqLogicDisplayCard[data-eqLogic_id="' + _eqLogic.id + '"] img').src
    document.getElementById('icon_visu').src = eqImg

    if (isset(_typeid[type]['alternateimg'])) {
      document.querySelector('.eqLogicAttr[data-l2key=' + _typeid[type]['alternateimg']['value'] + ']').addEventListener('change', function() {
        const val = this.jeeValue()
        if (val !== '') {
          document.getElementById('icon_visu').src = 'plugins/wescontrol/core/config/' + type + '_' + val + '.png'
        }
      })
    }
  }
}

document.querySelector('.eqLogicAttr[data-l2key=usecustomcgx]').addEventListener('change', function() {
  if (this.checked) {
    // 4.5.4 mini: document.getElementById('CGXParams').seen()
    document.getElementById('CGXParams').removeClass('hidden')
  } else {
    // 4.5.4 mini: document.getElementById('CGXParams').unseen()
    document.getElementById('CGXParams').addClass('hidden')
  }
})

document.getElementById('div_pageContainer').addEventListener('click', function(event) {
  let _target = null

  if (_target = event.target.closest('.eqLogicAction[data-action=sendCGX]')) {
    domUtils.ajax({
      type: "POST",
      url: "plugins/wescontrol/core/ajax/wescontrol.ajax.php",
      data: {
        eqLogicId: document.querySelector('.eqLogicAttr[data-l1key=id]').jeeValue(),
        ftpIp: document.querySelector('.eqLogicAttr[data-l2key=ip]').jeeValue(),
        ftpUser: document.querySelector('.eqLogicAttr[data-l2key=ftpusername]').jeeValue(),
        ftpPass: document.querySelector('.eqLogicAttr[data-l2key=ftppassword]').jeeValue(),
        action: "sendCGX",
      },
      dataType: 'json',
      global: false,
      error: function(error) {
        jeedomUtils.showAlert({
          message: error.message,
          level: 'danger'
        })
      },
      success: function(data) {
        if (data.state != 'ok') {
          jeedomUtils.showAlert({
            message: data.result,
            level: 'danger'
          })
          return
        }
        jeedomUtils.showAlert({
          message: '{{Fichier CGX envoyé avec succès.}}',
          level: 'success'
        })
      }
    })
    return
  }

  if (_target = event.target.closest('#bt_goCarte')) {
    const ip = document.querySelector('.eqLogicAttr[data-l2key=ip]').jeeValue()
    const username = document.querySelector('.eqLogicAttr[data-l2key=username]').jeeValue()
    const password = document.querySelector('.eqLogicAttr[data-l2key=password]').jeeValue()
    let port = document.querySelector('.eqLogicAttr[data-l2key=port]').jeeValue()
    if (port != '') {
      port = ':' + port
    }

    if (ip != '' && username != '' && password != '') {
      const type = document.querySelector('.eqLogicAttr[data-l1key=configuration][data-l2key=type]').jeeValue()
      window.open('http://' + username + ':' + password + '@' + ip + port + '/' + _typeid[type]['HTM'])
    }
    else {
      jeedomUtils.showAlert({
        message: "{{Veuillez renseigner les informations de connexion HTTP pour accéder à l'interface du serveur Wes}}",
        level: 'danger'
      })
    }
    return
  }

  if (_target = event.target.closest('#bt_openAllwescontrol')) {
    document.querySelectorAll("div.panel-title > .accordion-toggle[aria-expanded='false']").forEach(function(toggle) {
      toggle.click()
    })
    return
  }

  if (_target = event.target.closest('#bt_closeAllwescontrol')) {
    document.querySelectorAll("div.panel-title > .accordion-toggle[aria-expanded='true']").forEach(function(toggle) {
      toggle.click()
    })
    return
  }

  if (_target = event.target.closest('#bt_resetwescontrolSearch')) {
    const search = document.getElementById('in_searchwescontrol')
    search.value = ''
    search.triggerEvent('keyup')
    return
  }
})

document.getElementById('in_searchwescontrol').addEventListener('keyup', function() {
  const childEqLogics = document.querySelectorAll('.childEqLogic')
  let search = this.jeeValue()

  if (search == '') {
    childEqLogics.seen()
    return
  }

  search = jeedomUtils.normTextLower(search)
  childEqLogics.unseen()
  document.querySelectorAll('.panel-collapse').forEach(function(panel) {
    panel.dataset.show = 0
  })
  childEqLogics.forEach(function(childEqLogic) {
    childEqLogic.querySelectorAll('.name').forEach(function(name) {
      if (jeedomUtils.normTextLower(name.textContent).indexOf(search) >= 0) {
        name.closest('.childEqLogic').seen()
        name.closest('.panel-collapse').dataset.show = 1
      }
    })
  })

  document.querySelectorAll('.panel-collapse[data-show="1"]').forEach(function(panel) {
    panel.addClass('in')
  })
  document.querySelectorAll('.panel-collapse[data-show="0"]').forEach(function(panel) {
    panel.removeClass('in')
  })
})

document.querySelectorAll('.wesSortableMenu').forEach(function(wesChildsMenu) {
  new Sortable(wesChildsMenu, {
    delay: 100,
    draggable: '.panel',
    direction: 'vertical',
    filter: '.eqLogicDisplayCard',
    preventOnFilter: false,
    chosenClass: 'dragSelected',
    onUpdate: function(evt) {
      var typeorder = []
      wesChildsMenu.querySelectorAll('.panel').forEach(function(child) {
        typeorder.push(child.dataset.type)
      })
      jeedom.eqLogic.byId({
        id: wesChildsMenu.dataset.generalid,
        success: function(data) {
          data = (data.result) ? data.result : data
          data.display = { menuorder: typeorder }
          jeedom.eqLogic.simpleSave({
            eqLogic: data
          })
        }
      })
    }
  })
})

function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    _cmd = { configuration: {} }
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {}
  }

  let tr = '<td class="hidden-xs">'
  tr += '<span class="cmdAttr" data-l1key="id"></span>'
  tr += '</td>'
  tr += '<td>'
  tr += '<div class="input-group">'
  tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" placeholder="{{Nom de la commande}}">'
  tr += '<span class="input-group-btn">'
  tr += '<a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="{{Choisir une icône}}"><i class="fas fa-icons disabled"></i></a>'
  tr += '</span>'
  tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;"></span>'
  tr += '</div>'
  tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display:none;margin-top:5px;" title="{{Commande information liée}}">'
  tr += '<option value="">{{Aucune}}</option>'
  tr += '</select>'
  tr += '</td>'
  tr += '<td>'
  tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>'
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>'
  tr += '</td>'
  tr += '<td>'
  tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>'
  tr += '</td>'
  tr += '<td>'
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked>{{Afficher}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked>{{Historiser}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary">{{Inverser}}</label> '
  tr += '<div style="margin-top:7px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="listValue" placeholder="{{Liste : valeur|texte (séparées par un point-virgule)}}" title="{{Liste : valeur|texte}}">'
  tr += '</div>'
  tr += '</td>'
  tr += '<td>'
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>'
  }
  tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>'
  tr += '</td>'

  let newRow = document.createElement('tr')
  newRow.innerHTML = tr
  newRow.className = 'cmd'
  newRow.setAttribute('data-cmd_id', init(_cmd.id))
  document.getElementById('table_cmd').querySelector('tbody').appendChild(newRow)
  newRow.setJeeValues(_cmd, '.cmdAttr')
  jeedom.cmd.changeType(newRow, init(_cmd.subType))
}
