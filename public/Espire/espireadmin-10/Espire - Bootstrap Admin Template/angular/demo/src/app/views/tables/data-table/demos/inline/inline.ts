import { Component, OnInit } from '@angular/core';
import { ColumnMode } from '@swimlane/ngx-datatable';

@Component({
    selector: 'demo-data-table-inline',
    templateUrl: 'inline.html'
})

export class DemoDataTableInlineComponent implements OnInit {

    rows = [
        { name: 'Austin', gender: 'Male', age: 15 },
        { name: 'Dany', gender: 'Male', age: 87 },
        { name: 'Molly', gender: 'Female', age: 35 }
    ];
    joke = 'knock knock';

    ColumnMode = ColumnMode;


    constructor() { }

    ngOnInit() { }
}