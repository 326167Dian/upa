import { Component, OnInit, ViewChild } from "@angular/core";
import { ChartComponent } from "ng-apexcharts";
import { 
    ApexChartDefault, 
    COLORS
} from '@app/configs/chart.config';
import {
  ApexNonAxisChartSeries,
  ApexResponsive,
  ApexChart
} from "ng-apexcharts";

export type ChartOptions = {
  series: ApexNonAxisChartSeries;
  chart: ApexChart;
  responsive: ApexResponsive[];
  labels: any;
};

@Component({
    selector: 'demo-apex-donut',
    templateUrl: './donut.html'
})
export class DemoApexDonutComponent implements OnInit {
    @ViewChild("donut") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    donutColors: string[] = COLORS

    constructor() {
        this.chartOptions = {
            series: [44, 55, 13, 43, 22],
            chart: {
                ...ApexChartDefault,
                type: "donut"
            },
            labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            ]
        };
    }

    ngOnInit(): void { }
}
