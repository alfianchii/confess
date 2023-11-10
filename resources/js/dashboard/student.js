import { initDashboard } from "../dashboard";

initDashboard().then((res) => {
    // Response
    const body = res;

    // Set user role
    const userRole = body.authentication.data.role;

    if (userRole === "student") {
        // Response JSON
        const yourConfessions = body.chart.data.yourConfessions;
        const yourResponses = body.chart.data.yourResponses;
        const yourComments = body.chart.data.yourComments;
        const yourHistoryLogins = body.chart.data.yourHistoryLogins;

        // Set options
        const optionsYourConfessionResponseCommentLogIn = {
            series: [
                {
                    name: "Pengakuan",
                    data: yourConfessions.yAxis,
                },
                {
                    name: "Tanggapan",
                    data: yourResponses.yAxis,
                },
                {
                    name: "Komentar",
                    data: yourComments.yAxis,
                },
                {
                    name: "Log-in",
                    data: yourHistoryLogins.yAxis,
                },
            ],
            chart: {
                height: 350,
                type: "area",
                zoom: {
                    enabled: false,
                },
                stacked: false,
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                categories: yourResponses.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
                max:
                    Math.max(
                        ...yourConfessions.yAxis,
                        ...yourResponses.yAxis,
                        ...yourComments.yAxis,
                        ...yourHistoryLogins.yAxis
                    ) + 1,
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };

        // Instance chart
        const chartYourResponseCommentLogIn = new ApexCharts(
            document.getElementById(
                "chart-your-confession-response-comment-log-in"
            ),
            optionsYourConfessionResponseCommentLogIn
        );

        // Render
        chartYourResponseCommentLogIn.render();
    }
});
