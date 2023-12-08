import { initDashboard } from "../dashboard";

initDashboard().then((res) => {
    const body = res;
    const userRole = body.authentication.data.role;

    if (userRole === "admin") {
        // Response JSON
        const allConfessions = body.chart.data.allConfessions;
        const allResponses = body.chart.data.allResponses;
        const allComments = body.chart.data.allComments;
        const allLikes = body.chart.data.allLikes;
        const allHistoryLogins = body.chart.data.allHistoryLogins;
        const yourComments = body.chart.data.yourComments;
        const yourLikes = body.chart.data.yourLikes;
        const yourHistoryLogins = body.chart.data.yourHistoryLogins;

        // Set options
        const optionsStatistics = {
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
                    name: "Suka",
                    data: allLikes.data.yAxis,
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
                        ...allLikes.data.yAxis,
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
        const optionsYourLikes = {
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
                    name: "Suka",
                    data: yourLikes.yAxis,
                },
            ],
            colors: "#435ebe",
            xaxis: {
                categories: yourLikes.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
                max: Math.max(...yourLikes.yAxis) + 1,
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
        const optionsAllLikesGender = {
            series: [allLikes.genders.male, allLikes.genders.female],
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
        const chartStatistics = new ApexCharts(
            document.getElementById("chart-statistics"),
            optionsStatistics
        );
        const chartYourComments = new ApexCharts(
            document.getElementById("chart-your-comments"),
            optionsYourComments
        );
        const chartYourLikes = new ApexCharts(
            document.getElementById("chart-your-likes"),
            optionsYourLikes
        );
        const chartYourHistoryLogins = new ApexCharts(
            document.getElementById("chart-your-log-in"),
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
        const chartAllLikesGender = new ApexCharts(
            document.getElementById("chart-like-genders"),
            optionsAllLikesGender
        );
        const chartAllHistoryLoginsGender = new ApexCharts(
            document.getElementById("chart-log-in-genders"),
            optionsAllHistoryLoginsGender
        );

        // Render
        chartStatistics.render();
        chartYourComments.render();
        chartYourLikes.render();
        chartYourHistoryLogins.render();
        chartAllConfessionsGender.render();
        chartAllResponsesGender.render();
        chartAllCommentsGender.render();
        chartAllLikesGender.render();
        chartAllHistoryLoginsGender.render();
    }
});
