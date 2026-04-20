import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-input-sizing',
    templateUrl: './sizing.html',
    styles: [`
        .form-control {
            margin-bottom: 15px
        }
    `]
})
export class DemoInputSizingComponent implements OnInit {
    constructor() { }

    ngOnInit(): void { }
}
