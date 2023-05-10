function generate_pie_chart(data, colors, element = 'pie-chart') {
  var labels = data.map(function (item) {
    return item.name;
  });
  var values = data.map(function (item) {
    return item.count;
  });
  var ctx = document.getElementById(element).getContext('2d');
  var pieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: values,
        backgroundColor: colors
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false
      },
      cutoutPercentage: 65
    }
  });
  return pieChart;
}

function generate_bar_chart(data, colors, element = 'bar-chart') {
  var labels = data.map(function (item) {
    return item.name;
  });
  var values = data.map(function (item) {
    return item.count;
  });
  var ctx = document.getElementById(element).getContext('2d');
  var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        data: values,
        backgroundColor: colors
      }]
    },
    options: {
      scales: {
        xAxes: [{
          gridLines: {
            display: false,
            drawBorder: false
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10
      },
    },
  });
  return barChart;
}

function generate_random_color() {
  var num = Math.floor(Math.random() * 16777215);
  var hex = num.toString(16).toUpperCase();
  while (hex.length < 6) {
    hex = "0" + hex;
  }

  return "#" + hex;
}

function generate_color_pallete(items) {
  var colors = [];
  var counter = 0;
  while (counter < items) {
    colors.push(generate_random_color());
    counter++;
  }
  return colors;
}