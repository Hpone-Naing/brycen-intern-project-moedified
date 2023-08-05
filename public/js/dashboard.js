async function fetchApi(url) {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'url': '/payment',
            },
        });
        const data = await response.json();
        employeeId = data.data;

        return employeeId;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    console.log("start");
    console.log("session " + sessionStorage.getItem('logedinEmployeeRole'));
    fetchApi("api/employees/get-active-employees")
        .then(results => {
            console.log('Result:', results);
            maleFemaleAnalytics(results);
            experienceAnalytics(results);
            levelAnalytics(results);
            employmentTypeAnalytics(results);
        })
        .catch(error => {
            console.error('Error:', error);
        });

});

/**
 * Gender Analytics
 */

function maleFemaleAnalytics(results) {
    maleCount = 0;
    femaleCount = 0;
    results.forEach(function(employee) {
        console.log(employee.gender);
        if(employee.gender == "Male") {
            maleCount ++;
        } else {
            femaleCount ++;
        }
    });
    let total = maleCount + femaleCount;
    let calcMalePercentage = maleCount / total * 100;
    let calcFemalePercentage = femaleCount / total * 100;
    let label = (maleCount > femaleCount) ? 'Male ' + calcMalePercentage + '%' : 'Female' + calcFemalePercentage + '%';
    let cardColor, headingColor, axisColor, shadeColor, borderColor;
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    // Male Female Statistics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#maleFemaleStatisticChart'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['Male', 'Female'],
            series: [maleCount, femaleCount],
            colors: [config.colors.primary, config.colors.danger],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: calcMalePercentage + '% / ' + calcFemalePercentage + "%",
                                formatter: function (w) {
                                    return "M / F";
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
}
/**
 *  / Gender Analytics
 */


/**
 * Employment type Analytics
 */

function employmentTypeAnalytics(results) {
    parmanentCount = 0;
    probationCount = 0;
    results.forEach(function(employee) {
        console.log(employee.gender);
        if(employee.employment_type == 1) {
            probationCount ++;
        } else {
            parmanentCount ++;
        }
    });
    let total = parmanentCount + probationCount;
    let calcMalePercentage = parmanentCount / total * 100;
    let calcFemalePercentage = probationCount / total * 100;
    let label = (parmanentCount > probationCount) ? 'Male ' + calcMalePercentage + '%' : 'Female' + calcFemalePercentage + '%';
    let cardColor, headingColor, axisColor, shadeColor, borderColor;
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    // Male Female Statistics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#employmentTypeStatisticChart'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['Parmanent', 'Probation'],
            series: [parmanentCount, probationCount],
            colors: [config.colors.success, config.colors.primary],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: calcMalePercentage + '% / ' + calcFemalePercentage + "%",
                                formatter: function (w) {
                                    return "P / C";
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
}
/**
 *  / Employment Type Analytics
 */

/**
 * Working experience Analytics
 */

function experienceAnalytics(results) {
    const experience = {
        "lessthan1" : 0,
        "between1and3" : 0,
        "between5and7" : 0,
        "above7" : 0,
    };

    let currentYear = new Date().getFullYear();

    results.forEach(function(employee) {
        console.log("cretaed_at " + employee.created_at);
        employmentDate = new Date(employee.created_at);
        workingYear = currentYear - employmentDate.getFullYear();
        console.log("working year" + workingYear);
        if(workingYear < 1) {
            experience.lessthan1 ++;
        } else if(1 <= workingYear <= 3) {
            experience.between1and3 ++;
        } else if(5 <= workingYear <= 7) {
            experience.between5and7 ++;
        } else {
            experience.above7 ++;
        }
    });
    let cardColor, headingColor, axisColor, shadeColor, borderColor;
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    document.getElementById('expLessThan1').innerText = experience.lessthan1;
    document.getElementById('expBetween1And3').innerText = experience.between1and3;
    document.getElementById('expBetween5And7').innerText = experience.between5and7;
    document.getElementById('expAbove7').innerText = experience.above7;
    // experience analytics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#experienceAnalytics'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['above 7', 'between 5 and 7', 'between 1 and 3', 'less than 1'],
            series: [experience.above7, experience.between5and7, experience.between1and3, experience.lessthan1],
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: 'Total',
                                formatter: function (w) {
                                    return  + results.length;
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
}
/**
 *  / Working experience Analytics
 */



/**
 * Working Environmnet Level Analytics
 */

function levelAnalytics(results) {
    const experience = {
        "generalManager" : 0,
        "manager" : 0,
        "admin" : 0,
        "employee" : 0,
    };


    results.forEach(function(employee) {
        role = employee.role_id;
        if(role == 4) {
            experience.generalManager ++;
        } else if(role == 3) {
            experience.manager ++;
        } else if(role == 2) {
            experience.admin ++;
        } else {
            experience.employee ++;
        }
    });
    let cardColor, headingColor, axisColor, shadeColor, borderColor;
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;

    document.getElementById('totalGM').innerText = experience.generalManager;
    document.getElementById('totalManager').innerText = experience.manager;
    document.getElementById('totalAdmin').innerText = experience.admin;
    document.getElementById('totalEmployee').innerText = experience.employee;
    // experience analytics Chart
    // --------------------------------------------------------------------
    const chartOrderStatistics = document.querySelector('#LevelAnalytics'),
        orderChartConfig = {
            chart: {
                height: 165,
                width: 130,
                type: 'donut'
            },
            labels: ['Employees', 'Admins', 'Managers', 'General Managers'],
            series: [experience.employee, experience.admin, experience.manager, experience.generalManager],
            colors: [config.colors.primary, config.colors.secondary, config.colors.info, config.colors.success],
            stroke: {
                width: 5,
                colors: cardColor
            },
            dataLabels: {
                enabled: false,
                formatter: function (val, opt) {
                    return parseInt(val) + '';
                }
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: 0,
                    bottom: 0,
                    right: 15
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            value: {
                                fontSize: '1.5rem',
                                fontFamily: 'Public Sans',
                                color: headingColor,
                                offsetY: -15,
                                formatter: function (val) {
                                    return parseInt(val) + '';
                                }
                            },
                            name: {
                                offsetY: 20,
                                fontFamily: 'Public Sans'
                            },
                            total: {
                                show: true,
                                fontSize: '0.8125rem',
                                color: axisColor,
                                label: 'Total',
                                formatter: function (w) {
                                    return  + results.length;
                                }
                            }
                        }
                    }
                }
            }
        };
    if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
        const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
        statisticsChart.render();
    }
}
/**
 *  / Working Environment Level Analytics
 */