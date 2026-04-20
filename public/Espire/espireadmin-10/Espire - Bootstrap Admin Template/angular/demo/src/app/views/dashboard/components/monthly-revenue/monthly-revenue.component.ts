import { Component, OnInit, Input } from '@angular/core';

@Component({
    selector: 'monthly-revenue',
    templateUrl: './monthly-revenue.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class MonthlyRevenueComponent implements OnInit {
    constructor() { }

    @Input() value:string
    @Input() pnl:string

    ngOnInit(): void { }
}
