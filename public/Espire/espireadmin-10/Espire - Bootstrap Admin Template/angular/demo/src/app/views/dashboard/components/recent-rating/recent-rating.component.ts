import { Component, OnInit, Input } from '@angular/core';
import { RecentReviewData } from '../../dashboard.type';

@Component({
    selector: 'recent-rating',
    templateUrl: './recent-rating.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class RecentRatingComponent implements OnInit {

    @Input() data: RecentReviewData[]
    maxRate: number[] = [1,2,3,4,5]

    constructor() { }

    ngOnInit(): void { }
}
