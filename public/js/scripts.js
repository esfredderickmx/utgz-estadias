$(document).ready(function () {
  $('.ui.checkbox').each(function () {
    $(this).checkbox();
  });

  $('.ui.dropdown').dropdown();
  $('.ui.selection.dropdown').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: 'exact',
    message: {
      addResult: 'Añadir <b>{term}</b>',
      count: '{count} seleccionado(s)',
      maxSelections: '{maxCount} selecciones máx',
      noResults: 'Sin resultados'
    }
  });

  $('#navbar-segment').visibility({
    once: false,
    onBottomPassedReverse: function () {
      $('#floating-navbar').transition();
      $('.ui.sticky').sticky({
        offset: 0.1
      });
    },
    onBottomPassed: function () {
      $('#floating-navbar').transition();
      $('.ui.sticky').sticky({
        context: '#content'
      });
    }
  });

  /*   $(":not([modal-status])").modal({
      detachable: true,
      closable: false,
      inverted: true,
      transition: 'fade up',
      allowMultiple: false,
      onShow: function () {
        $('.ui.dimmer').addClass('inverted');
        $('.pop').popup('hide')
      }
    }); */

  $("[modal-status='uninitialized']").each(function () {
    $(this).modal({
      detachable: false,
      centered: false,
      closable: false,
      inverted: true,
      transition: 'fade up',
      allowMultiple: false,
      onShow: function () {
        $(this).attr('modal-status', 'initialized')
        $('.ui.dimmer').addClass('inverted');
        $('.pop').popup('hide')
      }
    });
  });

  $('[target-modal]').each(function () {
    $('#' + $(this).attr('target-modal')).modal('attach events', $(this));
  });

  $('.toggle.password').state({
    text: {
      inactive: '<i class="eye slash icon"></i>',
      active: '<i class="eye icon"></i>'
    },
    className: {
      active: 'teal'
    },
    onChange: function () {
      var passwordField = $(this).closest('.field').find('input');

      if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text').focus();
      } else {
        passwordField.attr('type', 'password').focus();
      }
    }
  });
});

$(document).ready(function () {
  var url = window.location.href;
  var modal = $('#login-modal');
  var open = modal.attr('data-open-modal') === '1';

  if (url.includes('/login') || open) {
    $('#login-modal').modal('show');
  }
});

$(document).ready(function () {
  var url = window.location.href;
  var modal = $('#reset-modal');
  var open = modal.attr('data-open-modal') === '1';

  if (url.includes('/reset-password') || open) {
    $('#reset-modal').modal('show');
  }
});

let lastInfo = null;

$(document).ready(function () {
  Livewire.on('toast', function (type, message) {
    if (type === 'info') {
      if (!lastInfo) {
        lastInfo = showToast(type, message);
      }
    } else {
      showToast(type, message);
    }
  });

  Livewire.on('dismiss', function () {
    if (lastInfo) {
      lastInfo.toast('close');
    }
  });
});

$(document).ready(function () {
  Livewire.on('logged-in', function (message) {
    $('#login-modal').modal('hide');

    Livewire.emit('refreshUser');

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);
    }, 500);
  });

  Livewire.on('reset-requested', function (message) {
    $('#forgot-modal').modal('hide');

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);
    }, 500);
  });

  Livewire.on('password-reset', function (message) {
    $('#reset-modal').modal('hide');

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);
    }, 500);
  });

  Livewire.on('created-entity', function (entity, message) {
    $('#create-' + entity + '-modal').modal('hide');

    Livewire.emit('refresh');

    if (entity === 'career') {
      $('#create-' + entity + '-form').find("[type='file']").first().val('')
    }

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);
    }, 500);
  });

  Livewire.on('updated-entity', function (entity, id, message) {
    var modal = $('#edit-' + entity + '-' + id + '-modal');
    modal.modal('hide');

    Livewire.emit('refresh');

    if (entity === 'career') {
      $('#create-' + entity + '-form').find("[type='file']").first().val('')
    }

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);
    }, 500);
  });

  Livewire.on('deleted-entity', function (entity, id, message) {
    var editModal = $('#edit-' + entity + '-' + id + '-modal');
    var deleteModal = $('#delete-' + entity + '-' + id + '-modal');
    deleteModal.modal('hide');

    Livewire.emit('refresh');

    setTimeout(function () {
      Livewire.emit('toast', 'success', message);

      editModal.modal('destroy');
      deleteModal.modal('destroy');
    }, 500);
  });

  Livewire.on('selected-icon', function (type, id) {
    if (type === 'create') {
      $('#create-area-modal').modal('show');
    } else if (type === 'edit') {
      $('#edit-area-' + id + '-modal').modal('show');
    }
  });
});

$(document).ready(function () {
  var sessionInfo = $('#session-info');

  if (sessionInfo.length) {
    Livewire.emit('toast', 'info', sessionInfo.val());
  }
});

$(document).on('livewire:update', function () {
  $('.ui.form').each(function () {
    $(this).on('submit', function () {
      setTimeout(() => {
        var $firstErrorField = $(this).find('.field.error').first();

        if ($firstErrorField.length) {
          $firstErrorField.find('input, select, textarea').focus();
        }
      }, 500);
    });
  });
});

/* $(document).on('livewire:update', function () {
  $("[modal-status='initialized']").each(function () {
    if ($(this).modal('is active')) {
      return true
    } else {
      $('#search').focus()
      return false
    }
  });
}); */

$(document).on('livewire:update', function () {
  $('.ui.checkbox').each(function () {
    $(this).checkbox();
  });

  $('.ui.dropdown').dropdown();
  $('.ui.selection.dropdown').dropdown({
    ignoreDiacritics: true,
    sortSelect: true,
    fullTextSearch: 'exact',
    message: {
      addResult: 'Añadir <b>{term}</b>',
      count: '{count} seleccionado(s)',
      maxSelections: '{maxCount} selecciones máx',
      noResults: 'Sin resultados'
    }
  });

  $("[modal-status='uninitialized']").each(function () {
    $(this).modal({
      detachable: false,
      centered: false,
      closable: false,
      inverted: true,
      transition: 'fade up',
      allowMultiple: false,
      onShow: function () {
        $(this).attr('modal-status', 'initialized')
        $('.ui.dimmer').addClass('inverted');
        $('.pop').popup('hide')
      }
    });
  });
  $('.ui.dimmer').addClass('inverted');

  $('[target-modal]').each(function () {
    $('#' + $(this).attr('target-modal')).modal('attach events', $(this));
  });
});

function showToast(type, message) {
  return $.toast({
    class: type,
    title: function () {
      switch (type) {
        case 'success':
          return '¡Éxito!';
        case 'info':
          return 'Info.:';
        case 'warning':
          return 'Atención:';
        case 'error':
          return '¡Algo falló!';
        default:
          return 'Mensaje:';
      }
    },
    message: message,
    displayTime: 'auto',
    showProgress: 'top',
    position: 'bottom left',
    className: {
      toast: 'ui message'
    },
    transition: {
      showMethod: 'fly right',
      hideMethod: 'fly right',
      closeEasing: 'easeOutBounce'
    },
    onHidden: function () {
      if (type === 'info') {
        lastInfo = null;
      }
    }
  });
}