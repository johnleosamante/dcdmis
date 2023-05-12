const tooltips = {
  titleMarginBottom: 10,
  titleFontColor: '#6e707e',
  titleFontSize: 14,
  backgroundColor: "rgb(255,255,255)",
  bodyFontColor: "#858796",
  borderColor: '#dddfeb',
  borderWidth: 1,
  xPadding: 15,
  yPadding: 15,
  displayColors: true,
  caretPadding: 10
};

const font = {
  size: 14
};

const pieOptions = {
  maintainAspectRatio: false,
  tooltips: tooltips,
  legend: {
    display: true,
    position: 'bottom',
    labels: {
      usePointStyle: true,
    }
  },
  plugins: {
    datalabels: {
      formatter: (value, ctx) => {
        let sum = 0;
        let dataArr = ctx.chart.data.datasets[0].data;
        dataArr.map(data => {
          sum += (data * 1);
        });
        let percentage = (((value * 1) / sum) * 100).toFixed(2) + "%";
        return percentage;
      },
      color: '#fff',
      font: font
    }
  }
}

const plugins = {
  datalabels: {
    color: function (ctx) {
      return ctx.dataset.backgroundColor;
    },
    anchor: 'end',
    align: 'end',
    font: font,
    formatter: (value, context) => {
      return value;
    }
  }
};

const barOptions = {
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
  tooltips: tooltips,
  plugins: plugins
};

function generate_random_color() {
  let num = Math.floor(Math.random() * 16777215);
  let hex = num.toString(16).toUpperCase();
  while (hex.length < 6) {
    hex = "0" + hex;
  }
  return "#" + hex;
}

function generate_color_pallete(items) {
  let colors = [];
  let counter = 0;
  while (counter < items) {
    colors.push(generate_random_color());
    counter++;
  }
  return colors;
}

function generate_pie_chart(data, colors, element) {
  const pieChart = new Chart(document.getElementById(element).getContext('2d'), {
    type: 'pie',
    data: {
      labels: data.map((item) => { return item.name; }),
      datasets: [{
        data: data.map((item) => { return item.count; }),
        backgroundColor: colors
      }]
    },
    options: pieOptions
  });
  pieChart.canvas.parentNode.style.minHeight = '400px';
  return pieChart;
}

function generate_doughnut_chart(data, colors, element) {
  const doughnutChart = new Chart(document.getElementById(element).getContext('2d'), {
    type: 'doughnut',
    data: {
      labels: data.map((item) => { return item.name; }),
      datasets: [{
        data: data.map((item) => { return item.count; }),
        backgroundColor: colors
      }]
    },
    options: pieOptions
  });
  doughnutChart.canvas.parentNode.style.minHeight = '400px';
  return doughnutChart;
}

function generate_polar_area_chart(data, colors, element) {
  const polarAreaChart = new Chart(document.getElementById(element).getContext('2d'), {
    type: 'polarArea',
    data: {
      labels: data.map((item) => { return item.name; }),
      datasets: [{
        data: data.map((item) => { return item.count; }),
        backgroundColor: colors
      }]
    },
    options: pieOptions
  });
  polarAreaChart.canvas.parentNode.style.minHeight = '400px';
  return polarAreaChart;
}

function generate_bar_chart(data, colors, element) {
  const barChart = new Chart(document.getElementById(element).getContext('2d'), {
    type: 'bar',
    data: {
      labels: data.map((item) => { return item.name; }),
      datasets: [{
        data: data.map((item) => { return item.count; }),
        backgroundColor: colors
      }]
    },
    options: barOptions
  });
  return barChart;
}

function generate_comparative_bar_chart(data, colors, element) {
  const barChart = new Chart(document.getElementById(element).getContext('2d'), {
    type: 'bar',
    data: {
      labels: data.map((item) => { return item.name; }),
      datasets: [{
        backgroundColor: colors[0],
        data: data.map((item) => { return item.male; })
      },
      {
        backgroundColor: colors[1],
        data: data.map((item) => { return item.female; })
      }]
    },
    options: barOptions
  });
  return barChart;
}

function generate_comparative_line_chart(data, colors, element) {
  const lineChart = new Chart(document.getElementById(element).getContext('2d'), {
    data: { 
      labels: data.map((item) => { return item.name; }), 
      datasets: [{ 
        type: 'line', 
        data: data.map((item) => {}), 
        backgroundColor: 'transparent', 
        borderColor: '#007bff', 
        pointBorderColor: '#007bff', 
        pointBackgroundColor: '#007bff', 
        fill: false 
      }, 
      { 
        type: 'line', 
        data: [60, 80, 70, 67, 80, 77, 100], 
        backgroundColor: 'tansparent', 
        borderColor: '#ced4da', 
        pointBorderColor: '#ced4da', 
        pointBackgroundColor: '#ced4da', 
        fill: false }] 
      },
      options: { 
        maintainAspectRatio: false, 
        tooltips: { 
          mode: mode, 
          intersect: intersect 
        }, 
        hover: { 
          mode: mode, 
          intersect: intersect 
        }, 
        legend: { 
          display: false 
        }, 
        scales: { 
          yAxes: [{ 
            gridLines: { 
              display: true, 
              lineWidth: '4px', 
              color: 'rgba(0, 0, 0, .2)', 
              zeroLineColor: 'transparent' 
            }, 
            ticks: $.extend({ 
              beginAtZero: true, 
              suggestedMax: 200 }, ticksStyle)
          }], 
          xAxes: [{ display: true, 
            gridLines: { 
              display: false 
            }, 
            ticks: ticksStyle 
          }] 
        } 
      }
  });
  return lineChart;
}