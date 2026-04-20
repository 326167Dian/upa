import { Component, OnInit, Input } from '@angular/core';
import { DeviceStatisticData } from '../../dashboard.type';

@Component({
    selector: 'device-satistic',
    templateUrl: './device-statistic.component.html',
    host: {
        '[class.card]': 'true'
    }
})
export class DeviceStatisticComponent implements OnInit {

    @Input() data: DeviceStatisticData[]

    progressType: string[] = ['danger', 'warning', 'info', 'primary', 'light']

    constructor() { }

    ngOnInit(): void { }
}
