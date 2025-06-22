 </div>

    <footer class="footer">
                © <?php echo date("Y"); ?> Optima HR.
                <span class="float-right">
                    <a href="YOUR_FACEBOOK_URL" class="text-muted m-r-10"><i class="fa fa-facebook"></i></a>
                    <a href="YOUR_TWITTER_URL" class="text-muted m-r-10"><i class="fa fa-twitter"></i></a>
                     <a href="YOUR_GOOGLE_URL" class="text-muted m-r-10"><i class="fa fa-google"></i></a>
                    <a href="YOUR_INSTAGRAM_URL" class="text-muted m-r-10"><i class="fa fa-instagram"></i></a>
                    <a href="<?php echo base_url(); ?>dashboard/privacy_policy" class="text-muted">Privacy Policy</a>
                </span>
            </footer>

        </div>
</div>


    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>    
    
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/jsgrid/db.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jsgrid/dist/jsgrid.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    
    <script src="<?php echo base_url(); ?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>                                
    <script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>    
    <script src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/multiselect/js/jquery.multi-select.js"></script>
    

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/calendar/dist/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/calendar/dist/cal-init.js"></script>

    <script type="text/javascript">
        $(function () {
            $('.mydatetimepicker').datepicker({
            format: "mm-yyyy",
            viewMode: "years", 
            minViewMode: "months"  
            });
        });
        $(function () {
            $('.mydatetimepickerFull').datepicker({
            format: "yyyy-mm-dd"  
            });
        });
    </script>      
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());
});
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });         
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });

    
    $(function() {
    $('#datetimepicker2').datetimepicker({
      language: 'en',
      pick12HourFormat: true
    });
  });
  
    $(".select2").select2();
    </script>
<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);           
                $(".message").fadeIn('fast').delay(2000).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},2000);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>     

    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const apiUrl = '<?php echo base_url(); ?>attendance/getAttendanceChartData';

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error fetching attendance data:', data.error);
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                console.warn('No attendance data available for the chart.');
                // Display a message on the canvas if no data
                ctx.font = '20px Arial';
                ctx.fillStyle = 'white';
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
                        backgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            borderColor: 'rgba(0, 169, 224, 1)',
                        borderWidth: 1.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    backgroundColor: 'white', // This will set the chart background color
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
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        },
                        x: {
                           title: {
                             display: true,
                             text: 'Employee Name',
                             color: 'rgba(73, 80, 87, 1)',
                             padding: { top: 20 } // Add this line
                        },
                          ticks: {
                            color: 'rgba(82, 98, 107, 1)'
                        },
                          grid: {
                            color: 'rgba(255, 255, 255, 0.2)'
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

$(document).ready(function() {
    var monthlyAttendanceChart; // Variable to hold the chart instance

    function loadMonthlyAttendanceChart(year) {
        // Destroy existing chart if it exists to prevent multiple charts on updates
        if (monthlyAttendanceChart) {
            monthlyAttendanceChart.destroy();
        }

        $.ajax({
            url: '<?php echo base_url("attendance/getMonthlyAttendanceData"); ?>', // Call the controller function
            type: 'GET',
            dataType: 'json',
            data: { year: year }, // Pass the selected year to the backend
            success: function(data) {
                console.log("Attendance Data Received:", data); // Debug: Check data structure

                // Prepare labels and data for the chart
                const labels = data.map(item => item.month); // e.g., ["Jan", "Feb", ...]
                const ontimeData = data.map(item => parseInt(item.ontime)); // Ensure numbers for calculation
                const lateData = data.map(item => parseInt(item.late)); // Ensure numbers for calculation

                const ctx = document.getElementById('monthlyAttendanceChart').getContext('2d');
                monthlyAttendanceChart = new Chart(ctx, {
                    type: 'bar', // Bar chart type
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Ontime', // Label for ontime data
                                data: ontimeData,
                                // Using the color from the "Monthly Attendance Overview" chart
                                backgroundColor: 'rgba(75, 192, 192, 0.8)', // Lighter teal/turquoise for ontime
                                borderColor: 'rgba(75, 192, 192, 1)',
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
                $('#monthlyAttendanceChart').parent().html('<p class="text-danger">Failed to load attendance chart. Please try again.</p>');
            }
        });
    }

    // Initial load of the chart for the default selected year (e.g., 2019 as shown in image_1da8aa.png)
    loadMonthlyAttendanceChart($('#attendanceYear').val());

    // Event listener for year change
    $('#attendanceYear').on('change', function() {
        var selectedYear = $(this).val();
        loadMonthlyAttendanceChart(selectedYear);
    });
});

    // Chart: Employees by Department
    const departmentCanvasElement = document.getElementById('departmentChart');
    if (departmentCanvasElement) {
        const ctxDepartment = departmentCanvasElement.getContext('2d');
        const departmentApiUrl = '<?php echo base_url(); ?>dashboard/getDepartmentChartData';

        fetch(departmentApiUrl)
            .then(response => response.json())
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
                            data: employeeCounts,
                            backgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            borderColor: 'rgba(0, 169, 224, 1)',
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
                                    color: 'rgba(0, 0, 0, 0.1)'
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
            .catch(error => console.error('Error fetching department chart data:', error));
    }

    // Chart: Employees by Designation
    const designationCanvasElement = document.getElementById('designationChart');
    if (designationCanvasElement) {
        const ctxDesignation = designationCanvasElement.getContext('2d');
        const designationApiUrl = '<?php echo base_url(); ?>dashboard/getDesignationChartData';

        fetch(designationApiUrl)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn('No designation data available for the chart.');
                    ctxDesignation.font = '20px Arial';
                    ctxDesignation.fillStyle = 'black';
                    ctxDesignation.textAlign = 'center';
                    ctxDesignation.fillText('No designation data available for chart.', ctxDesignation.canvas.width / 2, ctxDesignation.canvas.height / 2);
                    return;
                }

                // Filter data to only include designations with at least one employee
                const filteredData = data.filter(item => item.employee_count > 0);

                if (filteredData.length === 0) {
                    console.warn('No designations with employees found for the chart.');
                    ctxDesignation.font = '20px Arial';
                    ctxDesignation.fillStyle = 'black';
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
                            backgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            color: 'rgba(0, 169, 224, 1)',
                            hoverBackgroundColor: 'rgba(0, 169, 224, 1)', 
                            borderColor: 'rgba(0, 169, 224, 1)',
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
                                    color: 'rgba(0, 0, 0, 0.1)'
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
            .catch(error => console.error('Error fetching designation chart data:', error));
    }
});
</script>