// assets/js/chart-custom.js
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function () {
  $('div.alert').fadeIn(300).delay(60000).fadeOut(300);
});

let dtProps = {
  "responsive": true,
  "pagingType": "simple",
  "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]],
  "paging": true,
  "order": [],
  "autoWidth": false, 
  "info": true,
};

$(document).ready(function () {
  if ($('#data-table-previous').length > 0) {
    $('#data-table-previous').DataTable(dtProps);
  }
});

$(document).ready(function () {
  if ($('#data-table').length > 0) {
    $('#data-table').DataTable(dtProps);
  }
});

$(document).ready(function () {
  if ($('#data-table-next').length > 0) {
    $('#data-table-next').DataTable(dtProps);
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

let oldToggle = document.getElementById('old-eye-toggle');
if (elementExist(oldToggle)) {
  oldToggle.addEventListener('click', (e) => {
    e.preventDefault();
    eyeToggle('old-password', 'old-eye');
  });
}

let toggle = document.getElementById('eye-toggle');
if (elementExist(toggle)) {
  toggle.addEventListener('click', (e) => {
    e.preventDefault();
    eyeToggle('password', 'eye');
  });
}

let confirmToggle = document.getElementById('eye-confirm-toggle');
if (elementExist(confirmToggle)) {
  confirmToggle.addEventListener('click', (e) => {
    e.preventDefault();
    eyeToggle('password-confirm', 'eye-confirm');
  });
}

let generateToggle = document.getElementById('generate-toggle');
if (elementExist(generateToggle)) {
  generateToggle.addEventListener('click', (e) => {
    e.preventDefault();
    let strongPassword = false;
    let length = generateRandomNumber(10, 16);
    let randomPassword = '';

    while(!strongPassword) {
      randomPassword = generateRandomPassword(length);
      strongPassword = checkPasswordStrength(randomPassword);
    }

    document.getElementById('password').value = randomPassword;
    document.getElementById('password-confirm').value = randomPassword;
    document.getElementById('generate-password').value = randomPassword;
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
        location.reload();
        return;
      }
    }
  }

  xmlhttp.open('GET', href);
  xmlhttp.send();
}

function generateRandomPassword(length) {
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+~`|}{[]\:;?><,./-=';

  let result = '';
  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }

  return result;
}

function generateRandomNumber(min, max) {
  const randomDecimal = Math.random();
  const randomInRange = randomDecimal * (max - min + 1) + min;
  const randomInteger = Math.floor(randomInRange);

  return randomInteger;
}

function checkPasswordStrength(str) {
  const uppercaseRegex = /[A-Z]/;
  const lowercaseRegex = /[a-z]/;
  const numberRegex = /[0-9]/;
  const specialRegex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

  if (!uppercaseRegex.test(str)) {
    return false;
  }

  if (!lowercaseRegex.test(str)) {
    return false;
  }

  if (!numberRegex.test(str)) {
    return false;
  }

  if (!specialRegex.test(str)) {
    return false;
  }

  return true;
}