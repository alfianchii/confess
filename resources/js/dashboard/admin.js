import { initDashboard } from "../dashboard";

initDashboard().then((res) => {
    const body = res;
    const userRole = body.authentication.data.role;

    if (userRole === "admin") {
        // Response JSON
        const allConfessions = body.chart.data.allConfessions;
        const allResponses = body.chart.data.allResponses;
        const allComments = body.chart.data.allComments;
        const allHistoryLogins = body.chart.data.allHistoryLogins;
        const yourComments = body.chart.data.yourComments;
        const yourHistoryLogins = body.chart.data.yourHistoryLogins;

        // Set options
        const optionsConfessionResponseCommentLogIn = {
            series: [
                {
                    name: "Pengakuan",
                    data: allConfessions.data.yAxis,
                },
                {
                    name: "Tanggapan",
                    data: allResponses.data.yAxis,
                },
                {
                    name: "Komentar",
                    data: allComments.data.yAxis,
                },
                {
                    name: "Log-in",
                    data: allHistoryLogins.data.yAxis,
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
                categories: allConfessions.data.xAxis,
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
                        ...allConfessions.data.yAxis,
                        ...allResponses.data.yAxis,
                        ...allComments.data.yAxis,
                        ...allHistoryLogins.data.yAxis
                    ) + 1,
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        const optionsYourComments = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
                zoom: {
                    enabled: false,
                },
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [
                {
                    name: "Komentar Kamu",
                    data: yourComments.yAxis,
                },
            ],
            colors: "#435ebe",
            xaxis: {
                categories: yourComments.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
                max: Math.max(...yourComments.yAxis) + 1,
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        const optionsYourHistoryLogins = {
            annotations: {
                position: "back",
            },
            dataLabels: {
                enabled: false,
            },
            chart: {
                type: "bar",
                height: 300,
                zoom: {
                    enabled: false,
                },
            },
            fill: {
                opacity: 1,
            },
            plotOptions: {},
            series: [
                {
                    name: "Log-in Kamu",
                    data: yourHistoryLogins.yAxis,
                },
            ],
            colors: "#435ebe",
            xaxis: {
                categories: yourHistoryLogins.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
                max: Math.max(...yourHistoryLogins.yAxis) + 1,
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        const optionsAllConfessionsGender = {
            series: [
                allConfessions.genders.male,
                allConfessions.genders.female,
            ],
            labels: ["Male", "Female"],
            colors: ["#435ebe", "#55c6e8"],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "30%",
                    },
                },
            },
        };
        const optionsAllResponsesGender = {
            series: [allResponses.genders.male, allResponses.genders.female],
            labels: ["Male", "Female"],
            colors: ["#435ebe", "#55c6e8"],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "30%",
                    },
                },
            },
        };
        const optionsAllCommentsGender = {
            series: [allComments.genders.male, allComments.genders.female],
            labels: ["Male", "Female"],
            colors: ["#435ebe", "#55c6e8"],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "30%",
                    },
                },
            },
        };
        const optionsAllHistoryLoginsGender = {
            series: [
                allHistoryLogins.genders.male,
                allHistoryLogins.genders.female,
            ],
            labels: ["Male", "Female"],
            colors: ["#435ebe", "#55c6e8"],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "30%",
                    },
                },
            },
        };

        // Instance chart
        const chartConfessionResponseCommentLogin = new ApexCharts(
            document.getElementById("chart-confession-response-comment-log-in"),
            optionsConfessionResponseCommentLogIn
        );
        const chartYourComments = new ApexCharts(
            document.querySelector("#chart-your-comments"),
            optionsYourComments
        );
        const chartYourHistoryLogins = new ApexCharts(
            document.querySelector("#chart-your-log-in"),
            optionsYourHistoryLogins
        );
        const chartAllConfessionsGender = new ApexCharts(
            document.getElementById("chart-confession-genders"),
            optionsAllConfessionsGender
        );
        const chartAllResponsesGender = new ApexCharts(
            document.getElementById("chart-response-genders"),
            optionsAllResponsesGender
        );
        const chartAllCommentsGender = new ApexCharts(
            document.getElementById("chart-comment-genders"),
            optionsAllCommentsGender
        );
        const chartAllHistoryLoginsGender = new ApexCharts(
            document.getElementById("chart-log-in-genders"),
            optionsAllHistoryLoginsGender
        );

        // Render
        chartConfessionResponseCommentLogin.render();
        chartYourComments.render();
        chartYourHistoryLogins.render();
        chartAllConfessionsGender.render();
        chartAllResponsesGender.render();
        chartAllCommentsGender.render();
        chartAllHistoryLoginsGender.render();
    }
});
