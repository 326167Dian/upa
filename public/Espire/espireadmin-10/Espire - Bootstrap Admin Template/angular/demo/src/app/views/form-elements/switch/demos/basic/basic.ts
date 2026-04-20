import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-switch-basic',
    templateUrl: './basic.html'
})
export class DemoSwitchBasicComponent implements OnInit {
    value = false;

    constructor() { }

    ngOnInit(): void { }
}
