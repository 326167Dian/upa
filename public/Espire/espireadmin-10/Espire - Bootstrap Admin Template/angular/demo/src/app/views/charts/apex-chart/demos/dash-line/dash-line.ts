import { Component, OnInit, ViewChild } from "@angular/core";
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
} from "ng-apexcharts";

export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  xaxis: ApexXAxis;
  stroke: ApexStroke;
  dataLabels: ApexDataLabels;
  markers: ApexMarkers;
  tooltip: any; // ApexTooltip;
  yaxis: ApexYAxis;
  grid: ApexGrid;
  legend: ApexLegend;
  title: ApexTitleSubtitle;
  color: string[]
};

@Component({
    selector: 'demo-apex-dash-line',
    templateUrl: './dash-line.html'
})
export class DemoApexDashLineComponent implements OnInit {
    @ViewChild("dash-line") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
            series: [
            {
                name: "Session Duration",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
            },
            {
                name: "Page Views",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            },
            {
                name: "Total Visits",
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
            }
            ],
            chart: {
                ...ApexChartDefault,
                height: 350,
                type: "line"
            },
            dataLabels: ApexDataLabelDefault,
            stroke: {
                ...ApexStrokeDefault,
                dashArray: [0, 8, 5]
            },
            title: {
                text: "Page Statistics",
                align: "left"
            },
            color: ApexColorDefault,
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return (
                        val +
                        " - <strong>" +
                        opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
                        "</strong>"
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
                categories: [
                    "01 Jan",
                    "02 Jan",
                    "03 Jan",
                    "04 Jan",
                    "05 Jan",
                    "06 Jan",
                    "07 Jan",
                    "08 Jan",
                    "09 Jan",
                    "10 Jan",
                    "11 Jan",
                    "12 Jan"
                ]
            },
            tooltip: {
                y: [
                    {
                    title: {
                        formatter: function(val) {
                            return val + " (mins)";
                        }
                    }
                    },
                    {
                    title: {
                        formatter: function(val) {
                            return val + " per session";
                        }
                    }
                    },
                    {
                    title: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                    }
                ]
            }
        };
    }

    ngOnInit(): void { }
}
