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

function eye_toggle(input_id, eye_id) {
  const input = document.getElementById(input_id);
  const eye = document.getElementById(eye_id);

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

function element_exist(element) {
  return typeof(element) !== 'undefined' && element !== null;
}

let toggle = document.getElementById('eye_toggle');
if (element_exist(toggle)) {
  document.getElementById('eye_toggle').addEventListener('click', (e) => {
    e.preventDefault();
    eye_toggle('password', 'eye');
  });
}

let confirm_toggle = document.getElementById('eye_confirm_toggle');
if (element_exist(confirm_toggle)) {
  document.getElementById('eye_confirm_toggle').addEventListener('click', (e) => {
    e.preventDefault();
    eye_toggle('password_confirm', 'eye_confirm');
  });
}

function load_view(href) {
  const xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

  xmlhttp.onreadystatechange = () => {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById('Modal').innerHTML = xmlhttp.responseText;
    }
  }

  xmlhttp.open('GET', href, false);
  xmlhttp.send();
}