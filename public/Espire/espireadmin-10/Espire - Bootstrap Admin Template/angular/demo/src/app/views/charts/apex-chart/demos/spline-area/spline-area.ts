import { Component, OnInit , ViewChild } from "@angular/core";
import { 
    ApexStrokeDefault, 
    ApexChartDefault, 
    ApexDataLabelDefault,
    COLOR_1,
    COLOR_2
} from '@app/configs/chart.config';
import {
  ChartComponent,
  ApexAxisChartSeries,
  ApexChart,
  ApexXAxis,
  ApexDataLabels,
  ApexTooltip,
  ApexStroke
} from "ng-apexcharts";

export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  xaxis: ApexXAxis;
  stroke: ApexStroke;
  tooltip: ApexTooltip;
  dataLabels: ApexDataLabels;
};

@Component({
    selector: 'demo-apex-spline-area',
    templateUrl: './spline-area.html',
})
export class DemoApexSplineAreaComponent implements OnInit {
    @ViewChild("spline-area") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
        series: [
                {
                    name: "series1",
                    data: [31, 40, 28, 51, 42, 109, 100],
                    color: COLOR_1
                },
                {
                    name: "series2",
                    data: [11, 32, 45, 32, 34, 52, 41],
                    color: COLOR_2
                }
            ],
            chart: {
                ...ApexChartDefault,
                height: 350,
                type: "area"
            },
            dataLabels: ApexDataLabelDefault,
            stroke: ApexStrokeDefault,
            xaxis: {
                type: "datetime",
                categories: [
                    "2018-09-19T00:00:00.000Z",
                    "2018-09-19T01:30:00.000Z",
                    "2018-09-19T02:30:00.000Z",
                    "2018-09-19T03:30:00.000Z",
                    "2018-09-19T04:30:00.000Z",
                    "2018-09-19T05:30:00.000Z",
                    "2018-09-19T06:30:00.000Z"
                ]
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm"
                }
            }
        };
    }

    public generateData(baseval, count, yrange) {
        let i = 0;
        let series = [];
        while (i < count) {
            let x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;
            let y =
                Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            let z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;
            series.push([x, y, z]);
            baseval += 86400000;
            i++;
        }
        return series;
  } 

    ngOnInit(): void { }
}
