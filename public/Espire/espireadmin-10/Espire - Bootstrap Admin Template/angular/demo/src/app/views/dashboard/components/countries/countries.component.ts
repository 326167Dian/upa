import { Component, OnInit, Input } from '@angular/core';
import { CountriesData } from '../../dashboard.type';

@Component({
    selector: 'countries',
    templateUrl: 'countries.component.html',
    host: {
        '[class.card]': 'true'
    }
})

export class CountriesComponent implements OnInit {

    @Input() data: CountriesData[]

    constructor() { }

    ngOnInit() { }
}