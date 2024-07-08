let ctx = document.getElementById('myChart').getContext('2d');
let labels = ['Same Day Sale', 'Sales within 15 days', 'Sales within 1 Month', 'Sales within 2 months', 'Sales after 2 months', 'Affiliate has no Sale'];
let colorHex = ['#FB3640', '#EFCA08', '#43AA8B', '#253D5B', '#253D7b', '#253D3D'];

let myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        datasets: [{
            data: [10, 10, 40, 20, 10, 10],
            backgroundColor: colorHex
        }],
        labels: labels
    },

    options: {
        responsive: true,

        legend: {
            position: 'left'
        },
        layout: {
            padding: {
                left: 100,
                right: 100,
            }
        },
        plugins: {
            datalabels: {
                color: '#fff',
                anchor: 'end',
                align: 'start',
                offset: -10,
                borderWidth: 2,
                borderColor: 'red',
                borderRadius: 25,
                backgroundColor: (context) => {
                    return context.dataset.backgroundColor;
                },
                font: {
                    weight: 'bold',
                    size: '30'
                },
                formatter: (value) => {
                    return value + ' %';
                }
            }
        }
    }
})