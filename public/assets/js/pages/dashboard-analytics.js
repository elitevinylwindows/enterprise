'use strict';
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(function () {
    floatchart();
  }, 500);
  // [ revenue-scroll ] start
  new SimpleBar(document.querySelector('.revenue-scroll'));
  new SimpleBar(document.querySelector('.customers-scroll'));
});

function floatchart() {
  (function () {
    var options1 = {
      chart: {
        type: 'area',
        height: 215,
        sparkline: {
          enabled: true
        }
      },
      colors: ['#673ab7', '#2196f3', '#f44336'],
      stroke: {
        curve: 'smooth',
        width: 2
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 80, 100]
        }
      },
      series: [
        {
          name: 'Youtube',
          data: [10, 90, 65, 85, 40, 80, 30]
        },
        {
          name: 'Facebook',
          data: [50, 30, 25, 15, 60, 10, 25]
        },
        {
          name: 'Twitter',
          data: [5, 50, 40, 55, 20, 40, 20]
        }
      ],
      tooltip: {
        fixed: {
          enabled: false
        },
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function (seriesName) {
              return '';
            }
          }
        },
        marker: {
          show: false
        }
      }
    };
    new ApexCharts(document.querySelector('#account-chart'), options1).render();
  })();
}
