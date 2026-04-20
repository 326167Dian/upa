import { Component, Input, OnInit, SimpleChanges, ViewChild } from '@angular/core';
import { OverviewData } from '../../dashboard.type';
import { 
    ApexStrokeDefault, 
    ApexChartDefault, 
    ApexDataLabelDefault,
    ApexColorDefault
} from '@app/configs/chart.config';
import {
  ChartComponent,
  ApexAxisChartSeries,
  ApexChart,
  ApexXAxis,
  ApexDataLabels,
  ApexStroke,
  ApexMarkers,
  ApexYAxis,
  ApexGrid,
  ApexTitleSubtitle,
  ApexLegend
} from 'ng-apexcharts';
 
export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  xaxis: ApexXAxis;
  stroke: ApexStroke;
  dataLabels: ApexDataLabels;
  markers: ApexMarkers;
  tooltip: any;
  yaxis: ApexYAxis;
  grid: ApexGrid;
  legend: ApexLegend;
  title: ApexTitleSubtitle;
  color: string[]
};
@Component({
    selector: 'overview',
    templateUrl: './overview-component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class OverviewComponent implements OnInit {
    @ViewChild('overviewChart') chart: ChartComponent;
    public overviewChartOptions: Partial<ChartOptions>;

    @Input() data: OverviewData
 
    constructor() {}

    ngOnInit(): void {
        this.initChart()
    }

    ngOnChanges(changes: SimpleChanges) {
        if (changes['data']) {
            this.initChart()
        }
    }

    initChart() {
        this.overviewChartOptions = {
            series: [
                {
                    name: 'Income',
                    data: []
                },
                {
                    name: 'Expense',
                    data: []
                }
            ],
            chart: {
                ...ApexChartDefault,
                height: 330,
                type: 'line'
            },
            dataLabels: ApexDataLabelDefault,
            stroke: {
                ...ApexStrokeDefault,
                dashArray: [0, 8, 5]
            },
            color: ApexColorDefault,
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return (
                        `${val} - <strong>$${opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex]} </strong>`                  
                    );
                }
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                labels: {
                    trim: false
                },
                categories: []
            },
            tooltip: {
                y: [
                    {
                        title: {
                            formatter: (val) => val
                        }
                    },
                    {
                        title: {
                            formatter: (val) => val
                        }
                    },
                    {
                        title: {
                            formatter: function(val) {
                                return `$${val}`;
                            }
                        }
                    }
                ]
            }
        };

        if(this.data) {
            
            this.overviewChartOptions.series[0].data = this.data.income
            this.overviewChartOptions.series[1].data = this.data.expense
            this.overviewChartOptions.xaxis.categories = this.data.duration
        }
    }
}
