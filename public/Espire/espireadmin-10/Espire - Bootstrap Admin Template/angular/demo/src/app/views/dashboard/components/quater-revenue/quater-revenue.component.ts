import { Component, OnInit, Input } from '@angular/core';

@Component({
    selector: 'quater-revenue',
    templateUrl: './quater-revenue.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class QuaterRevenueComponent implements OnInit {

    @Input() value: string

    constructor() { }

    ngOnInit(): void { }
}
