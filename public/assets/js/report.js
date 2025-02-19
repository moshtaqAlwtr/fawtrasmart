
    function showCharts() {
        document.getElementById('charts-container').style.display = 'block';
        createPieChart();
        createBarChart();
    }

    function createPieChart() {
        var ctx = document.getElementById('pieChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['مدفوعة', 'غير مدفوعة', 'مرجع'],
                datasets: [{
                    data: [38.2, 61.2, 0.6],
                    backgroundColor: ['#28a745', '#e74c3c', '#007bff']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    function createBarChart() {
        var ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['شركة 1', 'شركة 2', 'شركة 3', 'شركة 4', 'شركة 5'],
                datasets: [
                    {
                        label: 'الإجمالي',
                        data: [450, 900, 300, 500, 700],
                        backgroundColor: '#42a5f5'
                    },
                    {
                        label: 'مدفوعة',
                        data: [300, 600, 200, 400, 500],
                        backgroundColor: '#28a745'
                    },
                    {
                        label: 'غير مدفوعة',
                        data: [150, 300, 100, 100, 200],
                        backgroundColor: '#e74c3c'
                    },
                    {
                        label: 'مرجع',
                        data: [0, 0, 0, 0, 0],
                        backgroundColor: '#007bff'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        const dropdownButton = document.getElementById('clientDropdown');

        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                const clientType = this.getAttribute('data-client-type');
                dropdownButton.innerHTML = `<i class="fa-solid fa-user"></i> ${this.textContent}`;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Get references to the buttons and tables
        const detailsButton = document.getElementById('detailsButton');
        const summaryButton = document.getElementById('summaryButton');
        const mainReportTable = document.getElementById('mainReportTable');
        const detailedTable = document.getElementById('detailedTable');

        // Details button click handler
        detailsButton.addEventListener('click', function() {
            mainReportTable.style.display = 'none';
            detailedTable.style.display = 'block';
        });

        // Summary button click handler
        summaryButton.addEventListener('click', function() {
            mainReportTable.style.display = 'block';
            detailedTable.style.display = 'none';
        });
    });
