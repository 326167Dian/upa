import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-checkbox-inline',
    templateUrl: 'inline.html'
})

export class DemoCheckboxInlineComponent implements OnInit {

    selectedFramework: string[] = []

    constructor() { }

    ngOnInit() { }
}