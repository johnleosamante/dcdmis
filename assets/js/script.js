if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
  $('div.alert').fadeIn(300).delay(60000).fadeOut(300);
});

$(document).ready(function () {
  if ($('#dataTable').length > 0) {
    $('#dataTable').DataTable();
  }
});

function eyeToggle(inputId, eyeId) {
  const input = document.getElementById(inputId);
  const eye = document.getElementById(eyeId);

  if (input.type === 'password') {
    input.type = 'text';
    eye.classList.remove('fa-eye');
    eye.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    eye.classList.remove('fa-eye-slash');
    eye.classList.add('fa-eye');
  }
}

function elementExist(element) {
  return typeof(element) !== 'undefined' && element !== null;
}

let toggle = document.getElementById('eye-toggle');
if (elementExist(toggle)) {
  document.getElementById('eye-toggle').addEventListener('click', (e) => {
    e.preventDefault();
    eyeToggle('password', 'eye');
  });
}

let confirmToggle = document.getElementById('eye-confirm-toggle');
if (elementExist(confirmToggle)) {
  document.getElementById('eye-confirm-toggle').addEventListener('click', (e) => {
    e.preventDefault();
    eyeToggle('password-confirm', 'eye-confirm');
  });
}

function loadModal(href) {
  const xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

  xmlhttp.onreadystatechange = () => {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById('Modal').innerHTML = xmlhttp.responseText;
    } else {
      let error = xmlhttp.status;
      document.getElementById('Modal').innerHTML = '<div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button></div><div class="modal-body text-center"><div class="error mx-auto" data-text="' + error + '">' + error + '</div><p class="text-gray-500">Please refresh the page and try again...</p></div></div></div>';
    }
  }

  xmlhttp.open('GET', href, false);
  xmlhttp.send();
}

function loadData(href, id) {
  const xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

  xmlhttp.onreadystatechange = () => {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById(id).innerHTML = xmlhttp.responseText;
    } else if (xmlhttp.status >= 400) {
      document.getElementById(id).innerHTML = 'No data to available';
    }
  }

  xmlhttp.open('GET', href, false);
  xmlhttp.send();
}