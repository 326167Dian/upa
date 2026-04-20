import { Component, OnInit, Input, SimpleChanges } from '@angular/core';
import { RecentTransactionData } from '../../dashboard.type';

@Component({
    selector: 'recent-transaction',
    templateUrl: './recent-transaction.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class RecentTransactionComponent implements OnInit {

    @Input() data: RecentTransactionData

    constructor() { }

    ngOnInit(): void { }

    getBadgeColor(status: string) {
        switch (status) {
            case 'Approved':
                return '#00c569';
            case 'Pending':
                return '#ffc833';
            case 'Rejected':
                return '#f46363'
            default:
                return '#edf4f9';
        }
    }
}
