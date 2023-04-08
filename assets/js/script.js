if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

//document.addEventListener('contextmenu', (e) => e.preventDefault());

$(document).ready(function () {
  $('div.alert').fadeIn(300).delay(10000).fadeOut(300);
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

function load_view(id, href) {
  const xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

  xmlhttp.onreadystatechange = () => {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById(id).innerHTML = xmlhttp.responseText;
    }
  }

  xmlhttp.open('GET', href, false);
  xmlhttp.send();
}

const user_logout = document.getElementById('user_logout');
if (element_exist(user_logout)) {
  user_logout.addEventListener('click', () => {
    load_view('Modal', '../logout/logout-dialog.php');
  });
}

const receive_document = document.getElementById('receive_document');
if (element_exist(receive_document)) {
  receive_document.addEventListener('click', () => {
    load_view('Modal', '../modules/documents/receive-document-dialog.php');
  });
}

const forward_document = document.getElementById('forward_document');
if (element_exist(forward_document)) {
  forward_document.addEventListener('click', () => {
    load_view('Modal', '../modules/documents/forward-document-dialog.php');
  });
}

const complete_document = document.getElementById('complete_document');
if (element_exist(complete_document)) {
  complete_document.addEventListener('click', () => {
    load_view('Modal', '../modules/documents/complete-document-dialog.php');
  });
}

const cancel_document = document.getElementById('cancel_document');
if (element_exist(cancel_document)) {
  cancel_document.addEventListener('click', () => {
    load_view('Modal', '../modules/documents/cancel-document-dialog.php');
  });
}

const sidebar_toggle = localStorage.getItem('sidebar_toggle');
if (sidebar_toggle === null) {
  localStorage.setItem('sidebar_toggle', 'false');
}

if (sidebar_toggle === 'true') {
  const sidebar = document.getElementById('accordionSidebar');
  sidebar.classList.add('toggled');
}

function check_sidebar_toggle() {
  if (localStorage.getItem('sidebar_toggle') === 'true') {
    localStorage.setItem('sidebar_toggle', 'false');
  } else {
    localStorage.setItem('sidebar_toggle', 'true');
  }
}

const sidebar_toggle_button = document.getElementById('sidebarToggle');
if (element_exist(sidebar_toggle_button)) {
  sidebar_toggle_button.addEventListener('click', () => {
    check_sidebar_toggle()
  });
}

const sidebar_toggle_top_button = document.getElementById('sidebarToggleTop');
if (element_exist(sidebar_toggle_top_button)) {
  sidebar_toggle_top_button.addEventListener('click', (e) => {
    e.preventDefault();
    check_sidebar_toggle()
  });
}