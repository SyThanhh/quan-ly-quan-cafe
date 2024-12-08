// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.font.family = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.color = '#858796';

// Number formatting function
function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// jQuery Document Ready Function
$(document).ready(function() {
  // Column Chart with Multiple Axes Example
  var ctx = $("#myColumnChart"); // Use jQuery to select the canvas element
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Earnings",
          backgroundColor: "rgba(78, 115, 223, 1)",
          borderColor: "rgba(78, 115, 223, 1)",
          data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
          yAxisID: 'y-axis-1'
        },
        {
          label: "Profits",
          backgroundColor: "rgba(28, 200, 138, 1)",
          borderColor: "rgba(28, 200, 138, 1)",
          data: [0, 8000, 4000, 12000, 8000, 16000, 12000, 20000, 16000, 24000, 20000, 32000],
          yAxisID: 'y-axis-2'
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 12
          }
        },
        'y-axis-1': {
          type: 'linear',
          position: 'left',
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            callback: function(value) {
              return '$' + number_format(value);
            }
          },
          grid: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        },
        'y-axis-2': {
          type: 'linear',
          position: 'right',
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            callback: function(value) {
              return '$' + number_format(value);
            }
          },
          grid: {
            display: false
          }
        }
      },
      plugins: {
        legend: {
          display: true
        },
        tooltip: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFont: { size: 14 },
          borderColor: '#dddfeb',
          borderWidth: 1,
          padding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem) {
              var datasetLabel = tooltipItem.dataset.label || '';
              return datasetLabel + ': $' + number_format(tooltipItem.raw);
            }
          }
        }
      }
    }
  });
});
