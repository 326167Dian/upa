import { Component, AfterViewInit, Input, SimpleChanges, ViewChild  } from '@angular/core';
import { ChartComponent } from 'ng-apexcharts';
import { 
    ApexChartDefault, 
    COLORS
} from '@app/configs/chart.config';
import {
  ApexNonAxisChartSeries,
  ApexResponsive,
  ApexPlotOptions,
  ApexChart,
  ApexLegend,
  ApexDataLabels
} from 'ng-apexcharts';
import * as am4core from '@amcharts/amcharts4/core';
import * as am4maps from '@amcharts/amcharts4/maps';
import am4geodata_usaLow from '@amcharts/amcharts4-geodata/usaLow';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';
import { COLOR_1, COLOR_2, COLOR_3, COLOR_4 } from '@app/configs/chart.config';
import { RegionData } from '../../dashboard.type';

const colors = [COLOR_1, COLOR_2, COLOR_3, COLOR_4]

type ChartOptions = {
    series: ApexNonAxisChartSeries;
    chart: ApexChart;
    legend: ApexLegend;
    responsive: ApexResponsive[];
    dataLabels: ApexDataLabels,
    plotOptions: ApexPlotOptions,
    labels: any;
};

@Component({
    selector: 'region-data',
    templateUrl: './region-data.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class RegionDataComponent implements AfterViewInit {

    private map: am4maps.MapChart;

    @Input() mapData: RegionData[]

    @ViewChild('region-data-chart') chart: ChartComponent;
    public chartOptions: Partial<ChartOptions>;

    donutColors: string[] = COLORS
 
    constructor() {    
    }

    initMap() {
        if(!this.mapData) {
            return
        }

        am4core.useTheme(am4themes_animated);
            let chart = am4core.create('region-data-map', am4maps.MapChart);

            chart.geodata = am4geodata_usaLow;
            chart.projection = new am4maps.projections.AlbersUsa();

            let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            let polygonTemplate = polygonSeries.mapPolygons.template;

            polygonTemplate.tooltipText = '{name}: {value}';
            polygonTemplate.nonScalingStroke = true;
            polygonTemplate.strokeWidth = 2;
            polygonTemplate.stroke = am4core.color('#bfd4e0')
            polygonTemplate.propertyFields.fill = 'fill';
            polygonTemplate.fill = am4core.color('#fff')
            polygonSeries.data = undefined
            
            if(this.mapData) {
                this.mapData = this.mapData.map((elm, i) => {
                    elm.fill = am4core.color(colors[i])
                    return elm
                })
                polygonSeries.data = [...this.mapData]
            }

            polygonSeries.useGeodata = true;
            this.map = chart
    }

    initChart() {
        this.chartOptions = {
            series: [],
            chart: {
                ...ApexChartDefault,
                type: 'donut'
            },
            labels: [],
            legend: {
                show: false,
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%'
                    }
                }
            }
        };
        if(this.mapData) {
            this.mapData.forEach((elm, i) => {
                this.chartOptions.series.push(elm.value)
                this.chartOptions.labels.push(elm.id)
            })
            
        }
    }

    ngOnChanges(changes: SimpleChanges) {
        if (changes['mapData']) {
            this.initMap()
            this.initChart()
        }
    }
    
    ngAfterViewInit() {
        this.initMap()
        this.initChart()
    }
    
    ngOnDestroy() {
        if (this.map) {
            this.map.dispose();
        }
    }
}
