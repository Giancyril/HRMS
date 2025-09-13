<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>


<div class="page-wrapper">
    <div class="message"></div>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Analytics</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Analytics</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
    <div class="card-body" style="background-color: white; color: black;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title">Employee Attendance Chart</h4>
            <div class="d-flex align-items-center">
                <select id="attendanceMonth" class="form-control" style="width: 150px; margin-right: 10px;">
                    <?php
                    $months = [
                        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                    ];
                    $currentMonth = date('m');
                    foreach ($months as $num => $name): ?>
                        <option value="<?php echo $num; ?>" <?php echo ($num == $currentMonth) ? 'selected' : ''; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select id="attendanceChartYear" class="form-control" style="width: 100px;">
                    <?php $currentYear = date('Y'); ?>
                    <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                        <option value="<?php echo $y; ?>" <?php echo ($y == $currentYear) ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div style="overflow-x: auto; max-height: 400px; padding-bottom: 15px;">
            <canvas id="attendanceChart" style="height: 300px;"></canvas>
            <div id="noAttendanceDataMessage" style="display: none; text-align: center; padding-top: 150px; color: black;">
                No attendance data available for the selected month.
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="background-color: white; color: black;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Monthly Attendance Report</h4>
                        <select id="attendanceYear" class="form-control" style="width: 120px;">
                            <?php $currentYear = date('Y'); ?>
                            <?php for ($y = $currentYear; $y >= 2020; $y--): ?>
                                <option value="<?php echo $y; ?>" <?php echo ($y == $currentYear) ? 'selected' : ''; ?>>
                                    <?php echo $y; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div style="height: 400px;">
                        <canvas id="monthlyAttendanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Employees by Department</h4>
                    <div style="overflow-x: auto; max-height: 400px; padding-bottom: 15px;">
                        <canvas id="departmentChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Employees by Designation</h4>
                    <div style="overflow-x: auto; max-height: 400px; padding-bottom: 15px;">
                        <canvas id="designationChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var attendanceChartInstance;
    const noDataMessage = document.getElementById('noAttendanceDataMessage');
    const attendanceCanvasElement = document.getElementById('attendanceChart');

    function loadAttendanceChart(year, month) {
        // Always hide the message and show the canvas before fetching
        if (noDataMessage) noDataMessage.style.display = 'none';
        if (attendanceCanvasElement) attendanceCanvasElement.style.display = 'block';

        if (attendanceChartInstance) {
            attendanceChartInstance.destroy();
        }

        if (!attendanceCanvasElement) {
            console.error("Critical error: Canvas element 'attendanceChart' not found.");
            return;
        }
        const ctx = attendanceCanvasElement.getContext('2d');

        // Use your base_url helper for constructing the API URL
        const apiUrl = `<?php echo base_url(); ?>attendance/getAttendanceChartData?year=${year}&month=${month}`;

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Check if data is empty and show message
                if (!Array.isArray(data) || data.length === 0) {
                    if (attendanceCanvasElement) attendanceCanvasElement.style.display = 'none';
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    return;
                }

                // If data exists, hide the message and show the chart
                if (noDataMessage) noDataMessage.style.display = 'none';
                if (attendanceCanvasElement) attendanceCanvasElement.style.display = 'block';

                const labels = data.map(item => item.full_name);
                const totalHours = data.map(item => item.total_seconds / 3600); // Assuming total_seconds is available

                // Initialize the chart
                attendanceChartInstance = new Chart(ctx, {
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
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Hours'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Employee Name'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: `Attendance for ${document.getElementById('attendanceMonth').options[document.getElementById('attendanceMonth').selectedIndex].text} ${year}`
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading attendance chart data:', error);
                if (attendanceCanvasElement) attendanceCanvasElement.style.display = 'none';
                if (noDataMessage) {
                    noDataMessage.style.display = 'block';
                    noDataMessage.innerHTML = `<p class="text-danger text-center" style="padding-top: 0;">Failed to load attendance chart data.</p>`;
                }
            });
    }

    // Event listeners for month and year changes for Attendance Chart
    const attendanceMonthSelect = document.getElementById('attendanceMonth');
    const attendanceYearSelect = document.getElementById('attendanceChartYear');

    if (attendanceMonthSelect && attendanceYearSelect) {
        attendanceMonthSelect.addEventListener('change', () => {
            loadAttendanceChart(attendanceYearSelect.value, attendanceMonthSelect.value);
        });
        attendanceYearSelect.addEventListener('change', () => {
            loadAttendanceChart(attendanceYearSelect.value, attendanceMonthSelect.value);
        });
    }

    // Initial load of the employee attendance chart
    if (attendanceMonthSelect && attendanceYearSelect) {
        loadAttendanceChart(attendanceYearSelect.value, attendanceMonthSelect.value);
    }


    // --- Monthly Attendance Report Chart ---
    var monthlyAttendanceChartInstance; // Variable to hold the chart instance

    function loadMonthlyAttendanceChart(year) {
        if (monthlyAttendanceChartInstance) {
            monthlyAttendanceChartInstance.destroy();
        }

        const monthlyAttendanceCanvas = document.getElementById('monthlyAttendanceChart');
        if (!monthlyAttendanceCanvas) {
            console.warn("Canvas element 'monthlyAttendanceChart' not found. Monthly attendance chart will not be rendered.");
            const parentDiv = document.querySelector('#monthlyAttendanceChart').parentElement;
            if (parentDiv) {
                parentDiv.innerHTML = '<p class="text-danger text-center" style="padding-top: 150px;">Error: Chart canvas not found.</p>';
            }
            return;
        }
        const ctxMonthly = monthlyAttendanceCanvas.getContext('2d');
        if (!ctxMonthly) {
            console.error("Failed to get 2D context for monthlyAttendanceChart.");
            return;
        }

        // Using fetch for consistency
        const monthlyApiUrl = `<?php echo base_url("attendance/getMonthlyAttendanceData"); ?>?year=${year}`;
        fetch(monthlyApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log("Monthly Attendance Data Received:", data);

                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No monthly attendance data available for the chart for year ' + year);
                    const parentDivForMessage = monthlyAttendanceCanvas.parentElement;
                    if (parentDivForMessage) {
                        parentDivForMessage.innerHTML = `<p class="text-center" style="padding-top: 150px; color: black;">No monthly attendance data available for chart for ${year}.</p>`;
                    }
                    return;
                }

                const labels = data.map(item => item.month); // Assuming 'month' is the key for month names
                const ontimeData = data.map(item => parseInt(item.ontime)); // Assuming 'ontime' is the key
                const lateData = data.map(item => parseInt(item.late)); // Assuming 'late' is the key

                // Chart.js responsiveness will handle the width/height based on parent container
                monthlyAttendanceCanvas.style.width = '100%'; // Ensure it takes full width of parent
                monthlyAttendanceCanvas.style.height = '100%'; // Ensure it takes full height of parent

                monthlyAttendanceChartInstance = new Chart(ctxMonthly, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Ontime',
                                data: ontimeData,
                                backgroundColor: 'rgba(90, 213, 250, 0.86)',
                                borderColor: 'rgba(90, 213, 250, 0.86)',
                                borderWidth: 1
                            },
                            {
                                label: 'Late',
                                data: lateData,
                                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: true,
                                title: {
                                    display: true,
                                    text: 'Month'
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxRotation: 0,
                                    minRotation: 0,
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Days'
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: `Monthly Attendance Overview for ${year}`
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error("Error fetching monthly attendance data:", status, error, xhr.responseText);
                const parentDivForMessage = monthlyAttendanceCanvas.parentElement;
                if (parentDivForMessage) {
                    parentDivForMessage.innerHTML = '<p class="text-danger">Failed to load monthly attendance chart. Please try again.</p>';
                }
            });
    }

    // Initial load of the monthly attendance chart for the default selected year
    const attendanceYearSelectMonthly = document.getElementById('attendanceYear');
    if (attendanceYearSelectMonthly) {
        loadMonthlyAttendanceChart(attendanceYearSelectMonthly.value);

        // Event listener for year change
        attendanceYearSelectMonthly.addEventListener('change', function() {
            var selectedYear = $(this).val();
            loadMonthlyAttendanceChart(selectedYear);
        });
    }


    // --- Chart: Employees by Department ---
    const departmentCanvasElement = document.getElementById('departmentChart');
    if (departmentCanvasElement) {
        const ctxDepartment = departmentCanvasElement.getContext('2d');
        const departmentApiUrl = '<?php echo base_url(); ?>dashboard/getDepartmentChartData';

        fetch(departmentApiUrl)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No department data available for the chart.');
                    const parentDiv = departmentCanvasElement.parentElement;
                    if (parentDiv) {
                        parentDiv.innerHTML = '<p class="text-center" style="padding-top: 150px; color: black;">No department data available for chart.</p>';
                    }
                    return;
                }

                const filteredData = data.filter(item => item.employee_count > 0);

                if (filteredData.length === 0) {
                    console.warn('No departments with employees found for the chart.');
                    const parentDiv = departmentCanvasElement.parentElement;
                    if (parentDiv) {
                        parentDiv.innerHTML = '<p class="text-center" style="padding-top: 150px; color: black;">No departments with employees to display.</p>';
                    }
                    return;
                }

                const labels = filteredData.map(item => item.department_name);
                const employeeCounts = filteredData.map(item => item.employee_count);

                // Dynamic Canvas Width Calculation for Department Chart
                const baseWidthPerDepartment = 180; // Adjust for department name length
                const minChartContentWidth = labels.length * baseWidthPerDepartment;

                const parentContainer = departmentCanvasElement.parentElement;
                const parentWidth = parentContainer ? parentContainer.clientWidth : (window.innerWidth * 0.9);

                const finalCanvasWidth = Math.max(minChartContentWidth, parentWidth);
                departmentCanvasElement.style.width = `${finalCanvasWidth}px`;
                departmentCanvasElement.style.height = `300px`;

                new Chart(ctxDepartment, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of Employees',
                            backgroundColor: 'rgba(90, 186, 245, 0.69)',
                            borderColor: 'rgba(90, 186, 245, 0.69)',
                            borderWidth: 1.5,
                            data: employeeCounts
                        }]
                    },
                    options: {
                        responsive: false, // Set to false as we are manually controlling width
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
                                    maxRotation: 45, // Allow some rotation
                                    minRotation: 0,
                                    autoSkip: false // Display all labels, rely on scroll
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
                const errorMessage = 'Failed to load department chart data.';
                const parentDiv = departmentCanvasElement.parentElement;
                if (parentDiv) {
                    parentDiv.innerHTML = `<p class="text-danger text-center" style="padding-top: 150px;">${errorMessage}</p>`;
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
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No designation data available for the chart.');
                    const parentDiv = designationCanvasElement.parentElement;
                    if (parentDiv) {
                        parentDiv.innerHTML = '<p class="text-center" style="padding-top: 150px; color: black;">No designation data available for chart.</p>';
                    }
                    return;
                }

                const filteredData = data.filter(item => item.employee_count > 0);

                if (filteredData.length === 0) {
                    console.warn('No designations with employees found for the chart.');
                    const parentDiv = designationCanvasElement.parentElement;
                    if (parentDiv) {
                        parentDiv.innerHTML = '<p class="text-center" style="padding-top: 150px; color: black;">No designations with employees to display.</p>';
                    }
                    return;
                }

                const labels = filteredData.map(item => item.designation_name);
                const employeeCounts = filteredData.map(item => item.employee_count);

                // Dynamic Canvas Width Calculation for Designation Chart
                const baseWidthPerDesignation = 200; // Increased multiplier for potentially longer designation names
                const minChartContentWidth = labels.length * baseWidthPerDesignation;

                const parentContainer = designationCanvasElement.parentElement;
                const parentWidth = parentContainer ? parentContainer.clientWidth : (window.innerWidth * 0.9);

                const finalCanvasWidth = Math.max(minChartContentWidth, parentWidth);
                designationCanvasElement.style.width = `${finalCanvasWidth}px`;
                designationCanvasElement.style.height = `300px`;

                new Chart(ctxDesignation, {
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
                        responsive: false, // Set to false as we are manually controlling width
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
                                    maxRotation: 45, // Allow some rotation
                                    minRotation: 0,
                                    autoSkip: false // Display all labels, rely on scroll
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
                const errorMessage = 'Failed to load designation chart data.';
                const parentDiv = designationCanvasElement.parentElement;
                if (parentDiv) {
                    parentDiv.innerHTML = `<p class="text-danger text-center" style="padding-top: 150px;">${errorMessage}</p>`;
                }
            });
    } else {
        console.warn("Canvas element 'designationChart' not found. Designation chart will not be rendered.");
    }

}); // End of DOMContentLoaded
</script>

<?php $this->load->view('backend/footer'); ?>