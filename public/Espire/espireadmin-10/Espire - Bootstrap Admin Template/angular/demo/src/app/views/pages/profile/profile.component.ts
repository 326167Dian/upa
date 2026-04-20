import { Component, OnInit } from '@angular/core';

interface PanelMenu {
    title: string,
    icon: string
}

@Component({
    selector: 'profile',
    templateUrl: './profile.component.html',
})

export class ProfileComponent implements OnInit {

    panelMenu : PanelMenu[] = [
        {
            title: 'Personal',
            icon: 'icon-user'
        },
        {
            title: 'Notification',
            icon: 'icon-bell'
        },
        {
            title: 'Security',
            icon: 'icon-lock'
        },
        {
            title: 'Connect',
            icon: 'icon-link-2'
        }
    ]

    currentPanel: string = 'Personal';

    constructor() { }

    ngOnInit(): void { }

    onPanelChange (seletedPanel: string) {
        this.currentPanel = seletedPanel
    }
}
