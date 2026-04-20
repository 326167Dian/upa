import { Component, OnInit, ViewChild, ChangeDetectorRef } from '@angular/core';
import { DashboardService } from './dashboard.service';
import { Subscription } from 'rxjs';
import { 
    RegionData, 
    OverviewData, 
    RecentTransactionData, 
    RecentReviewData, 
    DeviceStatisticData, 
    CountriesData 
} from './dashboard.type';
import { 
    ApexBarDefault,
    ApexChartDefault, 
    ApexDataLabelDefault,
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
    ApexYAxis,
    ApexLegend,
    ApexStroke,
    ApexXAxis,
    ApexFill,
    ApexTooltip
} from 'ng-apexcharts';

const colors = [COLOR_1, COLOR_2, COLOR_3, COLOR_4]

export type ChartOptions = {
    series: ApexAxisChartSeries;
    chart: ApexChart;
    dataLabels: ApexDataLabels;
    plotOptions: ApexPlotOptions;
    yaxis: ApexYAxis;
    xaxis: ApexXAxis;
    fill: ApexFill;
    tooltip: ApexTooltip;
    stroke: ApexStroke;
    legend: ApexLegend;
};
 
@Component({
    selector: 'dashboard',
    templateUrl: './dashboard.component.html',
})
export class DashboardComponent implements OnInit {

    @ViewChild('monthly-revenue-chart') chart: ChartComponent;
    monthlyRevenueChart: Partial<ChartOptions>;
    regionMapData: RegionData[]
    overviewData: OverviewData
    recentTransactionData: RecentTransactionData[]
    recentReviewData: RecentReviewData[]
    deviceStatisticData: DeviceStatisticData[]
    countriesData: CountriesData[]
    private _subscriptions: Subscription[] = [];

    subscription: Subscription

    constructor(private dashboardSvc: DashboardService, private cdr: ChangeDetectorRef) {}

    ngOnInit(): void {
        this._subscriptions.push(
            this.initMonthlyRevenueChart(),
            this.initRegionData(),
            this.initRecentTransactionData(),
            this.initRecentRatingData(),
            this.initDeviceStatisticData(),
            this.initCountriesData(),
            this.initOverviewData(),
        )
    }

    initMonthlyRevenueChart () {
        this.monthlyRevenueChart = {
            series: [],
            chart: {
                ...ApexChartDefault,
                type: 'bar',
                height: 100,
                sparkline: {
                    enabled: true
                },
            },
            plotOptions: ApexBarDefault,
            dataLabels: ApexDataLabelDefault,
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct']
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return '$ ' + val + ' thousands';
                    }
                }
            }
        };

        return this.dashboardSvc.getMonthlyRevenueChartData().subscribe(res => {
            const data = res
            this.monthlyRevenueChart.series = data.map((elm, i) => {
                elm.color = colors[i]
                return elm
            })
            this.cdr.markForCheck();
        })
    }

    initRegionData() {
        return this.dashboardSvc.getRegionMapData().subscribe(res => {
            this.regionMapData = res
            this.cdr.markForCheck();
        })
    }

    initOverviewData() {
        return this.dashboardSvc.getOverviewData().subscribe(res => {
            this.overviewData = res
            this.cdr.markForCheck();
        })
    }

    initRecentTransactionData() {
        return this.dashboardSvc.getRecentTransactionData().subscribe(res => {
            this.recentTransactionData = res
            this.cdr.markForCheck();
        })
    }
    
    initRecentRatingData() {
        return this.dashboardSvc.getRecentRatingData().subscribe(res => {
            this.recentReviewData = res
            this.cdr.markForCheck();
        })
    }

    initDeviceStatisticData() {
        return this.dashboardSvc.getDeviceSatisticData().subscribe(res => {
            this.deviceStatisticData = res
            this.cdr.markForCheck();
        })
    }

    initCountriesData() {
        return this.dashboardSvc.getCountriesData().subscribe(res => {
            this.countriesData = res
            this.cdr.markForCheck();
        })
    }

    ngOnDestroy() {
        this._subscriptions.forEach(elm => {
            elm.unsubscribe()
        })
    }
}
