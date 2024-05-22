import "./bootstrap";
import Chart from "chart.js/auto";
import 'chartjs-adapter-dayjs-4/dist/chartjs-adapter-dayjs-4.esm';
import zoomPlugin from 'chartjs-plugin-zoom';

(async function () {
    const data = window.data;
    console.log(window.data);
    Chart.register(zoomPlugin);
    new Chart(document.getElementById("acquisitions"), {
        type: "line",
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                // intersect: false,
            },
            plugins: {
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                    },
                    zoom: {
                        wheel: {
                            enabled: true,
                        },
                        mode: 'x',
                    }
                },
            },
            // stacked: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    // grid line settings
                    grid: {
                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                    },
                },
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                        displayFormats: {
                            hour: 'dd HH:mm'
                        }
                        // parser: (date) => { return Date.parse(date); }
                    },
                    grid: {
                        color: function(context) {
                            console.debug(context);
                            if (context.tick.label?.includes('00:00')) {
                                return '#ff0000';
                            }

                            return '#66666611';
                        }
                    }
                }
            },
        },
        data: {
            labels: data.map((row) => {
                const date = new Date(row.created_at);

                // return `${date.getHours()}:${date.getMinutes()}`;
                // return (new Intl.DateTimeFormat('en', {
                //     year:'numeric',
                //     month:'2-digit',
                //     day:'2-digit',
                //     hour:'2-digit',
                //     minute:'2-digit',
                //     hour12: false
                // }).format(date));
                return Date.parse(date);
            }),
            datasets: [
                {
                    label: "Players Online by time",
                    data: data.map((row) => row.players_online),
                },
                {
                    label: "Alliance %",
                    data: data.map((row) => row.alliance_count),
                    yAxisID: 'y1',
                },
                {
                    label: "Horde %",
                    data: data.map((row) => row.horde_count),
                    yAxisID: 'y1',
                },
            ],
        },
    });
})();
