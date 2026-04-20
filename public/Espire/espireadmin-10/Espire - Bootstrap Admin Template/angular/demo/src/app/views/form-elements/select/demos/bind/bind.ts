import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-select-bind',
    templateUrl: 'bind.html'
})

export class DemoSelectBindComponent implements OnInit {

    defaultBindingsList = [
        { value: 1, label: 'Vilnius' },
        { value: 2, label: 'Kaunas' },
        { value: 3, label: 'Pavilnys', disabled: true }
    ];

    selectedCity = null;

    constructor() { }

    ngOnInit() {
        this.selectedCity = this.defaultBindingsList[0];
    }
}