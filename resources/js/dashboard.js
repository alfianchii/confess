fetch(`/dashboard/responses-data`, {
    method: "GET",
    headers: {
        "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
    },
}).then(async (result) => {
    const body = await result.json();

    // Set user level
    const userLevel = body.authentication.data.level;

    // Response JSON
    const allResponses = body.chart.data.allResponses;
    const allComplaints = body.chart.data.allComplaints;
    const responses = body.chart.data.responses;
    const allResponsesGender = allResponses.genders;

    // Convert string to int
    for (const gender in allResponsesGender) {
        allResponsesGender[gender] = parseInt(allResponsesGender[gender]);
    }

    if (userLevel === "admin") {
        // Set options
        var optionsComplaintAndResponse = {
            series: [
                {
                    name: "Keluhan",
                    data: allComplaints.yAxis,
                },
                {
                    name: "Tanggapan",
                    data: allResponses.yAxis,
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
                categories: allComplaints.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        var optionsYourResponse = {
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
                    name: "Tanggapan Kamu",
                    data: responses.yAxis,
                },
            ],
            colors: "#435ebe",
            xaxis: {
                categories: responses.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
                max: Math.max(...allResponses.yAxis),
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        let optionsAllResponsesGender = {
            series: [allResponsesGender.male, allResponsesGender.female],
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
        var chartComplaintAndResponse = new ApexCharts(
            document.getElementById("chart-complaint"),
            optionsComplaintAndResponse
        );
        var chartYourResponses = new ApexCharts(
            document.querySelector("#chart-your-responses"),
            optionsYourResponse
        );
        var chartAllResponsesGender = new ApexCharts(
            document.getElementById("chart-visitors-profile"),
            optionsAllResponsesGender
        );

        // Render
        chartYourResponses.render();
        chartAllResponsesGender.render();
        chartComplaintAndResponse.render();
    } else if (userLevel === "officer") {
        // Set options
        var optionsYourResponses = {
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
                    name: "tanggapan",
                    data: responses.yAxis,
                },
            ],
            colors: "#435ebe",
            xaxis: {
                categories: responses.xAxis,
                type: "datetime",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                },
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy",
                },
            },
        };
        let optionsAllResponsesGender = {
            series: [allResponsesGender.male, allResponsesGender.female],
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
        var chartYourResponses = new ApexCharts(
            document.querySelector("#chart-your-responses"),
            optionsYourResponses
        );
        var chartAllResponsesGender = new ApexCharts(
            document.getElementById("chart-visitors-profile"),
            optionsAllResponsesGender
        );

        // Render
        chartYourResponses.render();
        chartAllResponsesGender.render();
    }
});
