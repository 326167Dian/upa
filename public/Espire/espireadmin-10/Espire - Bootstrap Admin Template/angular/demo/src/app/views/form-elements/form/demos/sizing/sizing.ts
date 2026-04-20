import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-form-sizing',
    templateUrl: './sizing.html',
    styles: [`
        .row {
            max-width: 600px;
        }
    `]
})
export class DemoFormSizingComponent implements OnInit {
    constructor() { }

    ngOnInit(): void { }
}
