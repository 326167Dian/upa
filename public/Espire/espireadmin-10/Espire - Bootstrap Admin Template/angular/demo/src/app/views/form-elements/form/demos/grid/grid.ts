import { Component, OnInit } from '@angular/core';

@Component({
    selector: 'demo-form-grid',
    templateUrl: './grid.html',
    styles: [`
        .row {
            max-width: 600px;
        }
    `]
})
export class DemoFormGridComponent implements OnInit {
    constructor() { }

    ngOnInit(): void { }
}
