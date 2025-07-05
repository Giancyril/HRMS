<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- Main wrapper for the page content -->
<div class="page-wrapper">
    <!-- Message display area (e.g., for success/error messages) -->
    <div class="message"></div>

    <!-- Page title and breadcrumbs -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Analytics Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Analytics</li>
            </ol>
        </div>
    </div>

    <!-- Container for the main content, including charts -->
    <div class="container-fluid">
        <!-- Employee Attendance Chart -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="background-color: white; color: black;">
                        <h4 class="card-title">Employee Attendance Chart</h4>
                        <div style="height: 350px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Attendance Report Chart -->
        <div class="row"> <!-- Added a row wrapper for consistency -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="background-color: white; color: black;">
                        <h4 class="card-title">Monthly Attendance Report
                            <select id="attendanceYear" class="form-control pull-right" style="width: 120px;">
                                <?php $currentYear = date('Y'); ?>
                                <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($y == $currentYear) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </h4>
                        <div style="height: 350px;">
                            <canvas id="monthlyAttendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees by Department Chart -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Employees by Department</h4>
                        <div style="height: 350px;">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees by Designation Chart -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Employees by Designation</h4>
                        <div style="height: 350px;">
                            <canvas id="designationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for chart initialization and dynamic loading -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Employee Attendance Chart ---
    const attendanceCanvasElement = document.getElementById('attendanceChart');
    if (attendanceCanvasElement) {
        const ctx = attendanceCanvasElement.getContext('2d');
        const apiUrl = '<?php echo base_url(); ?>attendance/getAttendanceChartData';

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error('Error fetching attendance data:', data.error);
                    ctx.font = '20px Arial';
                    ctx.fillStyle = 'red';
                    ctx.textAlign = 'center';
                    ctx.fillText('Error: ' + data.error, ctx.canvas.width / 2, ctx.canvas.height / 2);
                    return;
                }

                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No attendance data available for the chart.');
                    ctx.font = '20px Arial';
                    ctx.fillStyle = 'black'; // Changed to black for visibility on white background
                    ctx.textAlign = 'center';
                    ctx.fillText('No attendance data available for chart.', ctx.canvas.width / 2, ctx.canvas.height / 2);
                    return;
                }

                const labels = data.map(item => item.full_name);
                const totalHours = data.map(item => item.total_seconds / 3600);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Working Hours',
                            data: totalHours,
                            backgroundColor: 'rgba(33, 150, 243, 0.8)',
                            borderColor: 'rgba(33, 150, 243, 0.8)',
                            borderWidth: 1.5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        backgroundColor: 'white',
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Working Hours',
                                    color: 'rgba(73, 80, 87, 1)'
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)'
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)',
                                    drawBorder: false,
                                    drawOnChartArea: true,
                                    drawTicks: false
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Employee Name',
                                    color: 'rgba(73, 80, 87, 1)',
                                    padding: { top: 20 }
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)'
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: {
                                    color: 'rgba(73, 80, 87, 1)',
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += context.parsed.y.toFixed(2) + ' hours';
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading attendance chart data:', error);
                const errorMessage = 'Failed to load attendance chart data.';
                ctx.font = '20px Arial';
                ctx.fillStyle = 'red';
                ctx.textAlign = 'center';
                ctx.fillText(errorMessage, ctx.canvas.width / 2, ctx.canvas.height / 2);
            });
    } else {
        console.warn("Canvas element 'attendanceChart' not found. Chart will not be rendered.");
    }


    // --- Monthly Attendance Report Chart ---
    var monthlyAttendanceChartInstance; // Variable to hold the chart instance

    function loadMonthlyAttendanceChart(year) {
        // Destroy existing chart if it exists to prevent multiple charts on updates
        if (monthlyAttendanceChartInstance) {
            monthlyAttendanceChartInstance.destroy();
        }

        const monthlyAttendanceCanvas = document.getElementById('monthlyAttendanceChart');
        if (!monthlyAttendanceCanvas) {
            console.warn("Canvas element 'monthlyAttendanceChart' not found. Monthly attendance chart will not be rendered.");
            return; // Exit if canvas is not found
        }
        const ctxMonthly = monthlyAttendanceCanvas.getContext('2d');
        if (!ctxMonthly) {
            console.error("Failed to get 2D context for monthlyAttendanceChart.");
            return; // Exit if context cannot be obtained
        }

        $.ajax({
            url: '<?php echo base_url("attendance/getMonthlyAttendanceData"); ?>', // Call the controller function
            type: 'GET',
            dataType: 'json',
            data: { year: year }, // Pass the selected year to the backend
            success: function(data) {
                console.log("Monthly Attendance Data Received:", data); // Debug: Check data structure

                // Prepare labels and data for the chart
                const labels = data.map(item => item.month); // e.g., ["Jan", "Feb", ...]
                const ontimeData = data.map(item => parseInt(item.ontime)); // Ensure numbers for calculation
                const lateData = data.map(item => parseInt(item.late)); // Ensure numbers for calculation

                monthlyAttendanceChartInstance = new Chart(ctxMonthly, {
                    type: 'bar', // Bar chart type
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Ontime', // Label for ontime data
                                data: ontimeData,
                                // Using the color from the "Monthly Attendance Overview" chart
                                backgroundColor: 'rgba(90, 180, 250, 0.8)' , // Lighter teal/turquoise for ontime
                                borderColor: 'rgba(90, 180, 250, 0.8)',
                                borderWidth: 1
                            },
                            {
                                label: 'Late', // Label for late data
                                data: lateData,
                                // Using the color from the "Monthly Attendance Overview" chart
                                backgroundColor: 'rgba(255, 99, 132, 0.8)', // Pink/Red for late
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false, // Important for custom height/width
                        scales: {
                            x: {
                                stacked: true, // Make bars stacked on the x-axis, as seen in image_1e0a27.png
                                title: {
                                    display: true,
                                    text: 'Month' // Label for x-axis
                                }
                            },
                            y: {
                                stacked: true, // Make bars stacked on the y-axis, as seen in image_1e0a27.png
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Days' // Label for y-axis
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Monthly Attendance Overview' // Chart title
                            },
                            legend: {
                                display: true,
                                position: 'top' // Position legend at the top, as seen in image_1e0a27.png
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching monthly attendance data:", status, error, xhr.responseText);
                // Display the specific error message as seen in image_1e06de.png
                // Ensure the canvas parent exists and is not null
                const parentDiv = $('#monthlyAttendanceChart').parent();
                if (parentDiv.length) {
                    parentDiv.html('<p class="text-danger">Failed to load monthly attendance chart. Please try again.</p>');
                } else {
                    console.error("Could not find parent div for monthlyAttendanceChart to display error message.");
                }
            }
        });
    }

    // Initial load of the monthly attendance chart for the default selected year
    loadMonthlyAttendanceChart($('#attendanceYear').val());

    // Event listener for year change
    $('#attendanceYear').on('change', function() {
        var selectedYear = $(this).val();
        loadMonthlyAttendanceChart(selectedYear);
    });


    // --- Chart: Employees by Department ---
    const departmentCanvasElement = document.getElementById('departmentChart');
    if (departmentCanvasElement) {
        const ctxDepartment = departmentCanvasElement.getContext('2d');
        const departmentApiUrl = '<?php echo base_url(); ?>dashboard/getDepartmentChartData';

        fetch(departmentApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No department data available for the chart.');
                    ctxDepartment.font = '20px Arial';
                    ctxDepartment.fillStyle = 'black';
                    ctxDepartment.textAlign = 'center';
                    ctxDepartment.fillText('No department data available for chart.', ctxDepartment.canvas.width / 2, ctxDepartment.canvas.height / 2);
                    return;
                }

                // Filter data to only include departments with at least one employee
                const filteredData = data.filter(item => item.employee_count > 0);

                if (filteredData.length === 0) {
                    console.warn('No departments with employees found for the chart.');
                    ctxDepartment.font = '20px Arial';
                    ctxDepartment.fillStyle = 'black';
                    ctxDepartment.textAlign = 'center';
                    ctxDepartment.fillText('No departments with employees to display.', ctxDepartment.canvas.width / 2, ctxDepartment.canvas.height / 2);
                    return;
                }

                const labels = filteredData.map(item => item.department_name);
                const employeeCounts = filteredData.map(item => item.employee_count);

                new Chart(ctxDepartment, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Employees',
                            backgroundColor: 'rgba(98, 207, 244, 0.8)', 
                            borderColor: 'rgba(98, 207, 244, 0.8)',
                            borderWidth: 1.5,
                            data: employeeCounts
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees',
                                    color: 'rgba(73, 80, 87, 1)'
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)',
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)',
                                    drawBorder: false,
                                    drawOnChartArea: true,
                                    drawTicks: false
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Department',
                                    color: 'rgba(73, 80, 87, 1)',
                                    padding: { top: 20 }
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)',
                                    maxRotation: 0,
                                    minRotation: 0,
                                    autoSkip: false
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(73, 80, 87, 1)'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching department chart data:', error);
                const parentDiv = $('#departmentChart').parent();
                if (parentDiv.length) {
                    parentDiv.html('<p class="text-danger">Failed to load department chart data.</p>');
                } else {
                    console.error("Could not find parent div for departmentChart to display error message.");
                }
            });
    } else {
        console.warn("Canvas element 'departmentChart' not found. Department chart will not be rendered.");
    }


    // --- Chart: Employees by Designation ---
    const designationCanvasElement = document.getElementById('designationChart');
    if (designationCanvasElement) {
        const ctxDesignation = designationCanvasElement.getContext('2d');
        const designationApiUrl = '<?php echo base_url(); ?>dashboard/getDesignationChartData';

        fetch(designationApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No designation data available for the chart.');
                    ctxDesignation.font = '20px Arial';
                    ctxDesignation.fillStyle = 'black'; // Changed to black for visibility on white background
                    ctxDesignation.textAlign = 'center';
                    ctxDesignation.fillText('No designation data available for chart.', ctxDesignation.canvas.width / 2, ctxDesignation.canvas.height / 2);
                    return;
                }

                // Filter data to only include designations with at least one employee
                const filteredData = data.filter(item => item.employee_count > 0);

                if (filteredData.length === 0) {
                    console.warn('No designations with employees found for the chart.');
                    ctxDesignation.font = '20px Arial';
                    ctxDesignation.fillStyle = 'black'; // Changed to black for visibility on white background
                    ctxDesignation.textAlign = 'center';
                    ctxDesignation.fillText('No designations with employees to display.', ctxDesignation.canvas.width / 2, ctxDesignation.canvas.height / 2);
                    return;
                }

                const labels = filteredData.map(item => item.designation_name);
                const employeeCounts = filteredData.map(item => item.employee_count);

                new Chart(ctxDesignation, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Employees',
                            data: employeeCounts,
                            backgroundColor: 'rgba(33, 150, 243, 0.8)',
                            borderColor: 'rgba(33, 150, 243, 0.8)',
                            borderWidth: 1.5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Employees',
                                    color: 'rgba(73, 80, 87, 1)'
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)',
                                    stepSize: 1
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)',
                                    drawBorder: false,
                                    drawOnChartArea: true,
                                    drawTicks: false
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Designation',
                                    color: 'rgba(73, 80, 87, 1)',
                                    padding: { top: 20 }
                                },
                                ticks: {
                                    color: 'rgba(82, 98, 107, 1)',
                                    maxRotation: 0,
                                    minRotation: 0,
                                    autoSkip: false
                                },
                                grid: {
                                    display: false,
                                    drawBorder: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgba(73, 80, 87, 1)'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching designation chart data:', error);
                const parentDiv = $('#designationChart').parent();
                if (parentDiv.length) {
                    parentDiv.html('<p class="text-danger">Failed to load designation chart data.</p>');
                } else {
                    console.error("Could not find parent div for designationChart to display error message.");
                }
            });
    } else {
        console.warn("Canvas element 'designationChart' not found. Designation chart will not be rendered.");
    }
});
</script>
<?php $this->load->view('backend/footer'); ?>
