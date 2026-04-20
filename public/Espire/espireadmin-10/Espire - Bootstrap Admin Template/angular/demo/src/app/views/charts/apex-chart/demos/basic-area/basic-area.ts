import { Component, OnInit, ViewChild } from "@angular/core";
import { 
    ApexStrokeDefault, 
    ApexChartDefault, 
    ApexDataLabelDefault,
    COLOR_1
} from '@app/configs/chart.config';
import {
  ChartComponent,
  ApexAxisChartSeries,
  ApexChart,
  ApexXAxis,
  ApexDataLabels,
  ApexStroke,
  ApexYAxis,
  ApexTitleSubtitle,
  ApexLegend
} from "ng-apexcharts";

import { series } from "./data";

export type ChartOptions = {
    series: ApexAxisChartSeries;
    chart: ApexChart;
    xaxis: ApexXAxis;
    stroke: ApexStroke;
    dataLabels: ApexDataLabels;
    yaxis: ApexYAxis;
    title: ApexTitleSubtitle;
    labels: string[];
    legend: ApexLegend;
    subtitle: ApexTitleSubtitle
};

@Component({
    selector: 'demo-apex-basic-area',
    templateUrl: 'basic-area.html',
})
export class DemoApexBasicAreaComponent implements OnInit {
    @ViewChild("basic-area") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
            series: [
                {
                    name: "STOCK ABC",
                    data: series.monthDataSeries1.prices,
                    color: COLOR_1
                }
            ],
            chart: {
                ...ApexChartDefault,
                type: "area",
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            dataLabels: ApexDataLabelDefault,
            title: {
                text: "Fundamental Analysis of Stocks",
                align: "left"
            },
            subtitle: {
                text: "Price Movements",
                align: "left"
            },
            labels: series.monthDataSeries1.dates,
            xaxis: {
                type: "datetime"
            },
            yaxis: {
                opposite: true
            },
            legend: {
                horizontalAlign: "left"
            },
            stroke: ApexStrokeDefault
        };
    }

    ngOnInit(): void { }
}
