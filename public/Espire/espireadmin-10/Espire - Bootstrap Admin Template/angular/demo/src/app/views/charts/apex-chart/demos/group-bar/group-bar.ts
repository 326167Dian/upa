import { Component, OnInit, ViewChild } from "@angular/core";
import { 
    ApexChartDefault, 
    COLOR_1,
    COLOR_2
} from '@app/configs/chart.config';
import {
  ApexAxisChartSeries,
  ApexChart,
  ChartComponent,
  ApexDataLabels,
  ApexXAxis,
  ApexPlotOptions,
  ApexStroke
} from "ng-apexcharts";

export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  dataLabels: ApexDataLabels;
  plotOptions: ApexPlotOptions;
  xaxis: ApexXAxis;
  stroke: ApexStroke;
};

@Component({
    selector: 'demo-apex-group-bar',
    templateUrl: './group-bar.html'
})
export class DemoApexGroupBarComponent implements OnInit {
    @ViewChild("group-bar") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
            series: [
                {
                    name: "serie1",
                    data: [44, 55, 41, 64, 22, 43, 21],
                    color: COLOR_1
                },
                {
                    name: "serie2",

                    data: [53, 32, 33, 52, 13, 44, 32],
                    color: COLOR_2
                }
            ],
            chart: {
                ...ApexChartDefault,
                type: "bar",
                height: 430
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    dataLabels: {
                        position: "top"
                    }
                }
            },
            dataLabels: {
                enabled: true,
                offsetX: -6,
                style: {
                    fontSize: "12px",
                    colors: ["#fff"]
                }
            },
            stroke: {
                show: true,
                width: 1,
                colors: ["#fff"]
            },
            xaxis: {
                categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007]
            }
        };
    }

    ngOnInit(): void { }
}
