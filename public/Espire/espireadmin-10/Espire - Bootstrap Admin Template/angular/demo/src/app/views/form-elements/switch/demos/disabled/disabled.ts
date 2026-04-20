import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-switch-disabled',
    templateUrl: 'disabled.html'
})

export class DemoSwitchDisabledComponent implements OnInit {

    value1: boolean = false
    value2: boolean = true

    constructor() { }

    ngOnInit() { }
}