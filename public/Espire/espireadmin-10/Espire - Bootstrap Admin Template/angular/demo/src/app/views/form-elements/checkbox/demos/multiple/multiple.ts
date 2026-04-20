import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-checkbox-multiple',
    templateUrl: 'multiple.html'
})

export class DemoCheckBoxMultipleComponent implements OnInit {
    selectedFramework: string[] = [];

    constructor() { }

    ngOnInit() { }
}