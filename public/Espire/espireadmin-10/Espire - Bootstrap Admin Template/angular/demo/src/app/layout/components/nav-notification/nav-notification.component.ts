import { Component, OnInit, ChangeDetectionStrategy } from '@angular/core';
import { NotificationService } from '@app/shared/services/notification.service';
import { TimeSince } from '@app/shared/utils/TimeSince'

@Component({
    selector: 'nav-notification',
    templateUrl: './nav-notification.component.html',
    changeDetection: ChangeDetectionStrategy.OnPush,
    host: {
        '[class.header-nav-item]': 'true'
    },
    providers: [
        NotificationService
    ],
})
export class NavNotificationComponent implements OnInit {

    notificationList = [];
    notificationIconMap = {
        0: '',
        1: 'feather icon-info',
        2: 'feather icon-check-circle',
        3: 'feather icon-x-circle'
    }

    notificationColorMap = {
        0: '',
        1: 'bg-primary',
        2: 'bg-success',
        3: 'bg-danger'
    }

    constructor(private notificationSvc: NotificationService) {
        this.loadData();
    }
    
    loadData() {
        this.notificationSvc.getNotificationList().subscribe(data => {
            this.notificationList = [...data]
        });
    }

    getTimeDistance(time: number) {
        return TimeSince(time)
    }

    ngOnInit(): void {
    }
}
