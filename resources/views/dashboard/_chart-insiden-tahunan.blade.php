<div class="col-md-6">
    <div class="card card-custom card-stretch gutter-b chart-insiden-tahunan-wrapper">
        <div class="card-header h-auto py-3">
            <div class="card-title">
                <h3 class="card-label">
                    <span class="d-block text-dark font-weight-bolder">{{ __('Insiden Pertahun') }}</span>
                </h3>
            </div>
            <div class="card-toolbar" style="max-width: 500px;">
                <form id="filter-chart-insiden-tahunan" action="{{ route($routes . '.chart-insiden-tahunan') }}" class="form-inline"
                    role="form">
                    <div class="form-group row">
                        <div class="col-md-4 col-sm-12">
                            <input name="tahun" class="form-control base-plugin--datepicker-3 insiden-tahunan-tahun"
                                placeholder="{{ __('Tahun') }}" style="max-width: 7em"
                                value="{{ now()->format('Y') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-wrapper">
                <div id="chart-insiden-tahunan">
                    <div class="d-flex h-100">
                        <div class="spinners m-auto my-auto">
                            <div class="spinner-grow text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow text-danger" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="spinner-grow text-warning" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .chart-insiden-tahunan-wrapper .apexcharts-menu-item.exportSVG,
        .chart-insiden-tahunan-wrapper .apexcharts-menu-item.exportCSV {
            display: none;
        }

        .chart-insiden-tahunan-wrapper .apexcharts-title-text {
            white-space: normal;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            drawChartInsidenTahunan();
            $('.content-page').on('change', '.insiden-tahunan-tahun, .insiden-tahunan-tahunan-bulan', function() {
                drawChartInsidenTahunan();
            });
        });

        var drawChartInsidenTahunan = function() {
            var filter = $('#filter-chart-insiden-tahunan');

            $.ajax({
                url: filter.attr('action'),
                method: 'POST',
                data: {
                    _token: BaseUtil.getToken(),
                    tahun: filter.find('.insiden-tahunan-tahun').val(),
                    bulan: filter.find('.pemasukan-tahunan-bulan').val(),
                },
                success: function(resp) {
                    $('.chart-insiden-tahunan-wrapper .chart-wrapper').find('#chart-insiden-tahunan').remove();
                    $('.chart-insiden-tahunan-wrapper .chart-wrapper').html(`<div id="chart-insiden-tahunan"></div>`);
                    renderChartInsidenTahunan(resp);
                },
                error: function(resp) {
                    console.log(resp);
                    // window.location = '{{ url('login') }}';
                }
            });
        }

        var renderChartInsidenTahunan = function(options = {}) {
            var element = document.getElementById('chart-insiden-tahunan');

            var defaultsOptions = {
                title: {
                    text: options.title.text ?? 'Pemasukan Tahunan',
                    align: 'center',
                    style: {
                        fontSize: '18px',
                        fontWeight: '500',
                    },
                },
                series: options.series ?? [],
                chart: {
                    type: 'line',
                    height: '400px',
                    stacked: true,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                            customIcons: []
                        },
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: ['25%'],
                        endingShape: 'rounded'
                    },
                },
                legend: {
                    position: 'top',
                    offsetY: 2
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: [4, 0, 0, 0, 0, 0],
                    curve: 'smooth'
                    // colors: ['transparent']
                },
                xaxis: {
                    categories: options.xaxis.categories ?? [],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                fill: {
                    opacity: [0.3, 1, 1, 1, 1, 1],
                    gradient: {
                        inverseColors: false,
                        shade: 'light',
                        type: "vertical",
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                },
                grid: {
                    borderColor: KTApp.getSettings()['colors']['gray']['gray-200'],
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                noData: {
                    text: 'Loading...'
                }
            };

            var chart = new ApexCharts(element, defaultsOptions);
            chart.render();
        }
    </script>
@endpush
