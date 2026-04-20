import { Component, OnInit, ViewChild } from "@angular/core";
import { 
    ApexChartDefault, 
    ApexDataLabelDefault,
    COLOR_1
} from '@app/configs/chart.config';
import {
  ApexAxisChartSeries,
  ApexChart,
  ChartComponent,
  ApexDataLabels,
  ApexXAxis,
  ApexPlotOptions
} from "ng-apexcharts";

export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  dataLabels: ApexDataLabels;
  plotOptions: ApexPlotOptions;
  xaxis: ApexXAxis;
};

@Component({
    selector: 'demo-apex-basic-bar',
    templateUrl: './basic-bar.html'
})
export class DemoApexBasicBarComponent implements OnInit {
    @ViewChild("basic-bar") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
            series: [
                {
                    name: "basic",
                    data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380],
                    color: COLOR_1
                }
            ],
            chart: {
                ...ApexChartDefault,
                type: "bar",
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }
            },
            dataLabels: ApexDataLabelDefault,
            xaxis: {
                categories: [
                    "South Korea",
                    "Canada",
                    "United Kingdom",
                    "Netherlands",
                    "Italy",
                    "France",
                    "Japan",
                    "United States",
                    "China",
                    "Germany"
                ]
            }
        };
    }
    ngOnInit(): void { }
}
