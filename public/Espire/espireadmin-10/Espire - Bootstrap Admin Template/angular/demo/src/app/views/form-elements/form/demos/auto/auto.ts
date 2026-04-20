import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-form-auto',
    templateUrl: './auto.html'
})
export class DemoFormAutoComponent implements OnInit {

    checkbox: boolean = false

    constructor() { }

    ngOnInit(): void { }
}
