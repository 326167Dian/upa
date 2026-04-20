import { Component, Inject, NgZone, PLATFORM_ID, AfterViewInit } from '@angular/core';
import { isPlatformBrowser } from '@angular/common';
import * as am4core from '@amcharts/amcharts4/core';
import * as am4maps from '@amcharts/amcharts4/maps';
import am4geodata_worldHigh from '@amcharts/amcharts4-geodata/worldHigh';
import am4themes_animated from '@amcharts/amcharts4/themes/animated';

@Component({
    selector: 'demo-ammap-weather',
    templateUrl: './weather.html',
})
export class DemoAmMapWeatherComponent implements AfterViewInit {
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
            let chart = am4core.create('weaTher', am4maps.MapChart);

            // Set map definition
            chart.geodata = am4geodata_worldHigh;

            // Set projection
            chart.projection = new am4maps.projections.Mercator();

            // Center on the groups by default
            chart.homeZoomLevel = 6;
            chart.homeGeoPoint = { longitude: 10, latitude: 51 };

            // Polygon series
            let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.exclude = ['AQ'];
            polygonSeries.useGeodata = true;
            polygonSeries.nonScalingStroke = true;
            polygonSeries.strokeOpacity = 0.5;

            // Image series
            let imageSeries = chart.series.push(new am4maps.MapImageSeries());
            let imageTemplate = imageSeries.mapImages.template;
            imageTemplate.propertyFields.longitude = 'longitude';
            imageTemplate.propertyFields.latitude = 'latitude';
            imageTemplate.nonScaling = true;

            let image = imageTemplate.createChild(am4core.Image);
            image.propertyFields.href = 'imageURL';
            image.width = 50;
            image.height = 50;
            image.horizontalCenter = 'middle';
            image.verticalCenter = 'middle';

            let label = imageTemplate.createChild(am4core.Label);
            label.text = '{label}';
            label.horizontalCenter = 'middle';
            label.verticalCenter = 'top';
            label.dy = 20;

            imageSeries.data = [{
                'latitude': 40.416775,
                'longitude': -3.703790,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg',
                'width': 32,
                'height': 32,
                'label': 'Madrid: +22C'
            }, {
                'latitude': 48.856614,
                'longitude': 2.352222,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/thunder.svg',
                'width': 32,
                'height': 32,
                'label': 'Paris: +18C'
            }, {
                'latitude': 52.520007,
                'longitude': 13.404954,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/cloudy-day-1.svg',
                'width': 32,
                'height': 32,
                'label': 'Berlin: +13C'
            }, {
                'latitude': 52.229676,
                'longitude': 21.012229,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/day.svg',
                'width': 32,
                'height': 32,
                'label': 'Warsaw: +22C'
            }, {
                'latitude': 41.872389,
                'longitude': 12.480180,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/day.svg',
                'width': 32,
                'height': 32,
                'label': 'Rome: +29C'
            }, {
                'latitude': 51.507351,
                'longitude': -0.127758,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/rainy-7.svg',
                'width': 32,
                'height': 32,
                'label': 'London: +10C'
            }, {
                'latitude': 59.329323,
                'longitude': 18.068581,
                'imageURL': 'https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg',
                'width': 32,
                'height': 32,
                'label': 'Stockholm: +8C'
            } ];

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