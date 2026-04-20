import { Component, OnInit, ViewChild } from "@angular/core";
import {
    COLOR_1,
    COLOR_2,
    COLOR_3,
    COLOR_4
} from '@app/configs/chart.config';
import {
    ApexAxisChartSeries,
    ApexChart,
    ChartComponent,
    ApexDataLabels,
    ApexPlotOptions,
    ApexResponsive,
    ApexXAxis,
    ApexLegend,
    ApexFill
} from "ng-apexcharts";

export type ChartOptions = {
    series: ApexAxisChartSeries;
    chart: ApexChart;
    dataLabels: ApexDataLabels;
    plotOptions: ApexPlotOptions;
    responsive: ApexResponsive[];
    xaxis: ApexXAxis;
    legend: ApexLegend;
    fill: ApexFill;
};

@Component({
    selector: 'demo-apex-stack-column',
    templateUrl: './stack-column.html',
})
export class DemoApexStackColumnComponent implements OnInit {
    @ViewChild("stack-column") chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    constructor() {
        this.chartOptions = {
            series: [
                {
                    name: "PRODUCT A",
                    data: [44, 55, 41, 67, 22, 43],
                    color: COLOR_1
                },
                {
                    name: "PRODUCT B",
                    data: [13, 23, 20, 8, 13, 27],
                    color: COLOR_2
                },
                {
                    name: "PRODUCT C",
                    data: [11, 17, 15, 15, 21, 14],
                    color: COLOR_3
                },
                {
                    name: "PRODUCT D",
                    data: [21, 7, 25, 13, 22, 8],
                    color: COLOR_4
                }
            ],
            chart: {
                type: "bar",
                height: 350,
                stacked: true,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: "bottom",
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }
            ],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20px'
                }
            },
            xaxis: {
                type: "category",
                categories: [
                    "01/2011",
                    "02/2011",
                    "03/2011",
                    "04/2011",
                    "05/2011",
                    "06/2011"
                ]
            },
            legend: {
                position: "right",
                offsetY: 40
            },
            fill: {
                opacity: 1
            }
        };
    }

    ngOnInit(): void { }
}
