import { Component, Inject, NgZone, PLATFORM_ID, AfterViewInit } from '@angular/core';
import { isPlatformBrowser } from '@angular/common';
import * as am4core from '@amcharts/amcharts4/core';
import * as am4maps from '@amcharts/amcharts4/maps';
import am4geodata_worldLow from '@amcharts/amcharts4-geodata/worldLow';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';

@Component({
    selector: 'demo-ammap-pacific-centered',
    templateUrl: './pacific-centered.html',
})
export class DemoAmMapPacificCenteredComponent implements AfterViewInit {
    private map: am4maps.MapChart;

    constructor(@Inject(PLATFORM_ID) private platformId, private zone: NgZone) {}

    browserOnly(f: () => void) {
        if (isPlatformBrowser(this.platformId)) {
            this.zone.runOutsideAngular(() => {
                f();
            });
        }
    }
    
    ngAfterViewInit() {
        // Chart code goes in here
        this.browserOnly(() => {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create map instance
            let chart = am4core.create('pacificCentered', am4maps.MapChart);

            chart.geodata = am4geodata_worldLow;

            // Set projection
            chart.projection = new am4maps.projections.NaturalEarth1();
            chart.panBehavior = 'rotateLong';

            // Create map polygon series
            let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

            // Make map load polygon (like country names) data from GeoJSON
            polygonSeries.useGeodata = true;

            polygonSeries.mapPolygons.template.fillOpacity = 0.6;
            polygonSeries.mapPolygons.template.nonScalingStroke = true;
            polygonSeries.mapPolygons.template.strokeWidth = 0.5;
            polygonSeries.mapPolygons.template.adapter.add('fill', function(fill, target) {
                return chart.colors.getIndex(Math.round(Math.random() * 4)).saturate(0.3);
            })

            // Configure series
            let polygonTemplate = polygonSeries.mapPolygons.template;
            polygonTemplate.tooltipText = '{name}';

            // Create hover state and set alternative fill color
            let hs = polygonTemplate.states.create('hover');
            hs.properties.fill = chart.colors.getIndex(1);

            // Center on Pacic
            chart.deltaLongitude = -154.8;

            let graticuleSeries = chart.series.push(new am4maps.GraticuleSeries());
            graticuleSeries.fitExtent = false;
            this.map = chart
        });
      }
    
    ngOnDestroy() {
        // Clean up chart when the component is removed
        this.browserOnly(() => {
            if (this.map) {
                this.map.dispose();
            }
        });
    }
}