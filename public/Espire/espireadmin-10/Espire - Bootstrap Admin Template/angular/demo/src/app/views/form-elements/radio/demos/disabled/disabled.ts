import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-radio-disabled',
    templateUrl: 'disabled.html'
})

export class DemoRadioDisabledComponent implements OnInit {
    constructor() { }

    ngOnInit() { }

    value: string = '4'
}