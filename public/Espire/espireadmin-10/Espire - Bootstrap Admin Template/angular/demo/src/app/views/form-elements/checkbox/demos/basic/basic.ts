import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-checkbox-basic',
    templateUrl: 'basic.html'
})

export class DemoCheckboxBasicComponent implements OnInit {
    checked: boolean = false;
    constructor() { }

    ngOnInit() { }

    onChange() {
        console.log('current value:', this.checked)
    }
}