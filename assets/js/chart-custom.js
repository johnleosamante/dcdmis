// assets/js/chart-custom.js
const tooltips = {
	titleMarginBottom: 10,
	titleFontColor: "#6e707e",
	titleFontSize: 14,
	backgroundColor: "rgb(255,255,255)",
	bodyFontColor: "#858796",
	borderColor: "#dddfeb",
	borderWidth: 1,
	xPadding: 15,
	yPadding: 15,
	displayColors: true,
	caretPadding: 10,
};

const font = {
	size: 14,
};

const pieOptions = {
	maintainAspectRatio: false,
	tooltips: tooltips,
	legend: {
		display: true,
		position: "bottom",
		labels: {
			usePointStyle: true,
		},
	},
	plugins: {
		datalabels: {
			formatter: (value, ctx) => {
				let sum = 0;
				let dataArr = ctx.chart.data.datasets[0].data;

				dataArr.map((data) => {
					sum += data * 1;
				});

				return (((value * 1) / sum) * 100).toFixed(2) + "%";
			},
			color: "#fff",
			font: font,
		},
	},
};

const plugins = {
	datalabels: {
		color: function (ctx) {
			return ctx.dataset.backgroundColor;
		},
		anchor: "end",
		align: "end",
		font: font,
		formatter: (value, context) => {
			return value;
		},
	},
};

const barOptions = {
	scales: {
		xAxes: [
			{
				gridLines: {
					display: false,
					drawBorder: false,
				},
			},
		],
		yAxes: [
			{
				ticks: {
					beginAtZero: true,
				},
			},
		],
	},
	legend: {
		display: false,
	},
	tooltips: tooltips,
	plugins: plugins,
};

function generateRandomColor() {
	let num = Math.floor(Math.random() * 16777215);
	let hex = num.toString(16).toUpperCase();

	while (hex.length < 6) {
		hex = "0" + hex;
	}

	return "#" + hex;
}

function generateColorPallete(items) {
	let colors = [];
	let counter = 0;

	while (counter < items) {
		colors.push(generateRandomColor());
		counter++;
	}

	return colors;
}

function generatePieChart(data, colors, element, enableLinks = true) {
	const pieChart = new Chart(
		document.getElementById(element).getContext("2d"),
		{
			type: "pie",
			data: {
				labels: data.map((item) => {
					return item.name;
				}),
				datasets: [
					{
						data: data.map((item) => {
							return item.count;
						}),
						backgroundColor: colors,
					},
				],
			},
			options: {
				...pieOptions,
				onClick: function (evt, activeElements) {
					if (enableLinks && activeElements && activeElements.length > 0) {
						const index = activeElements[0]._index;
						const item = data[index];
						if (item && item.link) {
							window.location.href = item.link;
						}
					}
				},
				onHover: function (evt, activeElements) {
					const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
					evt.target.style.cursor = hasLink ? "pointer" : "default";
				}
			},
		}
	);

	pieChart.canvas.parentNode.style.minHeight = "400px";

	return pieChart;
}

function generateDoughnutChart(data, colors, element, enableLinks = true) {
	const doughnutChart = new Chart(
		document.getElementById(element).getContext("2d"),
		{
			type: "doughnut",
			data: {
				labels: data.map((item) => {
					return item.name;
				}),
				datasets: [
					{
						data: data.map((item) => {
							return item.count;
						}),
						backgroundColor: colors,
					},
				],
			},
			options: {
				...pieOptions,
				onClick: function (evt, activeElements) {
					if (enableLinks && activeElements && activeElements.length > 0) {
						const index = activeElements[0]._index;
						const item = data[index];
						if (item && item.link) {
							window.location.href = item.link;
						}
					}
				},
				onHover: function (evt, activeElements) {
					const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
					evt.target.style.cursor = hasLink ? "pointer" : "default";
				}
			},
		}
	);

	doughnutChart.canvas.parentNode.style.minHeight = "400px";

	return doughnutChart;
}

function generatePolarAreaChart(data, colors, element, enableLinks = true) {
	const polarAreaChart = new Chart(document.getElementById(element).getContext("2d"), {
		type: "polarArea",
		data: {
			labels: data.map((item) => {
				return item.name;
			}),
			datasets: [
				{
					data: data.map((item) => {
						return item.count;
					}),
					backgroundColor: colors,
				},
			],
		},
		options: {
			...pieOptions,
			onClick: function (evt, activeElements) {
				if (enableLinks && activeElements && activeElements.length > 0) {
					const index = activeElements[0]._index;
					const item = data[index];
					if (item && item.link) {
						window.location.href = item.link;
					}
				}
			},
			onHover: function (evt, activeElements) {
				const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
				evt.target.style.cursor = hasLink ? "pointer" : "default";
			}
		},
	});

	polarAreaChart.canvas.parentNode.style.minHeight = "400px";

	return polarAreaChart;
}

function generateBarChart(data, colors, element, enableLinks = true) {
	const barChart = new Chart(document.getElementById(element).getContext("2d"), {
		type: "bar",
		data: {
			labels: data.map((item) => {
				return item.name;
			}),
			datasets: [
				{
					data: data.map((item) => {
						return item.count;
					}),
					backgroundColor: colors,
				},
			],
		},
		options: {
			...barOptions,
			onClick: function (evt, activeElements) {
				if (enableLinks && activeElements && activeElements.length > 0) {
					const index = activeElements[0]._index;
					const item = data[index];
					if (item && item.link) {
						window.location.href = item.link;
					}
				}
			},
			onHover: function (evt, activeElements) {
				const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
				evt.target.style.cursor = hasLink ? "pointer" : "default";
			}
		},
	});

	return barChart;
}

