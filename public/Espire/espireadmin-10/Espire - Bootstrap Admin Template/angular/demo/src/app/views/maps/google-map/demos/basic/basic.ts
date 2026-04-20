import { Component, OnInit } from "@angular/core";
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';

// Fill your google map api key here
const API_KEY = ''

@Component({
    selector: 'demo-google-map-basic',
    templateUrl: './basic.html',
})
export class DemoGoogleMapBasicComponent implements OnInit {
    apiLoaded: Observable<boolean>;

    options: google.maps.MapOptions = {
        center: {lat: 40, lng: -20},
        zoom: 4
    };

    constructor(httpClient: HttpClient) {
        this.apiLoaded = httpClient.jsonp(`https://maps.googleapis.com/maps/api/js?key=${API_KEY}`, 'callback').pipe(
            map(() => true),
            catchError(() => of(false)),
        );
    }

    ngOnInit(): void { }
}
