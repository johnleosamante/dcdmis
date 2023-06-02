if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
  $('div.alert').fadeIn(300).delay(60000).fadeOut(300);
});

$(document).ready(function () {
  if ($('#data-table').length > 0) {
    $('#data-table').DataTable();
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

function loadData(href, id = 'modal') {
  const xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

  xmlhttp.onreadystatechange = () => {
    if (xmlhttp.readyState === 4) {
      if (xmlhttp.status === 200) {
        document.getElementById(id).innerHTML = xmlhttp.responseText;
      } else {
        alert('Bad request encountered! Please refresh the page and try again.');
        return;
      }
    }
  }

  xmlhttp.open('GET', href, false);
  xmlhttp.send();
}