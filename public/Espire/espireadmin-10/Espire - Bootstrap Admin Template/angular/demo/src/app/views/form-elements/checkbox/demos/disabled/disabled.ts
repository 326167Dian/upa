import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-checkbox-disabled',
    templateUrl: 'disabled.html'
})

export class DemoCheckboxDisabaledComponent implements OnInit {

    flexCheckDisabled: string[] = ['2']

    constructor() { }

    ngOnInit() { }
}