function generateComparativeBarChart(data, colors, element, enableLinks = true) {
	const barChart = new Chart(document.getElementById(element).getContext("2d"), {
		type: "bar",
		data: {
			labels: data.map((item) => {
				return item.name;
			}),
			datasets: [
				{
					backgroundColor: colors[0],
					data: data.map((item) => {
						return item.male;
					}),
				},
				{
					backgroundColor: colors[1],
					data: data.map((item) => {
						return item.female;
					}),
				},
			],
		},
		options: {
			...barOptions,
			onClick: function (evt, activeElements) {
				if (enableLinks && activeElements && activeElements.length > 0) {
					const index = activeElements[0]._index;
					const item = data[index];
					if (item && item.link) {
						window.location.href = item.link;
					}
				}
			},
			onHover: function (evt, activeElements) {
				const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
				evt.target.style.cursor = hasLink ? "pointer" : "default";
			}
		},
	});

	return barChart;
}

function generateComparativeLineChart(data, colors, element, enableLinks = true) {
	const lineChart = new Chart(document.getElementById(element).getContext("2d"), {
		data: {
			labels: data.map((item) => {
				return item.name;
			}),
			datasets: [
				{
					type: "line",
					data: data.map((item) => {
						return item.dataOne;
					}),
					backgroundColor: "transparent",
					borderColor: colors[0],
					pointBorderColor: colors[0],
					pointBackgroundColor: colors[0],
					fill: false,
				},
				{
					type: "line",
					data: data.map((item) => {
						return item.dataTwo;
					}),
					backgroundColor: "transparent",
					borderColor: colors[1],
					pointBorderColor: colors[1],
					pointBackgroundColor: colors[1],
					fill: false,
				},
			],
		},
		options: {
			maintainAspectRatio: false,
			tooltips: {
				mode: mode,
				intersect: intersect,
			},
			hover: {
				mode: mode,
				intersect: intersect,
			},
			legend: {
				display: false,
			},
			onClick: function (evt, activeElements) {
				if (enableLinks && activeElements && activeElements.length > 0) {
					const index = activeElements[0]._index;
					const item = data[index];
					if (item && item.link) {
						window.location.href = item.link;
					}
				}
			},
			onHover: function (evt, activeElements) {
				const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
				evt.target.style.cursor = hasLink ? "pointer" : "default";
			},
			scales: {
				yAxes: [
					{
						gridLines: {
							display: true,
							lineWidth: "4px",
							color: "rgba(0, 0, 0, .2)",
							zeroLineColor: "transparent",
						},
						ticks: $.extend(
							{
								beginAtZero: true,
								suggestedMax: 200,
							},
							ticksStyle
						),
					},
				],
				xAxes: [
					{
						display: true,
						gridLines: {
							display: false,
						},
						ticks: ticksStyle,
					},
				],
			},
		},
	});

	return lineChart;
}

function generateMultiSeriesBarChart(data, element, enableLinks = true) {
	const statusColors = {
		incoming: '#4e73df',
		pending: '#f6c23e',
		outgoing: '#36b9cc',
		ongoing: '#e74a3b'
	};

	const statusLabels = {
		incoming: 'Incoming',
		pending: 'Pending',
		outgoing: 'Outgoing',
		ongoing: 'Ongoing'
	};

	const datasets = [];
	const statuses = ['incoming', 'pending', 'outgoing', 'ongoing'];

	statuses.forEach((status) => {
		datasets.push({
			label: statusLabels[status],
			backgroundColor: statusColors[status],
			data: data.map((item) => {
				return item[status] || 0;
			}),
		});
	});

	const multiSeriesBarOptions = {
		scales: {
			xAxes: [
				{
					gridLines: {
						display: false,
						drawBorder: false,
					},
				},
			],
			yAxes: [
				{
					ticks: {
						beginAtZero: true,
					},
				},
			],
		},
		legend: {
			display: true,
			position: 'top',
		},
		tooltips: tooltips,
		onClick: function (evt, activeElements) {
			if (enableLinks && activeElements && activeElements.length > 0) {
				const index = activeElements[0]._index;
				const item = data[index];
				if (item && item.link) {
					window.location.href = item.link;
				}
			}
		},
		onHover: function (evt, activeElements) {
			const hasLink = enableLinks && activeElements && activeElements.length > 0 && data[activeElements[0]._index] && data[activeElements[0]._index].link;
			evt.target.style.cursor = hasLink ? "pointer" : "default";
		},
		plugins: {
			datalabels: {
				color: function (ctx) {
					return '#000';
				},
				anchor: 'end',
				align: 'end',
				font: font,
				formatter: (value, context) => {
					return value;
				},
			},
		},
	};

	return new Chart(document.getElementById(element).getContext('2d'), {
		type: 'bar',
		data: {
			labels: data.map((item) => {
				return item.label;
			}),
			datasets: datasets,
		},
		options: multiSeriesBarOptions,
	});
}